<?php

namespace App\Modules\Course\Models;

use App\Modules\Lesson\Models\Lesson;
use App\Modules\Section\Models\Section;
use App\Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function lesson():HasMany
    {
        return $this->hasMany(Lesson::class); // Assuming a lesson belongs to a course
    }

    public function section():HasMany
    {
        return $this->hasMany(Section::class); // Assuming a section belongs to a course
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enroll_students'); // Specify the pivot table name
    }

    public function enrollments()
    {
        return $this->hasMany(EnrollStudent::class, 'course_id');
    }
}

