<?php

namespace App\Modules\Course\Models;

use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class); // Assuming a lesson belongs to a course
    }

    public function sections()
    {
        return $this->hasMany(Section::class); // Assuming a section belongs to a course
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student'); // Assuming a many-to-many relationship with students
    }
}

