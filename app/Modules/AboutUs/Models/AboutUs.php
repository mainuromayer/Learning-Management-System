<?php

namespace App\Modules\AboutUs\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us'; // Ensure the correct table name
    

    // protected $casts = [
    //     'gallery' => 'array',
    // ];
    public $timestamps = true;
}
