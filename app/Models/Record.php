<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $table = 'records';
    protected $fillable = ['badgeid', 'status', 'inactive', 'createdBy', 'updatedBy', 'remark'];
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'cardid', 'cardid');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId', 'id');
    }
}
