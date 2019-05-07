<?php

namespace PassThisTest\Fields;

use PassThisTest\Http\Request;
use PassThisTest\Support\View;

abstract class Field
{
    public $uuid;
    public $value = null;
    protected $name = null;
    protected $type = null;
    protected $required = false;
    protected $withLabel = false;
    protected $multivalue = false;
    protected $request;

    public function __construct($name, $value = null, $attr = [], $settings = [], $withLabel = true) 
    {
        $this->request = new Request;
        $this->uuid = 'ptt_' . strtolower(str_replace(' ', '_', $name));
        $this->value = $this->request->getMethod() === 'GET' ? $this->getSavedMeta() : $this->request->post[$this->uuid];
        $this->name = $name;
        $this->withLabel = $withLabel;

        $this->setType();

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function multivalue()
    {
        $this->multivalue = true;

        return $this;
    }

    public function isRequired()
    {
        $this->required = true;

        return $this;
    }

    public function getSavedMeta() {
        return get_post_meta(get_the_ID(), $this->uuid, true);
    }

    public function render()
    {
        return View::render($this->template(), [
            'uuid' => $this->uuid,
            'name' => $this->name, 
            'type' => $this->type, 
            'value' => $this->value,
            'withLabel' => $this->withLabel,
            'required' => $this->required,
            'multivalue' => $this->multivalue
        ]);
    }

    abstract public function template();

    abstract public function setType();

}