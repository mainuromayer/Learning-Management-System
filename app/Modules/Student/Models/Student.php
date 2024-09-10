<?php

namespace App\Modules\Student\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Course\Models\Course;
use App\Modules\User\Models\User; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    protected $table ='students';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
