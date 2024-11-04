<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section; 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $navigationGroup = 'Administración';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sección de Datos Personales')
                ->description('Esta sección permite ingresar la información personal del usuario, incluyendo datos como nombre, carnet de identidad y su número de teléfono.')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    TextInput::make('name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Este campo es requerido',
                    ])  
                    ->maxLength(90)
                    ->extraAttributes([
                        'onkeydown' => "return event.keyCode === 8 || event.keyCode === 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122);", // Allows backspace, space, and letters
                    ])
                    ->label('Nombre(s) del Usuario')
                    ->hint('El nombre del cliente debe contener únicamente letras del alfabeto.'),
                

                    TextInput::make('ci')
                        ->required() 
                        ->validationMessages([
                            'required' => 'Este campo es requerido',
                        ])            
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

                    TextInput::make('cell_phone_number')
                        ->required()
                        ->validationMessages([
                            'required' => 'Este campo es requerido',
                        ])  
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
                        Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->label('Rol del Usuario')
                        //->multiple()
                        ->preload()
                        ->searchable(),
                ])->columnSpan(1)->columns(1),
                
                
                Section::make('Sección de Correo del Cliente')
                ->description('Esta sección permite ingresar información relacionada a la cuenta del cliente, incluyendo datos como su correo electrónico y una contraseña. 
                Asi como el estado de la cuenta del cliente ')
                ->icon('heroicon-o-envelope-open')
                ->schema([ 
                    Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Correo Electronico del Usuario')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'El correo electrónico ingresado ya está en uso. Por favor, ingrese uno diferente.' 
                        ])
                    ->placeholder('ejemplo@correo.com')
                    ->maxLength(30),
                    Password::make('password')
                        ->password()
                        ->label('Contraseña del Usuario')
                        ->copyable()
                        ->copyMessage('Copiado!')
                        ->regeneratePassword()
                        ->minLength(9)
                        ->validationMessages([
                            'minLength' => 'Por favor, ingrese una contraseña con al menos 9 caracteres.',
                        ])
                        ->required(),
                ])->columnSpan(1)->columns(1),
                            
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
}
