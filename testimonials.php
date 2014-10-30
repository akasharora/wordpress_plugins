<?php
/*
Plugin Name: Testimonials Post data
Plugin URI: http://github.com/akasharora/wordpress_plugins
Description: A plugin to get testimonials from the custom post type testimonials
Author: Akash Arora
Author URI: http://github.com/akasharora/wordpress_plugins
Version: 1.0
*/

function show_testimonials( $atts, $content="")
{
	$args = array( 'post_type' => 'testimonial', 'posts_per_page' => 10 );
	$loop = new WP_Query( $args );
	// var_dump($loop); die();
	?>
	<div class="slide2 slides" id="slide2">
		<div id="testimonials">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2 data-350-bottom="opacity:0; top:-100px;" data-200-top="opacity:1; top:0" data-anchor-target="#slide2"><?php echo $content; ?></h2>


						<ul class="bxslider" data-350-bottom="opacity:0; bottom:-100px;" data-200-bottom="opacity:1; bottom:0" data-anchor-target="#slide2">

							<?php 
								$thumbnail_attr = array(
									'class' => 'testimonial-image'
								);
								while ( $loop->have_posts() ) : $loop->the_post();

									?>
									<li>
										<div class="image-area">
											<?php 
												if ( has_post_thumbnail() ) 
												{ 	
													// check if the post has a Post Thumbnail assigned to it.
													the_post_thumbnail('thumbnail',$thumbnail_attr);
												} else
												{
													?>
													<img  class="testimonial-image" src="<?php echo get_template_directory_uri().'/'.'images/icon_circle.png' ?>" alt="">
													<?php 
												} 
											?>
										</div>
										<div class="test-outr">
											<h3><?php the_title(); ?>
	
											<span><?php echo ucwords( get_post_meta( $loop->post->ID, 'tf_team_position', true ) ) ; ?></span></h3>
											<p><?php echo get_post_meta( $loop->post->ID, 'client_words', true ); ?></p>
										</div>
									</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
}

add_shortcode( 'testimonials', 'show_testimonials' );
?>
