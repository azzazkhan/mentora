<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Enums\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

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
                            ->columnSpan(['xl' => 2])
                            ->columns(['xl' => 2])
                            ->schema([
                                Forms\Components\TextInput::make('name')->required()->rules(['required']),
                                Forms\Components\TextInput::make('email')->email()->required()->rules(['required', 'email']),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->columnSpanFull()
                                    ->required(fn(string $operation) => $operation === 'create')
                                    ->rules([Password::defaults()]),
                            ]),

                        // Forms\Components\Section::make('Profile')
                        //     ->columnSpan(['xl' => 2])
                        //     ->columns(['xl' => 2])
                        //     ->relationship('profile')
                        //     ->schema([
                        //         Forms\Components\Textarea::make('bio')->rows(10)->columnSpanFull(),
                        //         Forms\Components\Select::make('gender')->options(Gender::class)->native(false),
                        //         Forms\Components\DatePicker::make('dob')->native(false)->weekStartsOnMonday(),
                        //     ]),
                    ]),

                Forms\Components\Section::make('Avatar')
                    ->columnSpan(['xl' => 1])
                    ->columns(['xl' => 1])
                    // ->relationship('profile')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->directory('avatars')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('512')
                            ->imageResizeTargetHeight('512')
                            ->openable()
                            ->downloadable()
                            ->maxSize(2048)
                            ->hiddenLabel(),
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
                    ->formatStateUsing(fn(User $record) => str_pad($record->id, 4, '0', STR_PAD_LEFT))
                    ->copyable()
                    ->copyableState(fn(User $record): string => $record->uuid),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->color(fn(User $record) => $record->admin ? Color::Red : null),

                Tables\Columns\TextColumn::make('email')->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(User $record) => $record->hasAnyRole([Role::SuperAdmin, Role::Admin]) ? Color::Red : Color::Gray),

                Tables\Columns\TextColumn::make('verified')
                    ->badge()
                    ->formatStateUsing(fn(User $record) => $record->verified ? 'Verified' : 'Unverified')
                    ->color(fn(User $record) => $record->verified ? Color::Green : Color::Orange),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->tooltip(function (User $record) {
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()->hasAnyRole([Role::SuperAdmin, Role::Admin]);
    }
}
