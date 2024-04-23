<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title',];
         public function teachers(){return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'teacher_id');}
}
