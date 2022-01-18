<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Perusahaan extends Model
{
    protected $table = "perusahaan";
    protected $primaryKey = "id";

    protected $guarded = [];

    protected $hidden = [];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = is_object(Auth::guard(config('web'))->user()) ? Auth::guard(config('web'))->user()->id : 1;
            $model->updated_by = NULL;
        });

        static::updating(function ($model) {
            $model->updated_by = is_object(Auth::guard(config('web'))->user()) ? Auth::guard(config('web'))->user()->id : 1;
        });
    }
}
