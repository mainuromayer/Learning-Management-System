<?php

namespace App\Traits;
use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Auth;

trait ModelLifeCycleTrait{


    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::guest()) {
                $model->created_by = 0;
                $model->updated_by = 0;
            } else {
                $model->created_by = CommonFunction::getUserId();
                $model->updated_by = CommonFunction::getUserId();
            }
        });

        static::updating(function ($model) {
            if (Auth::guest()) {
                $model->updated_by = 0;
            } else {
                $model->updated_by = CommonFunction::getUserId();
            }
        });

    }

}
