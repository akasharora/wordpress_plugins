<?php
/**
 * Plugin Name: Portfolio Sidebar
 * Description:  Publish a list of portfolio in your sidebar
 * Plugin URI: http://zecross.com
 * Author: Akash
 * Author URI: http://zecross.com
 * Version: 1.0
 **/
?>
<?php 

global $query_string; query_posts('post_type=portfolio' );       //quering for portfolio posts
if( have_posts() ) 
{	?>
	
	<div id="portfolio-sidebar">               <!--Creating a container div-->

		<div id="ps-top-title">					<!--Widget title-->
			<p>Latest Posts</p>
		</div>

		<?php while ( have_posts() : the_post(); )   ?>          <!--looping in for portfolio posts-->
		
			



		

		
		
	</div>

	<?php 
}

 ?>