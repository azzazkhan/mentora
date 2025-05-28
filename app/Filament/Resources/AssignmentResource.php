<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Assignment\Models\Assignment;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('title'),
                Infolists\Components\TextEntry::make('due_date')->since()->dateTimeTooltip(),
                Infolists\Components\TextEntry::make('allow_late')->badge()->color(fn(bool $state) => $state ? 'danger' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                Infolists\Components\TextEntry::make('edited')->badge()->color(fn(bool $state) => $state ? 'warning' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                Infolists\Components\TextEntry::make('archived')->badge()->color(fn(bool $state) => $state ? 'warning' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                Infolists\Components\TextEntry::make('classroom.name')->label('Classroom'),
                Infolists\Components\TextEntry::make('created_at')->since()->dateTimeTooltip()->label('Created'),
                Infolists\Components\TextEntry::make('updated_at')->since()->dateTimeTooltip()->label('Updated')->visible(fn(Assignment $record) => $record->edited),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewAssignment::route('/{record}'),
        ];
    }
}
