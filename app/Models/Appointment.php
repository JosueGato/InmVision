<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $fillable = ['client_id', 
                           'propertyprice_id', 
                           'creation_date', 
                           'comment', 
                           'reprogramation_number', 
                           'appointmentstate_id', 
                           'schedule_id',
                           'is_active',
                           'appointment_date'];


    //PARA LOS CLIENTES      
    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    //PARA LOS HORARIOS      
    public function schedules()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    //PARA LOS ESTADOS DE UNA CITA      
    public function appointmentstates()
    {
        return $this->belongsTo(Appointmentstate::class, 'appointmentstate_id');
    }

    //PARA LAS PROPIEDADES CON PRECIO                       
    public function propertyprices()
    {
        return $this->belongsTo(Propertyprice::class, 'propertyprice_id');
    }

    //PARA LAS CITAS REPROGRAMADAS
    public function reprogramedappointments()
    {
        return $this->hasMany(Reprogramedappointment::class, 'id');
    }

    //PARA LAS CITAS CANCELADAS
    public function cancelledappointments()
    {
        return $this->hasMany(Cancelledappointment::class, 'id');
    }

}
