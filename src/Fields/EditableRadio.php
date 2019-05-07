<?php

namespace PassThisTest\Fields;

class EditableRadio extends Field
{
    public function setType()
    {
        $this->type = 'edit_radio';
    }

    public function template()
    {
        return 'fields/editable-radio.twig';
    }

    public function getSavedMeta() {
        return wp_json_encode(get_post_meta(get_the_ID(), 'answers', true));
    }
}