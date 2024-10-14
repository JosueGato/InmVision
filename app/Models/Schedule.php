<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $fillable = ['hour','scheduletype_id', 'schedule_name', 'description', 'is_active'];
    

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id');
    }

    public function scheduletypes()
    {
        return $this->belongsTo(Scheduletype::class, 'scheduletype_id');
    }
}
