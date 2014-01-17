<?php 
/*
Plugin Name: First Pluggin
Plugin URI: abc.com
Description: This is to add a widget 
Author:Akash
Version:1.0
Author URI: something.com
*/


function dashboard_widget_function() {
	echo "Hello World, this is my first Dashboard Widget!";
	global $wpdb;
	?>

	<p><b>Last Query:</b><?php echo $wpdb->last_query; ?></p>
	<p><b>Last Error:</b><?php echo $wpdb->last_error; ?></p>
	<p><b>Total Users:</b><?php echo $wpdb->query('select ID from wp_users');  ?></p>
	<?php  
}

// Function used in the action hook
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'First Dashboard Widget', 'dashboard_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );