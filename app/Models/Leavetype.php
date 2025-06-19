<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    protected $fillable = [
        'name',
        'inactive',
        'createdBy',
        'updatedBy'
    ];
}
