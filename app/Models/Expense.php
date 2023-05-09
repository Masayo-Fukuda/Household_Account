<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'expense_category_id',
        'peso',
        'yen',
        'currency_id',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime:m/d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
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
                $currency->save();
            }
            $model->currency_id = $currency->id;
        }
    });
}

}
