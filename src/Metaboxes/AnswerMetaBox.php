<?php

namespace PassThisTest\Metaboxes;

use PassThisTest\Support\MetaBox;
use PassThisTest\Fields\EditableRadio;

class AnswerMetaBox extends MetaBox
{
    protected $name = 'Answers';
    protected $screen = 'question';

    public function fields()
    {
        return [
            (new EditableRadio('answers'))->multivalue()
        ];
    }
}