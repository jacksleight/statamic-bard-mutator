<?php

namespace JackSleight\StatamicBardMutator\Agents;

class Agent
{
    protected $types = [];

    protected $name;

    protected $global = false;

    public function types(array $types = null)
    {
        if (func_num_args()) {
            $this->types = $types;

            return $this;
        }

        return $this->types;
    }

    public function name($name = null)
    {
        if (func_num_args()) {
            $this->name = $name;

            return $this;
        }

        return $this->name;
    }

    public function global($global = null)
    {
        if (func_num_args()) {
            $this->global = $global;

            return $this;
        }

        return $this->global;
    }

    public function processData()
    {
    }

    public function renderHtml()
    {
    }

    public function parseHtml()
    {
    }
}
