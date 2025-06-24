<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'badgeid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'badgeid',
        'name',
        'areaId',
        'departmentId',
        'lineId',
        'roleId',
        'inactive',
        'updatedBy',
        'createdBy'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'areaId', 'id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'lineId', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'badgeid', 'username');
    }

    public function shift()
    {
        return $this->hasOne(Shift::class, 'badgeid', 'badgeid');
    }

    public function record()
    {
        return $this->hasOne(Record::class, 'badgeid', 'badgeid')
            ->where('inactive', 1);
    }

    public function evacuation()
    {
        return $this->hasOne(Evacuation::class, 'badgeid', 'badgeid')
            ->where('inactive', 1);
    }
}
