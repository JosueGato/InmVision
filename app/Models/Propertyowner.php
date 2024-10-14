<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertyowner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertyowners';
    protected $primaryKey = 'id';
    protected $fillable = ['property_id', 'owner_id', 'is_active'];
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_id');
    }
    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'owner_id');
    }
}
