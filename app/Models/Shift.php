<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'shifts';
    protected $fillable = [
        'badgeid',
        'shift',
        'curshift',
        'inactive',
        'createdBy',
        'updatedBy'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'badgeid', 'badgeid');
    }
}
