<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertypaymenttype extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propertypaymenttypes';
    protected $primaryKey = 'id';
    protected $fillable = ['property_id','paymenttype_id', 'is_active'];
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_id');
    }
    public function paymenttypes()
    {
        return $this->belongsToMany(Paymenttype::class, 'genrepaymenttype_id_id');
    }
}
