<?php 
/*
Plugin Name: Simple Widget
Plugin URI: simplewidget.com
Description: a simple widget
Author:Akash
Version:1.0
Author URI: 
*/

class SimpleWidget extends WP_Widget
{
	
	public function __construct()
	{
		$params = array(
			'description' => __('display message to users'),
			'name' => __('Simple Widget')
		);
		parent::__construct('simple_widget', __('Widget Title', 'text_domain'), $params);
	}

//to display content on the front end
	public function widget($args,$instance) 
	{

		extract($args, EXTR_SKIP);
		$title = ( $instance['title'] ) ? ( $instance['title'] ) : 'A simple Widget';
		$body = ( $instance['body'] ) ? ( $instance['body'] ) : 'No text Available';
		?>
		<?php echo $before_widget; ?>
		<?php echo $before_title.$title.$after_title; ?>
		<p><?php echo $body; ?></p>
		<?php echo $after_widget; ?>
		<?php
	}

//to create form on the back end
	public function form($instance)
	{	
		$title = $instance['title'];
		$body = $instance['body'];
		?>

		<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title:', 'php-code-widget'); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name = "<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />

		
		<label for="<?php echo $this->get_field_id('body'); ?>">Body:</label>
		<textarea 
		class="widefat" 
		id="<?php echo $this->get_field_id('body'); ?>"
		name = "<?php echo $this->get_field_name('body'); ?>"
		><?php echo esc_attr($body ); ?></textarea>
		<?php
	}

	//we would not be using the update method here because our methods overrides the default method if we use it
}


function simple_widget_init()
{
 	register_widget("SimpleWidget");
}
add_action('widgets_init', 'simple_widget_init' );

 ?>
