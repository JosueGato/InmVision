<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertyservice extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertyservices';
    protected $primaryKey = 'id';
    protected $fillable = ['service_id','property_id', 'is_active'];
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_id');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_id');
    }

    
}
