<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymenttype extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'paymenttypes';
    protected $primaryKey = 'id';
    protected $fillable = ['payment_type_name'];
    public function propertypaymenttypes()
    {
        return $this->hasMany(Propertypaymenttype::class, 'id');
    }
}
