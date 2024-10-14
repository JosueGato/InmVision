<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertystate extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertystates';
    protected $primaryKey = 'id';
    protected $fillable = ['property_state_name'];
    public function properties()
    {
        return $this->hasMany(Property::class, 'id');
    }
}
