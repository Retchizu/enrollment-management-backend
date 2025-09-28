<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    //
    protected $table = 'enrollment';
    protected $fillable = ['course_id', 'student_id'];
    public function students(): BelongsTo 
    {
        return $this -> belongsTo(Student::class);
    }

    public function courses(): BelongsTo
    {
        return $this -> belongsTo(Course::class);
    }
}
