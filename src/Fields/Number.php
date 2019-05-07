<?php

namespace PassThisTest\Fields;

class Number extends Field
{
    public function setType()
    {
        $this->type = 'number';
    }

    public function template()
    {
        return 'fields/number.twig';
    }
}