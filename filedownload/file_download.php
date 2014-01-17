<?php
error_reporting(0);
/**
* Plugin Name: File Download Plugin
* Plugin URI: zecross.net
* Description: Plugin to download files
* Version: 1.0
* Author: Akash Arora
* Author URI: akash.arora@zecross.com
*/


/*  2014  AKASH ARORA  (email : akash.arora@zecross.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class File_Download extends WP_Widget

{
	public function __construct()
	{
		$params = array(
            'description' => __('Plugin to download files'),
            'name' => __('File Download')
        );
        parent::__construct('file_download', __('Widget Title', 'text_domain'), $params);
	}


	public function form($instance)
	{
		 
	}

}

function file_download_widget()
{
    register_widget("File_Download");
}
add_action('widgets_init', 'file_download_widget' );



include 'new_post_type.php';

add_file_type('file', array(
	'taxonomies' => array('post_tag'),
	'supports'   => array('title','editor','custom-fields')
));

define('FILE_PLUGIN_URL', plugin_dir_url( __FILE__ ));

add_action( 'admin_enqueue_scripts', 'file_load_js_and_css' );
function file_load_js_and_css() 
{
	global $hook_suffix;


	wp_register_script( 'file.js', FILE_PLUGIN_URL . 'file.js' );
	wp_enqueue_script( 'file.js' );
	
}


