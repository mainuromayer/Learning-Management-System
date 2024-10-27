<?php

namespace App\Modules\Quiz\Models;

use App\Modules\Section\Models\Section;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'course_quizzes';

    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class, 'course_section_id');
    }

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
