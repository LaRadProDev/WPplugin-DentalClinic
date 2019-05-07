<?php

namespace PassThisTest\Fields;

class Wysiwyg extends Field
{
    public function setType()
    {
        $this->type = 'wysiwyg';
    }

    public function template()
    {
        wp_editor($this->value, 'ptt_explanation_content');
        return 'fields/wysiwyg.twig';
    }
}