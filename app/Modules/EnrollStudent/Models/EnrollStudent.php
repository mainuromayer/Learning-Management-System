<?php

namespace App\Modules\EnrollStudent\Models;

use App\Modules\Course\Models\Course;
use App\Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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



    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enroll_students', 'student_id', 'course_id');
    }

}