<?php
/**
* Plugin Name: Facebook Feed
* Plugin URI: zecross.net
* Description: Plugin to display last 5 facebook posts from a page
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


// include the facebook sdk
require_once('src/facebook.php');

// connect to app
$config = array();
$config['appId'] = '527340380667670';
$config['secret'] = '5f12f9e98ece9b2c3916e8cbe28b592f';
$config['fileUpload'] = false; // optional

// instantiate
$facebook = new Facebook($config);
$pageID = 297196643687507;
$pagefeed = $facebook->api('297196643687507/feed?limit=5');



class Facebook_Feed extends WP_Widget
{
    
    public function __construct()
    {
        $params = array(
            'description' => __('display last 5 facebook post to users'),
            'name' => __('Facebook Feed')
        );
        parent::__construct('facebook_feed', __('Widget Title', 'text_domain'), $params);
    }

    public function widget($args,$instance)
    {   
        global $pagefeed;
        echo $before_widget; ?>
        <?php echo $before_title.'Facebook Feed'.$after_title; 
        include ('feed_structure.php');        
        echo $after_widget;
    }


}

function facebook_widget_init()
{
    register_widget("Facebook_Feed");
}
add_action('widgets_init', 'facebook_widget_init' );
