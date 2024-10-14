<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertyprice extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertyprices';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 
                           'propertyprice_code',
                           'price_bs', 
                           'price_us', 
                           'registration_date', 
                           'property_id', 
                           'propertylisting_id', 
                           'construction_year',
                           'is_active'];

    //PARA EL LISTADO DE LA PROPIEDAD                       
    public function propertylistings()
    {
        return $this->belongsTo(Propertylisting::class, 'propertylisting_id');
    }

    //PARA LA PROPIEDAD
    public function properties()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    //PARA LA CITA
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id');
    }
}
