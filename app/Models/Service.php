<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = ['service_name'];
    public function propertyservices()
    {
        return $this->hasMany(Propertyservice::class, 'id');
    }


}
