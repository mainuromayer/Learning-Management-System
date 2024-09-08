<?php

namespace App\Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

//    public function courses()
//    {
//        return $this->belongsTo(Course::class, 'course_id');
//    }
}
