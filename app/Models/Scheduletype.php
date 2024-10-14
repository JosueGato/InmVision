<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduletype extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'scheduletypes';
    protected $primaryKey = 'id';
    protected $fillable = ['schedule_type_name'];
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'id');
    }
}
