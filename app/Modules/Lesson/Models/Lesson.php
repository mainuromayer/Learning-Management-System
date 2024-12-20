<?php

namespace App\Modules\Lesson\Models;

use App\Modules\User\Models\User;
use App\Modules\Section\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'course_lessons';

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'course_section_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
