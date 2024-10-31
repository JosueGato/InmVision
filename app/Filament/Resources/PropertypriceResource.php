<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertypriceResource\Pages;
use App\Filament\Resources\PropertypriceResource\RelationManagers;
use App\Models\Propertyprice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Hidden;

class PropertypriceResource extends Resource
{
    protected static ?string $model = Propertyprice::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Precios de Propiedades';
    protected static ?string $modelLabel = 'Precio de Propiedades';
    protected static ?string $navigationGroup = 'Gestión de Propiedades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sección de Estados')
                ->description('Esta sección permite escoger la propiedad y el estado en la que esta se va a lanzar al mercado')
                ->icon('heroicon-o-bookmark-square')
                ->schema([
                    Hidden::make('user_id')
                        ->default(auth()->id()) // Establece el usuario autenticado
                        ->required(),
                   /*TextInput::make('user_id')
                            ->label('Agente Inmobiliario')
                            ->required()
                            ->default(auth()->user()->email) // Set the default value to the authenticated user's email
                            ->disabled() // Make it non-editable
                            ->extraAttributes(['readonly' => 'readonly']),*/
                    /*Select::make('user_id')
                        ->label('Agente Inmobiliario')
                        ->required()
                        ->relationship('users', 'email')
                        ->default(auth()->id()) 
                        ->disabled(),*/ 
                    Select::make('property_id')
                        ->label('Código de la Propiedad')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 64 || event.keyCode === 189 || event.keyCode === 190 || event.keyCode === 95 || (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", // Allows backspace, delete, @, -, _, . and alphanumeric
                        ])
                        ->relationship('properties', 'property_code'),
                    Select::make('propertylisting_id')
                        ->required()
                        ->label('Estado de la Propiedad para su Asignación')
                        ->relationship('propertylistings', 'property_listing_name')                              
                        ->preload()
                        ->rules([
                            function (\Filament\Forms\Get $get) {
                                return function (string $attribute, $value, $fail) use ($get) {
                                    $scheduleId = $get('property_id');
    
                                    if (!$scheduleId) {
                                        $fail('Por favor seleccione una propiedad.');
                                        return;
                                    }
    
                                    $exists = Propertyprice::where('propertylisting_id', $value)
                                        ->where('property_id', $scheduleId)
                                        ->exists();
    
                                    if ($exists) {
                                        $fail("Ya existe una asignacion de este estado para esta propiedad.");
                                    }
                                };
                            },
                        ]),
                ])->columnSpan(1)->columns(1),

                Section::make('Sección de Precios')
                ->description('Esta sección permite asignar precios a las propiedades de manera indpendiente tanto en Bolivianos como en Dolares')
                ->icon('heroicon-o-banknotes')
                ->schema([
                        TextInput::make('price_bs')
                            ->label('Precío en Bs()')
                            ->extraAttributes([
                                'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57) || event.key === ','",
                                'oninput' => "this.value = this.value.replace(/[^0-9,]/g, '');", 
                            ])
                            ->required()
                            ->numeric(),
                        TextInput::make('price_us')
                            ->label('Precío en Us()')
                            ->extraAttributes([
                                'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57) || event.key === ','",
                                'oninput' => "this.value = this.value.replace(/[^0-9,]/g, '');", 
                            ])
                            ->required()
                            ->numeric(),  
                ])->columnSpan(1)->columns(1),     
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.email')
                ->label('Agente Inmobiliario')
                ->badge()
                ->color('primary')
                ->icon('heroicon-o-user'),     
            Tables\Columns\TextColumn::make('propertylistings.property_listing_name')
                ->label('Estado de Asignacion para la Propiedad')
                ->badge()
                ->color('info')
                ->icon('heroicon-o-cube'),   
            Tables\Columns\TextColumn::make('properties.property_code')
                ->label('Codigo de la Propiedad')
                ->badge()
                ->color('info')
                ->icon('heroicon-o-rectangle-group'), 

            Tables\Columns\TextColumn::make('price_bs')
                ->label('Precio de la Propiedad en (bs)')
                ->badge()
                ->color('primary')
                ->icon('heroicon-o-currency-dollar'),

            Tables\Columns\TextColumn::make('price_us')
                ->label('Precio de la Propiedad en (bs)')
                ->badge()
                ->color('primary')
                ->icon('heroicon-o-currency-dollar'),
     
            Tables\Columns\TextColumn::make('registration_date')
                ->label('Año de Construcción')
                ->color('primary')
                ->icon('heroicon-o-calendar')
                ->sortable(),
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
            'index' => Pages\ListPropertyprices::route('/'),
            'create' => Pages\CreatePropertyprice::route('/create'),
            'edit' => Pages\EditPropertyprice::route('/{record}/edit'),
        ];
    }
}
