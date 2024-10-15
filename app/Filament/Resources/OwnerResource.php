<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;  
use Filament\Forms\Components\TextInput; 
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Propietarios';
    protected static ?string $modelLabel = 'Propietario';
    protected static ?string $navigationGroup = 'Gestión de Propiedades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sección de datos personales Propietario de Bienes Inmuebles')
                ->description('Esta sección permite ingresar la información personal de los propietarios, incluyendo datos como nombre y carnet de identidad.')
                ->icon('heroicon-o-user-group')
                ->schema([
                    TextInput::make('ci')
                        ->required()              
                        ->hint('Ingrese un número de carnet de identidad boliviano válido.')
                        ->alphaNum()
                        ->unique(ignoreRecord: true)
                        ->label('Carnet de Identidad')
                        ->validationMessages([
                            'unique' => 'Este carnet de identidad ya fue registrado. Registre uno nuevo.'
                        ])
                        ->maxLength(9)
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                            'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                        ]),

                    TextInput::make('owner_name')
                        ->required()
                        ->maxLength(90)
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", // Allows backspace, space, and letters
                        ])
                        ->label('Nombre(s) del Propietario')
                        ->hint('El nombre del propietario debe contener únicamente letras del alfabeto.'),
                    
                    TextInput::make('owner_last_name')
                        ->required()
                        ->maxLength(90)
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", 
                        ])
                        ->label('Apellido(s) del Propietario')
                        ->hint('El apellido del propietario debe contener únicamente letras del alfabeto.'),

                ])->columnSpan(1)->columns(1),

                Section::make('Sección Correo del Propietario de Bienes Inmuebles')
                ->description('Esta sección permite ingresar la información relacionada a la cuenta del propietario, incluyendo datos como su correo electrónico y telefono')
                ->icon('heroicon-o-envelope-open')
                ->schema([

                    TextInput::make('owner_cellphone_number')
                        ->required()
                        ->alphaNum()
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || (event.keyCode >= 48 && event.keyCode <= 57)", 
                            'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');", 
                        ])
                        ->prefix('+591')
                        ->maxLength(8)
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'Este número de teléfono ya fue registrado. Registre uno nuevo.' 
                        ])
                        ->label('Número Telefónico del Cliente')
                        ->placeholder('XXX XX XXX')
                        ->hint('Ingrese un número de teléfono boliviano válido.'),


                    TextInput::make('owner_email')
                        ->email()
                        ->required()
                        ->maxLength(100)
                        ->extraAttributes([
                            'onkeydown' => "return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 64 || event.keyCode === 189 || event.keyCode === 190 || event.keyCode === 95 || (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", // Allows backspace, delete, @, -, _, . and alphanumeric
                        ])
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'El correo electrónico ingresado ya está en uso. Por favor, ingrese uno diferente.' 
                        ])
                        ->placeholder('ejemplo@correo.com')
                        ->label('Correo Electrónico del Cliente'),

                    Toggle::make('is_active')
                        ->label('Estado de Cuenta')
                        ->onIcon('heroicon-m-user-group')
                        ->offIcon('heroicon-m-bolt'),
                        
                ])->columnSpan(1)->columns(1), 
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ci')
                    ->label('Carnet de Identidad')
                    ->icon('heroicon-o-identification')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Nombre(s) del Propietario')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_last_name')
                    ->label('Apellido(s) del Propietario')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_cellphone_number')
                    ->color('primary')
                    ->icon('heroicon-o-phone')
                    ->label('Número Telefónico del Propietario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_email')
                    ->icon('heroicon-o-at-symbol')
                    ->color('primary')
                    ->label('Correo Electronico del Propietario')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Estado del Propietario')
                    ->onIcon('heroicon-m-user-group')
                    ->offIcon('heroicon-m-bolt')
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
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
