<?php

namespace App\Filament\Resources\ClassroomResource\RelationManagers;

use App\Filament\Resources\AssignmentResource\Pages\ViewAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Announcement\Models\Announcement;
use Modules\Assignment\Models\Assignment;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('description')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'codeBlock',
                        'h2',
                        'h3',
                    ])
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('due_date')
                    ->required()
                    ->default(now()->addDays(7))
                    ->seconds(false)
                    ->displayFormat('d M Y H:i')
                    ->native(false),

                Forms\Components\Select::make('allow_late')
                    ->options([
                        'true' => 'Yes',
                        'false' => 'No',
                    ])
                    ->default('false')
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->since()
                    ->tooltip(function (Assignment $record) {
                        return sprintf('%s (UTC)', carbon($record->created_at)->format('M jS Y \a\t g:i A'));
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->tooltip(function (Assignment $record) {
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
                Tables\Actions\ViewAction::make()->url(fn(Assignment $record) => route(ViewAssignment::getRouteName(), ['record' => $record])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('teacher');
            });
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
