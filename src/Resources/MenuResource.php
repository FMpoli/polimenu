<?php

namespace Detit\Polimenu\Resources;

use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Detit\Polimenu\Models\Menu;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

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
                Grid::make(3)
                    ->schema([
                        // Colonna sinistra
                        Section::make()
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
                                    ->maxLength(255),
                                TextInput::make('handle')
                                    ->required()
                                    ->maxLength(255),
                                Toggle::make('is_published')
                                    ->default(true),
                        ])->columnSpan(1),

                        // Colonna destra
                        Section::make()
                            ->schema([
                                AdjacencyList::make('items')
                                    ->maxDepth(1)
                                    ->labelKey('name')
                                    ->form([
                                        TextInput::make('name')
                                            ->required()
                                            ->live(debounce: 500)
                                            ->autocapitalize('words')
                                            ->maxLength(255),
                                        Select::make('target')
                                            ->required()
                                            ->options([
                                                '_self' => 'Same tab',
                                                '_blank' => 'New tab',
                                            ]),
                                        TextInput::make('url')
                                            ->required(),
                                    ]),
                            ])->columnSpan(2),
                        ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('handle')
                    ->label('Component')
                    ->formatStateUsing(function ($state) {
                        return new HtmlString(
                            Blade::render("&lt;x-polimenu-menu handle=\"$state\" /&gt;")
                        );
                    })
                    ->html()
                    ->color('primary')
                    ->badge()
                    ->copyable()
                    ->copyMessage('Component copied to clipboard')
                    ->copyMessageDuration(1500)
                    ->copyableState(fn (string $state): string => "<x-polimenu-menu handle='{$state}' />"),
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
            // RelationManagers\MenuRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => MenuResource\Pages\ListMenu::route('/'),
            'create' => MenuResource\Pages\CreateMenu::route('/create'),
            'edit' => MenuResource\Pages\EditMenu::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Menu');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Menu');
    }

    public static function getLabel(): ?string
    {
        return __('Menu');
    }

    public static function getModelLabel(): string
    {
        return __('Menu');
    }
}
