<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelledappointment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cancelledappointments';
    protected $primaryKey = 'id';
    protected $fillable = ['appointment_id', 
                           'cancelation_date', 
                           'other', 
                           'actual_date', 
                           'reason', 
                           'new_date'];

    //PARA LAS CITAS      
    public function appointments()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    //PARA LAS CANCELACIONES
    public function cancellationreasons()
    {
        return $this->hasMany(Cancellationreason::class, 'id');
    }
    public function cancellations()
    {
        return $this->belongsToMany(Cancellation::class, 'cancellationreasons', 'cancelledappointment_id', 'cancellation_id');
    }
}
