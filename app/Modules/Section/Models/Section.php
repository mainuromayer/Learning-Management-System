<?php

namespace App\Modules\Section\Models;

use App\Modules\Quiz\Models\Quiz;
use App\Modules\Course\Models\Course;
use App\Modules\Lesson\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Assignment\Models\Assignment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $table = 'course_sections';

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_section_id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'course_section_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'course_section_id');
    }
}

