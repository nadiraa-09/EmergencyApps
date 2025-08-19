<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'areaId', 'createdBy', 'updatedBy'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'areaId', 'id');
    }
}
