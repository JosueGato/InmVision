<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Reprogramedappointment;
use App\Models\Cancelledappointment;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Citas';
    protected static ?string $modelLabel = 'Cita';
    protected static ?string $navigationGroup = 'Gestión de Citas';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Sección de Citas')
            ->description('Esta sección permite gestionar las citas para visitas a propiedades, incluyendo información sobre la propiedad y el cliente')
            ->icon('heroicon-o-calendar-date-range')
            ->schema([
                Select::make('client_id')
                    ->label('Carnet de Identidad del Cliente')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('clients', 'ci'),

                Select::make('propertyprice_id')
                    ->label('Código de la Propiedad')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('propertyprices', 'propertyprice_code'),
            ])->columnSpan(1)->columns(1),

            Section::make('Sección de Fechas y Horarios')
            ->description('Esta sección permite gestionar la disponibilidad, incluyendo información sobre la fecha y hora.')
            ->icon('heroicon-o-calendar')
            ->schema([
                Select::make('schedule_id')
                    ->label('Seleccione un Horario')
                    ->required()
                    ->preload()
                    ->relationship('schedules', 'schedule_name'),

                DatePicker::make('appointment_date')
                    ->required()
                    //->disabledDays([0])
                    ->after('tomorrow')
                    ->label('Seleccione una Fecha con un Día de Anticipación')
                    ->validationMessages([
                        'after' => 'La cita debe ser agendada con un día de anticipación!'
                    ])
                    ->rules([
                        function (\Filament\Forms\Get $get) {
                            return function (string $attribute, $value, $fail) use ($get) {
                                $scheduleId = $get('schedule_id');

                                if (!$scheduleId) {
                                    $fail('Por favor seleccione un horario.');
                                    return;
                                }

                                // Verificar si ya existe una cita con la misma fecha y horario
                                $exists = Appointment::where('appointment_date', $value)
                                    ->where('schedule_id', $scheduleId)
                                    ->exists();

                                if ($exists) {
                                    $fail("Ya existe una cita programada en esta fecha y horario.");
                                }
                            };
                        },
                    ]),
            ])->columnSpan(1)->columns(1),

            Section::make('Sección de Campo Opcional')
            ->description('Esta sección permite gestionar algún comentario o nota extra para cada cita.')
            ->icon('heroicon-o-circle-stack')
            ->schema([
                MarkdownEditor::make('comment')
                    ->label('Comentarios para la Cita'),
            ])->columns(1),
        ])->columns(2);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('clients.ci')
                    ->label('Carnet de Identidad del Cliente')
                    ->icon('heroicon-o-identification')
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('propertyprices.propertyprice_code')
                    ->label('Codigo de Propiedad')
                    ->icon('heroicon-o-home-modern')
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointmentstates.appointment_state_name')
                    ->label('Estado de Cita')
                    ->icon('heroicon-o-check-badge')
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedules.schedule_name')
                    ->label('Horario')
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('creation_date')
                    ->date()
                    ->label('Fecha de Creación')
                    ->icon('heroicon-o-calendar')
                    ->color('danger')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('appointment_date')
                    ->date()
                    ->icon('heroicon-o-calendar-date-range')
                    ->label('Fecha de Cita')
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reprogramation_number')
                    ->numeric()
                    ->color('info')
                    ->icon('heroicon-o-numbered-list')
                    ->label('Numero de Reprogramaciones')
                    ->sortable(),
               
          
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('reprogramAppointment')
                ->label('Reprogramar Cita')
                ->color('success')
                ->icon('heroicon-o-calendar-date-range')
                ->form([
                    Forms\Components\DatePicker::make('new_date')
                        ->label('Nueva Fecha')
                        ->required()
                        ->after('tomorrow')
                        ->validationMessages([
                            'after' => 'La cita debe ser agendada con un día de anticipación!'
                        ])
                        ->rules([
                            function (\Filament\Forms\Get $get) {
                                return function (string $attribute, $value, $fail) use ($get) {
                                    $scheduleId = $get('schedule_id');
    
                                    if (!$scheduleId) {
                                        $fail('Por favor seleccione un horario.');
                                        return;
                                    }
    
                                    // Verificar si ya existe una cita con la misma fecha y horario
                                    $exists = Appointment::where('appointment_date', $value)
                                        ->where('schedule_id', $scheduleId)
                                        ->exists();
    
                                    if ($exists) {
                                        $fail("Ya existe una cita programada en esta fecha y horario.");
                                    }
                                };
                            },
                        ]),    
                    Select::make('schedule_id')
                        ->label('Nuevo Horario')
                        ->relationship('schedules', 'schedule_name')
                        ->required(),
                    MarkdownEditor::make('reason')
                        ->label('Razón de la Reprogramación')
                        ->required()
                        ->validationMessages([
                            'required' => 'Este campo es requerido',
                        ])  
                        ->maxLength(255),
                ])
                ->action(function (array $data, Appointment $record): void {
                    Reprogramedappointment::create([
                        'appointment_id' => $record->id,
                        'schedule_id' => $data['schedule_id'],
                        'original_date' => $record->appointment_date, 
                        'new_date' => $data['new_date'],
                        'reason' => $data['reason'], 
                    ]);

                    $record->update([
                        'appointment_date' => $data['new_date'],
                        'schedule_id' => $data['schedule_id'],
                    ]);
                }),

                Tables\Actions\Action::make('Cancelledappointment')
                ->label('Cancelar Cita')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->form([
                    MarkdownEditor::make('other')
                        ->label('Razón de la Cancelación')
                        ->required(),
                ])
                ->action(function (array $data, Appointment $record): void {
                    Cancelledappointment::create([
                        'appointment_id' => $record->id,
                        'other' => $data['other'], 
                    ]);
                }),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
