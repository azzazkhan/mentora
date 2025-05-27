<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Classroom\Enums\Classroom\Cover;
use Modules\Classroom\Models\Classroom;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(['xl' => 3])
            ->schema([
                Forms\Components\Grid::make()
                    ->columnSpan(['xl' => 2])
                    ->columns(['xl' => 2])
                    ->schema([
                        Forms\Components\Section::make()
                            ->columnSpanFull()
                            ->columns(['xl' => 2])
                            ->schema([
                                Forms\Components\TextInput::make('name')->rules(['required'])->columnSpanFull(),
                                Forms\Components\RichEditor::make('description')
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Forms\Components\Grid::make()
                    ->columnSpan(['xl' => 1])
                    ->columns(['xl' => 1])
                    ->schema([
                        Forms\Components\Section::make('Cover')
                            ->columnSpan(['xl' => 1])
                            ->columns(['xl' => 1])
                            ->schema([
                                Forms\Components\Select::make('cover')
                                    ->options(Cover::class)
                                    ->columnSpanFull(),
                            ]),
                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->tooltip('Click to copy unique ID')
                    ->copyMessage('Unique ID copied')
                    ->formatStateUsing(fn(Classroom $record) => str_pad($record->id, 4, '0', STR_PAD_LEFT))
                    ->copyable()
                    ->copyableState(fn(Classroom $record): string => $record->uuid),

                Tables\Columns\TextColumn::make('name')->searchable(),

                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Students')
                    ->badge()
                    ->color(Color::Gray),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->tooltip(function (Classroom $record) {
                        return sprintf('%s (UTC)', carbon($record->created_at)->format('M jS Y \a\t g:i A'));
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnnouncementsRelationManager::class,
            RelationManagers\AssignmentsRelationManager::class,
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
