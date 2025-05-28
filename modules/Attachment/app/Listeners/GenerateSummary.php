<?php

namespace Modules\Attachment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Log;
use Modules\Attachment\Events\AttachmentCreated;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\ValueObjects\Messages\Support\Document;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class GenerateSummary implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AttachmentCreated $event): void
    {
        $mimes = [
            'pdf' => 'application/pdf',
            'javascript' => 'text/javascript',
            'python' => 'text/x-python',
            'txt' => 'text/plain',
            'html' => 'text/html',
            'css' => 'text/css',
            'md' => 'text/md',
            'csv' => 'text/csv',
            'xml' => 'text/xml',
            'rtf' => 'text/rtf',
        ];

        if (! in_array($event->attachment->mime_type, $mimes)) {
            return;
        }

        $response = Prism::text()
            ->using(Provider::Gemini, 'gemini-2.0-flash')
            ->withMessages([
                new UserMessage($this->getPrompt(), [
                    Document::fromBase64(base64_encode(Storage::disk($event->attachment->disk)->get($event->attachment->path)), $event->attachment->mime_type),
                ]),
            ])
            ->asText();

        $event->attachment->summary()->create([
            'content' => $response->text,
        ]);

        Log::debug($response->text, [
            'assignment' => $event->attachment->uuid,
        ]);
    }

    private function getPrompt()
    {
        return <<<'PROMPT'
        You are an educational assistant for the Mentora platform, helping instructors quickly understand student-submitted assignments.

        Your task is to read the attached document and generate a concise, well-structured summary of the content. Focus on:

        - The main topic and objective of the assignment.
        - Key arguments, ideas, or findings presented by the student.
        - Any notable data, examples, or conclusions.
        - The overall structure and flow of the content.
        - The student's writing clarity and coherence.

        The summary should be written in formal, academic tone and be no longer than 250 words.

        If the document is irrelevant, mostly blank, or contains only metadata (like a cover page), state clearly:
        **“The uploaded document does not contain substantial assignment content to summarize.”**

        Now, read the document and provide the summary.
        PROMPT;
    }
}
