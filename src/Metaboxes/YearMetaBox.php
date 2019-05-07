<?php

namespace PassThisTest\Metaboxes;

use PassThisTest\Support\MetaBox;
use PassThisTest\Fields\Number;
use PassThisTest\Fields\Text;

class YearMetaBox extends MetaBox
{
    protected $name = 'Year';
    protected $screen = 'question';
    
    public function fields()
    {
        return [
            (new Number('Year'))->isRequired(),
        ];
    }
}