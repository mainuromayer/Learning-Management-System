<?php

namespace App\Modules\Instructor\Models;

use App\Modules\Course\Models\Course;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'instructors';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


