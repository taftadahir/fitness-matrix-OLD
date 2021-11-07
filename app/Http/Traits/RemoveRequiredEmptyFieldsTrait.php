<?php

namespace App\Http\Traits;

trait RemoveRequiredEmptyFieldsTrait
{
    public static function removeRequiredEmptyFields($datas, $fields = [])
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $datas) && $datas[$field] == null) {
                unset($datas[$field]);
            }
        }
        return $datas;
    }
}
