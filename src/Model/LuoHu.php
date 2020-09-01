<?php


namespace Zxdstyle\Count\Model;

use Illuminate\Database\Eloquent\Model;

class LuoHu extends Model
{
    protected $table = "lh_luohu";

    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->ip = request()->getClientIp();
        });
    }
}