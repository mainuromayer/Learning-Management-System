<?php

namespace App\Modules\Course\Models;

use App\Modules\Quiz\Models\Quiz;
use App\Modules\Lesson\Models\Lesson;
use App\Modules\Section\Models\Section;
use App\Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Category\Models\Category;
use App\Modules\Assignment\Models\Assignment;
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

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enroll_students', 'course_id', 'student_id');
    }





    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function quizzes()
    {
        return $this->hasManyThrough(Quiz::class, Section::class);
    }

    public function assignments()
    {
        return $this->hasManyThrough(Assignment::class, Section::class);
    }






    public function enrollments()
    {
        return $this->hasMany(EnrollStudent::class, 'course_id');
    }

    // In your Course model
    public function getProgress()
    {
        // Example logic to calculate progress, customize based on your needs
        $totalLessons = $this->lessons->count();
        $completedLessons = $this->lessons->where('completed', true)->count();

        if ($totalLessons > 0) {
            return round(($completedLessons / $totalLessons) * 100);
        }

        return 0; // Default to 0% if no lessons are available
    }






}