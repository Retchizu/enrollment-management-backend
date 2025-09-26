<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    //
    use HasFactory;

    protected static function newFactory()
    {
        return StudentFactory::new();
    }
    protected $table = 'students';
    protected $fillable = ['first_name', 'last_name', 'email', 'address'];
    public function enrollment(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
