<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellationreason extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cancellationreasons';
    protected $primaryKey = 'id';
    protected $fillable = ['cancelledappointment_id','cancellation_id'];

    public function cancelledappointments()
    {
        return $this->belongsToMany(Cancelledappointment::class, 'cancelledappointment_id');
    }
    public function cancellations()
    {
        return $this->belongsToMany(Cancellation::class, 'cancellation_id');
    }
}
