<?php 
/*
Plugin Name: Messenger Pluggin
Plugin URI: abc.com
Description: A messenger pluggin
Version:1.0
Author:Akash
Author URI: something.com
*/
?>
<?php


class Messager extends WP_Widget
{
	
	public function __construct()
	{
		$params = array(
			'description' => __('display message to users'),
			'name' => __('Messager')
		);
		parent::__construct('Messager', __('Widget Title', 'text_domain'), $params);

	}


	public function form($instance) 
	{
		if ( isset( $instance[ 'title' ] ) ) 
		{	
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'text_domain' );
		}
	?>
		<p>
			<label for="<?php $this->get_field_id('title'); ?>">Title:</label>
			<input 
				class="widefat" 
				id="<?php $this->get_field_id('title'); ?>"
				name="<?php $this->get_field_name('title'); ?>"
				value="<?php if(isset($title)) echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php get_field_id('description'); ?>">Description:</label>
			<textarea 
				class="widefat" 
				id="<?php get_field_id('description'); ?>"
				name="<?php get_field_name('description'); ?>" value="<?php if(isset($description)) echo esc_attr($description); ?>" />></textarea>
		</p>

		<?php		
	}

	public function widget($args, $instance)
	{
		print_r($args);
	}
}

// add_action('widgets_init', function(){
// 	register_widget('Messager' );
// });
