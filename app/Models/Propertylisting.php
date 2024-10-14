<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertylisting extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertylistings';
    protected $primaryKey = 'id';
    protected $fillable = ['property_listing_name'];
    public function propertyprices()
    {
        return $this->hasMany(Propertyprice::class, 'id');
    }
}
