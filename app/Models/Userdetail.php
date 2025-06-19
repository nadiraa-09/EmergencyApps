<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'leaveBalance',
        'createdBy',
        'updatedBy',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
