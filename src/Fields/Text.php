<?php

namespace PassThisTest\Fields;

class Text extends Field
{
    public function setType()
    {
        $this->type = 'text';
    }

    public function template()
    {
        return 'fields/text.twig';
    }
}