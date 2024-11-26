<?php

namespace App\Modules\EnrollStudent\Models;

use App\Modules\Course\Models\Course;
use App\Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnrollStudent extends Model
{
    use HasFactory;

    protected $table = 'enroll_students';

    protected $fillable = [
        'student_id',
        'course_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}


