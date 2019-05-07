<?php

namespace PassThisTest\Schemas;

use PassThisTest\Schemas\Abstracts\Schema;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class SchemaStats extends Schema 
{

	public function __construct($table_name) 
	{
		parent::__construct($table_name);
	}

	public function setup()
	{
		$sql = "CREATE TABLE IF NOT EXISTS {$this->table_prefix}{$this->table_name} (
                            ID INT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT,
                            user_id BIGINT( 20 ) UNSIGNED NOT NULL,
                            avg_score TINYINT( 3 ) UNSIGNED,
                            rank TINYINT( 3 ) UNSIGNED,
                            answered_questions_num INT( 20 ) UNSIGNED,
                            PRIMARY KEY  ( ID )
                        ) {$this->charset_collate}";

		dbDelta( $sql );
	}

	public function delete()
	{
		global $wpdb;
		$wpdb->query('SET foreign_key_checks = 0');

		$sql = "DROP TABLE IF EXISTS {$this->table_prefix}{$this->table_name}";
		$wpdb->query($sql);

		$wpdb->query('SET foreign_key_checks = 1');
	}

}