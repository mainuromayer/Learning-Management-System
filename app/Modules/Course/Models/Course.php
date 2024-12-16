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

    public function lesson(): HasMany
    {
        return $this->hasMany(Lesson::class); // Assuming a lesson belongs to a course
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id');
    }



    public function students()
    {
        return $this->belongsToMany(Student::class, 'enroll_students'); // Many-to-many relationship
    }


    public function enrollments()
    {
        return $this->hasMany(EnrollStudent::class, 'course_id');
    }

    // In your Course model
public function getProgress()
{
    $student = auth()->user()->student;

    // Get the total number of lessons, quizzes, and assignments for the course
    $totalItems = $this->sections->sum(function ($section) {
        $lessonCount = $section->lessons ? $section->lessons->count() : 0;
        $quizCount = $section->quizzes ? $section->quizzes->count() : 0;
        $assignmentCount = $section->assignments ? $section->assignments->count() : 0;

        return $lessonCount + $quizCount + $assignmentCount;
    });

    // Get the number of completed items for the course
    $completedItems = $student->completedItemsForCourse($this->id);

    // Calculate and return the progress percentage
    return $totalItems ? round(($completedItems / $totalItems) * 100, 2) : 0;
}





}