<?php

namespace Encore\Admin\Form\Field;

use Closure;
use Encore\Admin\Form\Field;

class DisplayFromKey extends Field
{
    protected $callback;

    public function format(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function render()
    {
        if (is_callable($this->options)) {
            $options = call_user_func($this->options, $this->value);
            $this->options($options);
        }
        $this->options = array_filter($this->options);

        return parent::render()->with(['options' => $this->options]);

    }

    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (is_callable($options)) {
            $this->options = $options;
        } else {
            $this->options = (array) $options;
        }

        return $this;
    }
}