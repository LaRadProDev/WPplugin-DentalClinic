<?php
namespace PassThisTest\Support;

use PassThisTest\Utility\Inflect;
use PassThisTest\Utility\Sanitize;

trait Resourceful
{

    public function setId($id, $resource = false)
    {
        $this->id = Sanitize::underscore($id);
        $this->dieIfReserved();
        if($resource) {
            $singular     = Sanitize::underscore( $this->id );
            $plural       = Sanitize::underscore( Inflect::pluralize($this->id) );
            $this->resource = [$singular, $plural];
        }
        return $this;
    }

    public function setRawId($id, $resource = false)
    {
        $this->id = $id;
        $this->dieIfReserved();
        if($resource) {
            $singular     = $this->id;
            $plural       = Inflect::pluralize($this->id);
            $this->resource = [$singular, $plural];
        }
        return $this;
    }
}