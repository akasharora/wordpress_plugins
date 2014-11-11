<?php 
/*
Plugin Name: Header, footer and contact us texts
Plugin URI: http://github.com/akasharora
Description: It creates a section in setting with an option for changing different texts
Author:Akash Arora
Version:1.0
Author URI: http://github.com/akasharora
*/

// via this pluggin we are going to add  a new option to the settings menu

function aa_option_page() 
{	
	if(isset($_POST['aa_hidden'])) {
		if($_POST['aa_hidden'] == 'aa')
		{
			update_option( 'aa_option_header_text', $_POST['aa_header_text'] );
			update_option('aa_option_footer_text',$_POST['aa_footer_text']);
			update_option('aa_option_contact_us',$_POST['aa_contact_us_text']);
			?>
			<div id="message" class="updated">
				<h4>Your preferences have been updated</h4>
			</div>
			<?php  
		}
	}
	?>
	<div class="wrap">
		<?php //screen_icon();  ?>
		<h2>Header and Footer text options</h2>
		<p>what you can do here is change the texts that are being displayed next to hertz logo, text for contact us in header and again text for footer section</p>
	</div>
	<form action="" method="post" id="aa_comments_form">
		<h3><label for="aa_header_text">Header Text:</label>
		<input type="text" name="aa_header_text" id="aa_header_text" value="<?php echo esc_attr(get_option( 'aa_option_header_text' )); ?>"></h3>
		<h3><label for="aa_contact_us_text">Contact Us Text</label>
		<input type="text" name="aa_contact_us_text" id="aa_contact_us_text" value="<?php echo esc_attr(get_option('aa_option_contact_us')); ?>"></h3>
		<h3><label for="aa_footer_text">Footer Text</label>
		<input type="text" name="aa_footer_text" id="aa_footer_text" value="<?php echo esc_attr(get_option('aa_option_footer_text')); ?>"></h3>
		<input type="hidden" name="aa_hidden" value="aa">
		<p><input type="submit" name="submit" value="save"></p>
	</form>
	<?php  
}

function aa_plugin_menu()
{
	add_options_page( 'Custom Texts Section', 'Custom Texts', 'manage_options', 'aa-custom-texts', 'aa_option_page' );
}

add_action('admin_menu','aa_plugin_menu');
