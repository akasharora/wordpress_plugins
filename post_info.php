<?php 
/*
Plugin Name: Post Info
Plugin URI: abc.com
Description: Information regarding the posts in the sidebar
Author:Akash
Version:1.0
Author URI: something.com
*/

class Post_Info extends WP_Widget
{
	
	public function __construct()
	{
		$params = array(
			'description' => __('display recent posts and comments'),
			'name' => __('Post Info')
		);
		parent::__construct('post_info', __('Widget Title', 'text_domain'), $params);
	}

	public function widget($args,$instance)
 	{

 		//if we use WP_Query(); class it will query whole posts and not the posts on that page
 		//WP_Query() is used as class_object->have_posts() , class_object->the_post()
 		?>

	 	<h3>posts on this page</h3>
	 	<?php if (have_posts()):
	 		while (have_posts()) :
				the_post(); ?>
				<div>
					<a href="<?php echo the_permalink(); ?>" title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a>
					(<?php echo comments_number(); ?>)
				</div>
			<?php endwhile;
		endif;	 ?>
		<?php
	}
}


function post_info_init()
{
 	register_widget("Post_Info");
}
add_action('widgets_init', 'post_info_init' );
