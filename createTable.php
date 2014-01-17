<?php 
/*
Plugin Name: Create Database Table
Plugin URI: abc.com
Description: Create a table in the database
Author:Akash
Version:1.0
Author URI: something.com
*/
function table_creation()
{
	global $wpdb;
	$table_name = $wpdb->prefix.'info_data';

	if($wpdb->get_var('show tables like '.$table_name) != $table_name)
	{
		$sql = 'create table '.$table_name.'(
			id integer unsigned auto_increment,
			hit_date timestamp default current_timestamp,
			user_agent varchar(100),
			PRIMARY KEY(id) )';
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		add_option('table_creation_database_version', '1.0' );

	}
}

// register_activation_hook(___FILE__,'table_creation');