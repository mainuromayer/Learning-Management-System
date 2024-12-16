<?php

namespace App\Modules\Student\Models;

use App\Modules\Quiz\Models\Quiz;
use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;
use App\Modules\Lesson\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enroll_students', 'student_id', 'course_id');
    }

    // Method to get completed lessons
    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'completed_lessons', 'student_id', 'course_lesson_id')
            ->where('completed', true);
    }

    // Method to get completed quizzes
    public function completedQuizzes()
    {
        return $this->belongsToMany(Quiz::class, 'completed_quizzes', 'student_id', 'course_quiz_id')  // সঠিক কলাম নাম ব্যবহার করুন
            ->where('completed', true);
    }

    // Method to get completed assignments
    public function completedAssignments()
    {
        return $this->belongsToMany(Assignment::class, 'completed_assignments', 'student_id', 'course_assignment_id')  // সঠিক কলাম নাম ব্যবহার করুন
            ->where('completed', true);
    }

    // Method to calculate the number of completed items for a specific course
    public function completedItemsForCourse($courseId)
    {
        $completedLessonsCount = $this->completedLessons()
            ->whereHas('section', function($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->count();

        $completedQuizzesCount = $this->completedQuizzes()
            ->whereHas('section', function($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->count();

        $completedAssignmentsCount = $this->completedAssignments()
            ->whereHas('section', function($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->count();

        // Return the total count of completed items for the course
        return $completedLessonsCount + $completedQuizzesCount + $completedAssignmentsCount;
    }
}


