<?php

namespace PassThisTest\Support;

use PassThisTest\Core\Config;
use PassThisTest\Utility\Sanitize;
use PassThisTest\Support\Saveable;

abstract class MetaBox extends Registrable
{
    use Saveable;

    protected $label = null;
    protected $callback = null;
    protected $context = null;
    protected $priority = null;
    protected $post_type = null;
    protected $screens = [];

    /**
     * Make Meta Box
     *
     * @param string $name
     * @param null|string|array $screen
     * @param array $settings
     */
    public function __construct( array $settings = [])
    {
        $this->label = $this->id = $this->name;
        $this->id    = Sanitize::underscore( $this->id );
        $this->post_type = !post_type_exists($this->screen) ?: $this->screen;

        if ( ! empty( $settings['callback'] )) {
            $this->callback = $settings['callback'];
        }
        if ( ! empty( $settings['label'] )) {
            $this->label = $settings['label'];
        }
        unset( $settings['label'] );
        $defaults = [
            'context'  => 'normal', // 'normal', 'advanced', or 'side'
            'priority' => 'high', // 'high', 'core', 'default' or 'low'
            'args'     => []
        ]; // arguments to pass into your callback function.

        $settings = array_merge( $defaults, $settings );

        $this->context  = $settings['context'];
        $this->priority = $settings['priority'];
        $this->args     = $settings['args'];

        $this->register();
    }
    /**
     * Set the meta box label
     *
     * @param $label
     *
     * @return $this
     */
    public function setLabel( $label )
    {
        $this->label = (string) $label;
        return $this;
    }
    /**
     * Set the meta box label
     *
     * @return $this->label
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Add meta box to a screen
     *
     * @param string|array $screen
     *
     * @return $this
     */
    public function addScreen( $screen )
    {
        $this->screens = array_merge( $this->screens, (array) $screen );
        return $this;
    }
    /**
     * Add meta box to post type
     *
     * @param string|array|PostType $s
     *
     * @return $this
     */
    public function addPostType( $s )
    {
        if ($s instanceof CPT) {
            $s = $s->getId();
        } elseif (is_array( $s )) {
            foreach ($s as $n) {
                $this->addPostType( $n );
            }
        }
        if ( ! in_array( $s, $this->screens )) {
            $this->screens[] = $s;
        }
        return $this;
    }
    /**
     * Register meta box with WordPress
     *
     * @return $this
     */
    public function registerMetaBox()
    {
        add_meta_box(
            $this->id,
            $this->label,
            [$this, 'callback'],
            $this->screen,
            $this->context,
            $this->priority
        );

        return $this;
    }

    abstract public function fields();

    public function register()
    {
        $this->add_hook_on_save();
        add_action('add_meta_boxes', [$this, 'registerMetaBox']);
    }
    /**
     * @return null
     */
    public function getPriority()
    {
        return $this->priority;
    }
    /**
     * @param null $priority
     *
     * @return MetaBox
     */
    public function setPriority( $priority )
    {
        $this->priority = $priority;
        return $this;
    }
    /**
     * @param null $context
     *
     * @return MetaBox
     */
    public function setContext( $context )
    {
        $this->context = $context;
        return $this;
    }
    /**
     * @return null
     */
    public function getContext()
    {
        return $this->context;
    }
    public function setCallback( $callback )
    {
        if (is_callable( $callback )) {
            $this->callback = $callback;
        } else {
            $this->callback = null;
        }
        return $this;
    }

    public function callback()
    {
        foreach ($this->fields() as $field) {
            $field->render();
        }
    }

    /**
     * @return null
     */
    public function getCallback()
    {
        return $this->callback;
    }
}