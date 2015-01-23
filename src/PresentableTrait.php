<?php namespace EscapeWork\LaravelHelpers;

use ReflectionClass;

trait PresentableTrait
{

    /**
     * The presenter
     */
    protected $presenter;

    /**
     * @var  string
     */
    protected $presenterClass = null;

    public function getPresenterAttribute()
    {
        return $this->presenter();
    }

    protected function presenter()
    {
        if (! $this->presenter) {
            $presenterClass  = $this->getPresenterClass();
            $this->presenter = new $presenterClass($this);
        }

        return $this->presenter;
    }

    protected function getPresenterClass()
    {
        if ($this->presenterClass) {
            return $this->presenterClass;
        }

        // 'Escape\Presenters\\' . $reflection->getShortName() . 'Presenter'
        $reflection = new ReflectionClass($this);
        $namespace  = $reflection->getName();
    }
}
