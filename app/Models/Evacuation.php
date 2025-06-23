<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evacuation extends Model
{
    use HasFactory;
    protected $table = 'evacuations';
    protected $fillable = ['badgeid', 'status', 'inactive', 'createdBy', 'updatedBy', 'remark'];
    public $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'badgeid', 'badgeid');
    }
}
