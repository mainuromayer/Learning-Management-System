<?php

namespace App\Modules\Assignment\Models;

use App\Modules\User\Models\User;
use App\Modules\Section\Models\Section;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Instructor\Models\Instructor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'course_assignments';

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

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
