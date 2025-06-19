<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'personInCharge',
        'divInCharge',
        'centerInCharge',
        'inactive',
        'createdBy',
        'updatedBy',
    ];

    public function personInChargeUser()
    {
        // return $this->belongsTo(User::class, 'departmentId', 'id');
        return $this->hasMany(User::class, 'departmentId', 'id');
    }

    public function divInCharge()
    {
        return $this->belongsTo(User::class, 'departmentId', 'id');
    }

    public function centerInCharge()
    {
        return $this->belongsTo(User::class, 'departmentId', 'id');
    }
}
