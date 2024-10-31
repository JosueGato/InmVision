<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Appointment;
use App\Filament\Resources\AppointmentResource;

class CalendarWidget extends FullCalendarWidget
{
    public $userId; // ID del usuario que deseas filtrar

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('appointment_date', '>=', $fetchInfo['start'])
            ->where('appointment_date', '<=', $fetchInfo['end'])
            ->whereHas('propertyprices', function ($query) {
                $query->where('user_id', $this->userId); // Filtrar por el user_id
            })
            ->with('propertyprices') // Cargar la relación con Propertyprice
            ->get()
            ->map(
                fn (Appointment $appointment) => [
                    'title' => $appointment->propertyprices->propertyprice_code, // Mostrar el código de propiedad
                    'start' => $appointment->appointment_date,
                    'end' => $appointment->appointment_date, // Ajusta si tienes hora de fin
                    'url' => AppointmentResource::getUrl(name: 'edit', parameters: ['record' => $appointment]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->all();
    }
}
