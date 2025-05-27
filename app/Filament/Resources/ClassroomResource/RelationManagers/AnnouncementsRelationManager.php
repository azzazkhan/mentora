<?php

namespace App\Filament\Resources\ClassroomResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Announcement\Models\Announcement;

class AnnouncementsRelationManager extends RelationManager
{
    protected static string $relationship = 'announcements';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('content')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'codeBlock',
                        'h2',
                        'h3',
                    ])
                    ->required()
                    ->columnSpanFull(),

                // Forms\Components\Repeater::make('attachments')
                //     ->relationship('attachments')
                //     ->simple(
                //         Forms\Components\FileUpload::make('path')
                //             ->directory('attachments')
                //             ->required(),
                //     )
                //     ->columnSpanFull()
                //     ->reorderable()
                //     // ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                //     //     $name = last(explode('/', $data['path']));
                //     //     $name = explode('.', $data['path']);
                //     //     array_pop($name);

                //     //     $data['name'] = implode('.', $name);
                //     //     $data['size'] = Storage::size($data['path']);
                //     //     $data['mime_type'] = Storage::mimeType($data['path']);
                //     //     $data['disk'] = config('filesystems.default');
                //     //     $data['user_id'] = Auth::user()->getKey();

                //     //     return $data;
                //     // })
                //     ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                //         $name = last(explode('/', $data['path']));
                //         $name = explode('.', $data['path']);
                //         array_pop($name);

                //         $data['name'] = implode('.', $name);
                //         $data['size'] = Storage::size($data['path']);
                //         $data['mime_type'] = Storage::mimeType($data['path']);
                //         $data['disk'] = config('filesystems.default');
                //         $data['user_id'] = Auth::user()->getKey();

                //         return $data;
                //     }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->tooltip(function (Announcement $record) {
                        return sprintf('%s (UTC)', carbon($record->created_at)->format('M jS Y \a\t g:i A'));
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->orderByDesc('announcements.id');
            });
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
