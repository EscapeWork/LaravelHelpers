<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Collection;

class BaseCollection extends Collection
{

    public function combobox($field = 'title')
    {
        $data = array();

        foreach ($this->items as $item) {
            $data[$item->id] = $item->$field;
        }

        return $data;
    }
}
