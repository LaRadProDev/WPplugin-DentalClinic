<?php

namespace PassThisTest\Support;

use PassThisTest\Utility\Sanitize;

abstract class Registrable
{
    protected $use = [];
    protected $id = null;
    public $args = [];
    protected $reservedNames = [
        'attachment',
        'attachment_id',
        'author',
        'author_name',
        'action',
        'calendar',
        'cat',
        'category',
        'category__and',
        'category__in',
        'category__not_in',
        'category_name',
        'comments_per_page',
        'comments_popup',
        'customize_messenger_channel',
        'customized',
        'cpage',
        'day',
        'debug',
        'error',
        'exact',
        'feed',
        'hour',
        'link_category',
        'm',
        'minute',
        'monthnum',
        'more',
        'name',
        'nav_menu',
        'nonce',
        'nopaging',
        'offset',
        'order',
        'orderby',
        'p',
        'page',
        'page_id',
        'paged',
        'pagename',
        'pb',
        'perm',
        'post',
        'post__in',
        'post__not_in',
        'post_format',
        'post_mime_type',
        'post_status',
        'post_tag',
        'post_type',
        'posts',
        'posts_per_archive_page',
        'posts_per_page',
        'preview',
        'robots',
        's',
        'search',
        'second',
        'sentence',
        'showposts',
        'static',
        'subpost',
        'subpost_id',
        'tag',
        'tag__and',
        'tag__in',
        'tag__not_in',
        'tag_id',
        'tag_slug__and',
        'tag_slug__in',
        'taxonomy',
        'tb',
        'term',
        'theme',
        'type',
        'w',
        'withcomments',
        'withoutcomments',
        'year'
    ];

    public function setId($id)
    {
        $this->id = Sanitize::underscore($id);
        $this->dieIfReserved();
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setArguments(array $args)
    {
        $this->args = $args;
        return $this;
    }

    public function getArguments()
    {
        return $this->args;
    }

    public function getArgument($key)
    {
        if ( ! array_key_exists($key, $this->args)) {
            return null;
        }
        return $this->args[$key];
    }

    public function setArgument($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

    public function removeArgument($key)
    {
        if (array_key_exists($key, $this->args)) {
            unset($this->args[$key]);
        }
        return $this;
    }
    protected function dieIfReserved()
    {
        if (in_array($this->id, $this->reservedNames)) {
            die('TypeRocket: Error, you are using the reserved wp name "' . $this->id . '".');
        }
    }

    public function apply($args)
    {
        if ( ! is_array($args)) {
            $args = func_get_args();
        }
        if ( ! empty($args) && is_array($args)) {
            $this->use = array_merge($this->use, $args);
        }
        $this->uses();
        return $this;
    }

    public function addToRegistry()
    {
        Registry::addRegistrable($this);
        return $this;
    }

    abstract public function register();

    protected function uses()
    {
        foreach ($this->use as $obj) {
            if ($obj instanceof Registrable) {
                $class  = get_class($obj);
                $class  = substr($class, 11 + 9 );
                $method = 'add' . $class;
                if (method_exists($this, $method)) {
                    $this->$method($obj);
                } else {
                    $current_class = get_class($this);
                    die('PassThisTest: You are passing the unsupported object ' . $class . ' into ' . $current_class . '.');
                }
            }
        }
    }

    public function getApplied()
    {
        return $this->use;
    }
}