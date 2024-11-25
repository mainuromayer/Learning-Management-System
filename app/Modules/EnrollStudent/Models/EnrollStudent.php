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
        'id',           // Include 'id' if you're working with it in mass assignment
        'student_id',   // other fields
        'course_id',    // other fields
    ];

    /**
     * Get the student that owns the EnrollStudent.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that owns the EnrollStudent.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
