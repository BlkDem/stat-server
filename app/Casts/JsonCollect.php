<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class JsonCollect implements CastsAttributes
{
    /**
     * Преобразовать значение к пользовательскому типу.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        // return json_decode($value, true);
        return collect(json_decode($value, true));
    }

    /**
     * Подготовить переданное значение к сохранению.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        // return json_encode($value);
        return $value;
    }
}
