<?php

namespace App\Modules\Category\Models;

use App\Modules\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    // In Category model
public function courses()
{
    return $this->hasMany(Course::class);
}

}
