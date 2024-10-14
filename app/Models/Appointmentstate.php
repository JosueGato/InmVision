<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointmentstate extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'appointmentstates';
    protected $primaryKey = 'id';
    protected $fillable = ['appointment_state_name'];
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id');
    }
}
