<?php

namespace Detit\Polimenu\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Detit\Polimenu\Models\Menu;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;

class MenuResource extends Resource
{
    use Translatable;

    protected static ?string $model = Menu::class;

    protected static ?string $slug = 'menu';

    protected static ?string $recordTitleAttribute = "name";

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Navigation';

        public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Menu Information')
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->live(debounce: 500)
                            ->autocapitalize('words')
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                $name = $state;
                                $handle = Str::slug($name);
                                $set('handle', $handle);
                            })
                    ->columnSpan(1)
                    ->maxLength(255),
                TextInput::make('handle')
                    ->required()
                    ->columnSpan(1)
                    ->maxLength(255),
                Repeater::make('items')
                    ->defaultItems(0)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(debounce: 500)
                            ->autocapitalize('words')
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                $name = $state;
                                $lastName = $get('last_name');
                                $slug = Str::slug($name . ' ' . $lastName);
                                $set('slug', $slug);
                            })
                            ->columnSpan(1)
                            ->maxLength(255),
                        Select::make('target')
                            ->required()
                            ->columnSpan(1)
                            ->options(
                                [
                                    '_self' => 'Same tab',
                                    '_blank' => 'New tab',
                                ]
                            ),
                        TextInput::make('url')
                            ->required()
                            ->columnSpan(1)
                    ])->columns(3),
                Toggle::make('is_published')
                    ->columnSpan(1)
                    ->default(true),
            ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('handle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            // Definisci qui le relazioni, ad esempio:
            // RelationManagers\NewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenu::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Categories');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Categories');
    }

    public static function getLabel(): ?string
    {
        return __('Category');
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }
}
