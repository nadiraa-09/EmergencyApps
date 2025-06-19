<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestleave extends Model
{

    use HasFactory;

    protected $fillable = [
        'userId',
        'roleId',
        'departmentId',
        'leavetypeId',
        'from',
        'until',
        'totalDay',
        // 'duration',
        'durationAbsen',
        'reason',
        'remark',
        'status',
        'inactive',
        'createdBy',
        'updatedBy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class, 'leavetypeId', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId', 'id');
    }
}
