<?php

namespace PassThisTest\Models;


use \WeDevs\ORM\Eloquent\Model;

class QuestionMeta extends Model
{
    protected $primaryKey = 'meta_id';

    public $timestamps = false;

    public function getMetaValueAttribute($value)
    {
        return maybe_unserialize($value);
    }
    
    public function getTable()
    {
        return $this->getConnection()->db->prefix . 'postmeta';
    }
}