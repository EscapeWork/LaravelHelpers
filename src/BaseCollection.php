<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Collection;

class BaseCollection extends Collection
{

    /**
     * Combobox options
     */
    protected $comboxBoxOptions = [
        'empty_option'       => false,
        'empty_option_label' => 'Selecione',
        'field'              => 'title',
    ];

    public function combobox($options = [])
    {
        $options = array_merge($this->comboxBoxOptions, $options);
        $data    = [];

        if ($options['empty_option']) {
            $data[null] = $options['empty_option_label'];
        }

        foreach ($this->items as $item) {
            $data[$item->{$item->getKeyName()}] = $item->$options['field'];
        }

        return $data;
    }
}
