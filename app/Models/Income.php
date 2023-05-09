<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'income_category_id',
        'peso',
        'yen',
        'currency_id',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->currency_id) {
                $currency = Currency::where('name', 'PHP')->first();
                if (!$currency) {
                    $currency = new Currency;
                    $currency->name = 'PHP';
                    $currency->symbol = '₽';
                    // $currency->exchange_rate = 1.0; // 初回の場合、デフォルト値を設定する
                    $currency->save();
                }
                $model->currency_id = $currency->id;
            }
        });
    }
}
