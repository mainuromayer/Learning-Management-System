<?php

namespace App\Modules\Student\Models;

use App\Modules\User\Models\User; 
use App\Modules\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    protected $table ='students';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enroll_students', 'student_id', 'course_id');
    }

}
