<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Propiedades';
    protected static ?string $modelLabel = 'Propiedades';
    protected static ?string $navigationGroup = 'Gestión de Propiedades';

    public static function form(Form $form): Form
    {
        return $form  
            ->schema([           
                Wizard::make()
                    ->columnSpanFull()
                    ->schema([
                        Wizard\Step::make('Especificaciones Basicas')
                        ->icon('heroicon-m-home')
                        ->schema([
                            Select::make('propertystate_id')
                                ->relationship('propertystates','property_state_name')
                                ->label('Estado de la Propiedad')
                                ->preload()
                                ->required()
                                ->validationMessages([
                                    'required' => 'El estado de la Propiedad debe ser rellenado',
                                ]),
                            TextInput::make('direction')
                                ->label('Dirección de la Propiedad')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ]),

                             Select::make('services')
                                ->multiple()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", 
                                ])
                                ->label('Elija el o los servicio(s) con los que cuenta esta propiedad')
                                ->relationship('services','service_name')
                                ->preload(),
                                     
                            Select::make('owners')
                                ->multiple()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", 
                                ])
                                ->label('Elija el o los propietario(s) con los que cuenta esta propiedad')
                                ->relationship('owners','owner_name')
                                ->preload(),
        
                            Select::make('paymenttypes')
                                ->multiple()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", 
                                ])
                                ->label('Elija el o los tipo de pago(s) con los que cuenta esta propiedad')
                                ->relationship('paymenttypes','payment_type_name')
                                ->preload(),

                            TextInput::make('construction_year')
                                ->label('Año de Construcción de la Propiedad')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])
                                ->maxLength(4)
                                ->minLength(4)
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                                ]),
                        ])->columnSpan(1)->columns(2),
                    Wizard\Step::make('Especificaciones Tecnicas')
                        ->icon('heroicon-m-circle-stack')
                        ->schema([
                            

                            Forms\Components\TextInput::make('total_land_area')
                                ->label('Superficie del Terreno')
                                ->hint('Este dato se toma en (m)')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])              
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57) || event.key === ','",
                                    'oninput' => "this.value = this.value.replace(/[^0-9,]/g, '');", 
                                ]),
                                
                            Forms\Components\TextInput::make('bedroom_number')
                                ->required()
                                ->label('Número de Baños')
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])  
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                                ]),
                            
                            Forms\Components\TextInput::make('bathroom_numbers')
                                ->required()
                                ->label('Número de Habitaciones')
                                ->validationMessages([
                                    'required' => 'Este campo es requerido',
                                ])  
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                                ]),
                            Forms\Components\TextInput::make('constructed_area')
                                ->label('Superficie Construida')
                                ->hint('Este Campo es Opcional')
                                ->extraAttributes([
                                    'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                                ])
                                ->maxLength(6),
                           
                         
                        ])->columnSpan(1)->columns(2),
                    Wizard\Step::make('Especificaciones Adicionales')
                    ->icon('heroicon-m-cog')
                    
                        ->schema([

                            MarkdownEditor::make('description')
                                ->label('Descripción de la Propiedad'),
               
                            FileUpload::make('property_image')
                                ->image()
                                ->multiple()
                                ->label('Imagen Promocional de la Propiedad')
                                ->imageEditor(),                    
                        ]),
                    ])

                    
                              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('propertystates.property_state_name')
                    ->label('Estado de la Propiedad')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-cube'), 
                    
                Tables\Columns\TextColumn::make('owners.ci')
                    ->label('Propietario(s)')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-user'),   
                Tables\Columns\TextColumn::make('services.service_name')
                    ->label('Servicio(s)')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-rectangle-group'), 
                Tables\Columns\TextColumn::make('paymenttypes.payment_type_name')
                    ->label('Tipo de Pago(s)')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-lifebuoy'),
                Tables\Columns\TextColumn::make('property_code')
                    ->icon('heroicon-o-hashtag')
                    ->label('Codigo de Propiedad')
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('direction')
                    ->label('Dirección de la Propiedad')
                    ->icon('heroicon-o-map-pin')
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_land_area')
                    ->icon('heroicon-o-archive-box')
                    ->color('primary')
                    ->label('Superficie del Terreno')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bedroom_number')
                    ->label('Número de Habitaciones')
                    ->color('primary')
                    ->icon('heroicon-o-circle-stack'),
                Tables\Columns\TextColumn::make('bathroom_numbers')
                    ->label('Número de Baños')
                    ->color('primary')
                    ->icon('heroicon-o-squares-2x2'),
                Tables\Columns\TextColumn::make('construction_year')
                    ->label('Año de Construcción')
                    ->color('primary')
                    ->icon('heroicon-o-calendar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Información Adicional')
                    ->color('primary')
                    ->icon('heroicon-o-information-circle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('constructed_area')
                    ->icon('heroicon-o-archive-box')
                    ->color('primary')
                    ->label('Superficie Construida')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('property_image')
                    ->label('Imagen(es) de la Propiedad'),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
