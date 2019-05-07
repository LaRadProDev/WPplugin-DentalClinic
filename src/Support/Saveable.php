<?php

namespace PassThisTest\Support;

trait Saveable
{
    public function add_hook_on_save()
    {
        add_action("save_post_{$this->screen}", [$this, 'save_callback']);
    }

    public function save_callback($post_id)
    {
        foreach ($this->fields() as $field) {
            if ($field->value) {
                update_post_meta($post_id, $field->uuid, $field->value);
            }
        }
    }
}