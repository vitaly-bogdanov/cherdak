<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Устанавливаем связь "один ко многим" таблицы category с таблицей product.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Получаем записи.
     */
    public static function getParametrs($id)
    {
        $params = [
            'menu' => self::all(),
            'category' => self::find($id)
        ];

        return $params;
    }
}
