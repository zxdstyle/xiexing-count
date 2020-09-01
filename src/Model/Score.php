<?php


namespace Zxdstyle\Count\Model;


use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = "lh_scores";

    protected $fillable = [
        "id", "ip", "openid", "token", "name", "sex", "phone", "score", "url", "crm", "session_key",
        "one_step", "two_step", "three_step", "four_step", "five_step", "six_step",
        "seven_step", "eight_step", "nine_step", "ten_step", "eight_step", "eleven_step"
    ];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->ip = request()->getClientIp();
        });
    }

    public function setIntegralAttribute($value)
    {
        $this->attributes['openid'] = $value;
    }
}