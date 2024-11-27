<?php

namespace App\Modules\AboutUs\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us'; // Ensure the correct table name
    

    // If you are using timestamp columns in your table
    public $timestamps = true;
}
