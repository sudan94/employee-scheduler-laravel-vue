<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledChange extends Model
{
    use HasFactory;

    protected $fillable = ["employee_id", "field", "old_value", "new_value", "effective_date", "processed_at"];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
