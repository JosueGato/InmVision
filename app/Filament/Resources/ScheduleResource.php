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
            ->description('Esta sección permite gestionar los horarios disponibles, incluyendo una descripcion y su disponibilidad, así como su estado.')
            ->icon('heroicon-o-clock')
            ->schema([
                TimePicker::make('hour')              
                    ->label('Asignación de Horario')
                    ->required(),

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
