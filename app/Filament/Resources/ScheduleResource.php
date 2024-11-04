<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Section;  
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;  
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Horarios';
    protected static ?string $modelLabel = 'Horario';
    protected static ?string $navigationGroup = 'Gestión de Citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sección de Horarios')
                    ->description('Esta sección permite gestionar los horarios disponibles, incluyendo una descripción y su disponibilidad, así como su estado.')
                    ->icon('heroicon-o-clock')
                    ->schema([

                        TimePicker::make('hour')
                            ->label('Asignación de Horario')
                            ->hint('Ingrese un horario entre las 8:00 a.m. y las 22:00 p.m.')
                            ->required()
                            ->validationMessages([
                                'required' => 'Ingrese un horario dentro de los rangos establecidos' 
                            ])
                            //->native(false) // Desactiva el selector nativo
                            ->hoursStep(1)
                            ->minutesStep(15)
                            // ->disabled(fn ($get) => self::shouldDisableTime($get)) // Comentar esta línea temporalmente
                            ->afterStateUpdated(function (callable $set, $state) {
                                $selectedTime = Carbon::parse($state);
                                $startLimit = Carbon::createFromTime(22, 0);
                                $endLimit = Carbon::createFromTime(8, 0);
                                if ($selectedTime->between($startLimit, Carbon::createFromTime(23, 59, 59)) ||
                                    $selectedTime->between(Carbon::createFromTime(0, 0), $endLimit)) {
                                    $set('hour', null); // Restablecer el valor
                                    throw ValidationException::withMessages([
                                        'hour' => 'El horario no puede estar entre las 22:00 y las 08:00.',
                                    ]);
                                }
                            }),
    
                        MarkdownEditor::make('description')
                            ->label('Descripción del Horario'),
    
                        Toggle::make('is_active')
                            ->label('Estado de Horario')
                            ->onIcon('heroicon-m-clock')
                            ->offIcon('heroicon-m-bolt'),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([   
                Tables\Columns\TextColumn::make('schedule_name')
                    ->label('Horario')
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción del Horario')
                    ->icon('heroicon-o-information-circle')
                    ->color('info')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Estado del Horario')
                    ->onIcon('heroicon-m-clock')
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

    private static function shouldDisableTime($get) {
        $hour = (int) Carbon::parse($get('hour'))->format('H');
        return ($hour >= 22 || $hour < 8);
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
