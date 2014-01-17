<?php 
/*
Plugin Name: Welcome
Plugin URI: abc.com
Description: It creates a comment section in the settings menu
Author:Akash
Version:1.0
Author URI: welcome.com
*/

// via this pluggin we are going to add  a new option to the settings menu

function aa_option_page() 
{	
	if(isset($_POST['aa_hidden'])) {
		if($_POST['aa_hidden'] == 'Y')
		{
			update_option( 'aa_option_email', $_POST['aa_email'] );
			?>
			<div id="message" class="updated">
				<h2>Your Email has been Updated</h2>
			</div>
			<?php  
		}	
	}
	?>
	<div class="wrap">
		<?php //screen_icon();  ?>
		<h2>CC comments option</h2>
		<p>What you can do here is you can edit the mails that are sent to you when comment(s) is/are added</p>
	</div>
	<form action="" method="post" id="aa_comments_form">
		<h3><label for="aa_email">Send Email To:</label>
		<input type="text" name="aa_email" id="aa_email" value="<?php echo esc_attr(get_option( 'aa_option_email' )); ?>"></h3>
		<input type="hidden" name="aa_hidden" value="Y">
		<p><input type="submit" name="submit" value="save email"></p>
	</form>
	<?php  
}

function aa_plugin_menu()
{
	add_options_page( 'Comments Section', 'Comments', 'manage_options', 'aa-comments-plugin', 'aa_option_page' );
	

}

add_action('admin_menu','aa_plugin_menu');