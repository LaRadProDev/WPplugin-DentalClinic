<?php

namespace PassThisTest\Schemas;

use PassThisTest\Schemas\Abstracts\Schema;

/**
 * Class SchemaFactory
 * @package Revisiter\Schema
 */

class SchemaFactory 
{

	/**
	 * @var array
	 */
	private $schemas = array();

	/**
	 * @var
	 */
	protected static $instance;

	/**
	 * @return mixed
	 */
	public static function get_instance()
	{

		if( is_null( static::$instance ) ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * SchemaFactory constructor.
	 */
	private function __construct() 
	{
	}

	/**
	 * @param $schema
	 *
	 * @return bool
	 */
	public function register( $schema, $table_name ) 
	{
		$schema_obj = new $schema($table_name);
		if ( $schema_obj instanceof Schema) {
			if ( ! in_array( $schema_obj, $this->schemas ) ) {
				$this->schemas[] = $schema_obj;
			}
			return true;
		}
		return false;
	}

	/**
	 * @param $schema
	 *
	 * @return bool
	 */
	public function unregister( $schema ) 
	{
		$schema_obj = new $schema;
		if ( $schema_obj instanceof Schema ) {
			if ( in_array( $schema_obj, $this->schemas ) ) {
				unset( $this->schemas[$schema_obj] );

				return true;
			}
			return false;
		}
		return false;
	}

	/**
	 * Setup registered schemas.
	 */
	public function setup_schemas() 
	{
		foreach ( $this->schemas as $schema_obj ) {
			$schema_obj->setup();
		}
	}

}