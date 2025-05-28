<?php

namespace App\Filament\Resources\AssignmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Submission;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('user.name'),
                Infolists\Components\TextEntry::make('status')->badge(),

                Infolists\Components\TextEntry::make('is_late')->badge()
                    ->color(fn(bool $state) => $state ? 'danger' : 'success')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),

                Infolists\Components\TextEntry::make('grade')->formatStateUsing(fn(int|null $state) => $state ? $state : 'N/A'),
                Infolists\Components\TextEntry::make('submitted_at')->since()->dateTimeTooltip(),

                // Infolists\Components\TextEntry::make('due_date')->since()->dateTimeTooltip(),
                // Infolists\Components\TextEntry::make('allow_late')->badge()->color(fn(bool $state) => $state ? 'danger' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                // Infolists\Components\TextEntry::make('edited')->badge()->color(fn(bool $state) => $state ? 'warning' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                // Infolists\Components\TextEntry::make('archived')->badge()->color(fn(bool $state) => $state ? 'warning' : 'gray')->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                // Infolists\Components\TextEntry::make('classroom.name')->label('Classroom'),
                // Infolists\Components\TextEntry::make('created_at')->since()->dateTimeTooltip()->label('Created'),
                // Infolists\Components\TextEntry::make('updated_at')->since()->dateTimeTooltip()->label('Updated')->visible(fn(Assignment $record) => $record->edited),
            ]);;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('is_late')->badge()
                    ->color(fn(bool $state) => $state ? 'danger' : 'success')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No'),
                Tables\Columns\TextColumn::make('grade'),
                Tables\Columns\TextColumn::make('submitted_at')->since()->dateTimeTooltip(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('grade')
                    ->visible(function (Submission $record) {
                        return $record->status->is([Status::TurnedIn, Status::Locked]);
                    })
                    ->label('Grade')
                    ->form([
                        Forms\Components\TextInput::make('grade')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->action(function (Submission $record, array $data) {
                        $record->update($data);
                    }),
                Tables\Actions\ViewAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('user');
            });
    }
}
