<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $fillable = ['propertystate_id', 
                           'property_code', 
                           'direction', 
                           'total_land_area', 
                           'bedroom_number', 
                           'bathroom_numbers', 
                           'construction_year',
                           'description', 
                           'constructed_area', 
                           'property_image', 
                           'is_active'];
    
    protected $casts = [
        'property_image' => 'array', 
    ];
    //PARA EL ESTADO DE LA PROPIEDAD                       
    public function propertystates()
    {
        return $this->belongsTo(Propertystate::class, 'propertystate_id');
    }

    //PARA LOS PRECIOS DE LA PROPIEDAD
    public function propertyprices()
    {
        return $this->hasMany(Propertyprice::class, 'id');
    }

    //PARA LOS PROPIETARIOS
    public function propertyowners()
    {
        return $this->hasMany(Propertyowner::class, 'id');
    }
    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'propertyowners', 'property_id', 'owner_id');
    }

    //PARA LOS TIPOS DE PAGO
    public function propertypaymenttypes()
    {
        return $this->hasMany(Propertypaymenttype::class, 'id');
    }
    public function paymenttypes()
    {
        return $this->belongsToMany(Paymenttype::class, 'propertypaymenttypes', 'property_id', 'paymenttype_id');
    }

    //PARA LOS SERVICIOS
    public function propertyservices()
    {
        return $this->hasMany(Propertyservice::class, 'id');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'propertyservices', 'property_id', 'service_id');
    }

}
