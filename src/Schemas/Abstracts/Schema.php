<?php

namespace PassThisTest\Schemas\Abstracts;

/**
 * Class Schema
 */

abstract class Schema {

	/**
	 * @var
	 */
    protected $table_prefix;
    
	/**
	 * @var
	 */
	protected $table_name;

	/**
	 * @var
	 */
	protected $charset_collate;

	/**
	 * Schema constructor.
	 */
    protected function __construct($table_name) 
    {
		global $wpdb;

        $this->table_prefix = $wpdb->prefix;
        $this->table_name = $table_name;
		$this->charset_collate = $wpdb->get_charset_collate();
	}

	/**
	 * @return mixed
	 */
	abstract public function setup();

	abstract public function delete();

}