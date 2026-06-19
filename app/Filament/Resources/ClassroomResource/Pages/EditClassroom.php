<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Modules\Classroom\Models\Classroom;

class EditClassroom extends EditRecord
{
    protected static string $resource = ClassroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('livestream')
                ->label('Livestream')
                ->url(fn(Classroom $record) => route('livestream.show', $record))
                ->icon('heroicon-o-video-camera')
                ->color(Color::Blue),
        ];
    }
}
