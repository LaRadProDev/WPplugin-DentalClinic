<?php

namespace PassThisTest\Metaboxes;

use PassThisTest\Support\MetaBox;
use PassThisTest\Fields\Wysiwyg;

class ExplanationMetaBox extends MetaBox
{
    protected $name = 'Explanation content';
    protected $screen = 'question';

    public function fields()
    {
        return [
            (new Wysiwyg('explanation_content'))
        ];
    }
}