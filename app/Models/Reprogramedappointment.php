<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reprogramedappointment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'reprogramedappointments';
    protected $primaryKey = 'id';
    protected $fillable = ['appointment_id', 
                           'schedule_id', 
                           'original_date', 
                           'actual_date', 
                           'reason', 
                           'new_date'];

    //PARA LAS CITAS      
    public function appointments()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    //PARA LOS HORARIOS      
    public function schedules()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

}
