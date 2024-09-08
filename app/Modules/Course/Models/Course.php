<?php

namespace App\Modules\Course\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Modules\Catagory\Models\Catagory;

class Course extends Model
{
    use HasFactory;
        protected $table = 'courses';

    // public function catagories()
    // {
    //     return $this->belongsTo(Catagory::class, 'id');
    // }
}
