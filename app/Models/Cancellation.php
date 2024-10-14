<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cancellations';
    protected $primaryKey = 'id';
    protected $fillable = ['reason'];
    public function cancellationreasons()
    {
        return $this->hasMany(Cancellationreason::class, 'id');
    }
}
