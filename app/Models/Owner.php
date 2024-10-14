<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'owners';
    protected $primaryKey = 'id';
    protected $fillable = ['owner_name', 'owner_last_name', 'owner_cellphone_number', 'owner_email', 'is_active'];  
    public function propertyowners()
    {
        return $this->hasMany(Propertyowner::class, 'id');
    }
}
