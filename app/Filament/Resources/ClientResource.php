<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Section;  
use Filament\Forms\Components\TextInput;  
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $navigationGroup = 'Administración';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sección de Datos Personales')
                ->description('Esta sección permite ingresar la información personal del cliente, incluyendo datos como nombre, carnet de identidad y su número de teléfono.')
                ->icon('heroicon-o-users')
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
                
                    TextInput::make('client_cellphone_number')
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

                    TextInput::make('client_name')
                    ->required()
                    ->maxLength(90)
                    ->extraAttributes([
                        'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", // Allows backspace, space, and letters
                    ])
                    ->label('Nombre(s) del cliente')
                    ->hint('El nombre del cliente debe contener únicamente letras del alfabeto.'),
                
                    TextInput::make('client_last_name')
                    ->required()
                    ->maxLength(90)
                    ->extraAttributes([
                        'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", 
                    ])
                    ->label('Apellido(s) del cliente')
                    ->hint('El apellido del cliente debe contener únicamente letras del alfabeto.'),
                ])->columnSpan(1)->columns(1),

            
                Section::make('Sección de Correo del Cliente')
                ->description('Esta sección permite ingresar información relacionada a la cuenta del cliente, incluyendo datos como sucorreo electrónico y una contraseña. 
                Asi como el estado de la cuenta del cliente ')
                ->icon('heroicon-o-envelope-open')
                ->schema([
                    TextInput::make('client_email')
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
                
            
                    Password::make('pass')
                        ->password()
                        ->label('Contraseña del Cliente')
                        ->copyable()
                        ->copyMessage('Copiado!')
                        ->regeneratePassword()
                        ->minLength(9)
                        ->validationMessages([
                            'minLength' => 'Por favor, ingrese una contraseña con al menos 9 caracteres.',
                        ])
                        ->required(),
                    Toggle::make('is_active')
                        ->label('Estado de Cuenta')
                        ->onIcon('heroicon-m-bolt')
                        ->offIcon('heroicon-m-user'),
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
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nombre(s) del Cliente')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_last_name')
                    ->label('Apellido(s) del Cliente')
                    ->color('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_cellphone_number')
                    ->color('primary')
                    ->icon('heroicon-o-phone')
                    ->label('Número Telefónico del Cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_email')
                    ->icon('heroicon-o-at-symbol')
                    ->color('primary')
                    ->label('Correo Electronico del Cliente')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Estado del Cliente')
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
