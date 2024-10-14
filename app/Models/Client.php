<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = ['ci','client_name', 'client_last_name', 'client_cellphone_number', 'client_email', 'pass', 'is_active'];
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id');
    }
}
