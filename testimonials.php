<?php
/*
Plugin Name: Testimonials Post data
Plugin URI: http://github.com/akasharora/wordpress_plugins
Description: A plugin to get testimonials from the custom post type testimonials
Author: Akash Arora
Author URI: http://github.com/akasharora/wordpress_plugins
Version: 1.0
*/

<?php 
 
//created for the purpose of creating testimonial post type and meta boxes
class addMetaBoxes
{
    function __construct()
    {   
        add_action( 'init',array($this,'theme_init') );
        add_action( 'add_meta_boxes', array($this,'add_meta_boxes') );
        add_action( 'save_post', array($this,'save_meta_boxes') );
    }
 
 
    //this is going to add testimonial post type to admin menu
    public function theme_init()
    {
        $test_labels = array(
            'name'               => _x( 'Testimonials', 'post type general name' ),
            'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
            'menu_name'          => _x( 'Testimonials', 'admin menu' ),
            'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar' ),
            'add_new'            => _x( 'Add New', 'Testimonial' ),
            'add_new_item'       => __( 'Add New Testimonial' ),
            'new_item'           => __( 'New Testimonial' ),
            'edit_item'          => __( 'Edit Testimonial' ),
            'view_item'          => __( 'View Testimonial' ),
            'all_items'          => __( 'All Testimonials' ),
            'search_items'       => __( 'Search Testimonials' ),
            'parent_item_colon'  => __( 'Parent Testimonials:' ),
            'not_found'          => __( 'No Testimonials found.' ),
            'not_found_in_trash' => __( 'No Testimonials found in Trash.' ),
        );
 
        $test_args = array(
            'labels'             => $test_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'testimonial' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'thumbnail')
        );
 
        register_post_type( 'testimonial', $test_args );
    }
 
    /*-----------------------------------------------------------------------------------*/
    /* Add Metaboxes
    /*-----------------------------------------------------------------------------------*/
    public function add_meta_boxes()
    {
        add_meta_box(
            'testimonial_metabox',
            __( 'Information', 'twentyfourteen' ),
            array($this,'testimonial_meta_box_callback'),
            'testimonial',
            'normal',
            'high'
        );
    }
 
 
    public function testimonial_meta_box_callback()
    {
        global $post;
        //nonce creates an input field which is used for security purposes
        wp_nonce_field( 'tf_post_nonce', 'tf_post_nonce' );
        ?>
        <span id="counter" style="color:green; display:block; float:right; padding-right:45px;"></span><!-- needs counter to work -->
 
        <!--label for textarea-->
        <label class="testimonial-lbl" for="client_words"><?php _e('What your customer had to say', 'twentyfourteen') ?></label>
        <textarea class="simpleLimitTextarea input-custom-field" rows="4" cols="100" name="client_words" id="client_words" placeholder="Client's words here"><?php echo get_post_meta($post->ID,'client_words',true); ?></textarea><br>
 
        <label class="testimonial-lbl" for="tf_team_position"><?php _e('Position and Company', 'twentyfourteen') ?></label><br>
        <input type="text" class="input-custom-field" name="tf_team_position" id="tf_team_position" placeholder="e.g: Position, Company Name"  value="<?php echo get_post_meta($post->ID, 'tf_team_position', true) ?>"><br>
 
        <style type="text/css">
            input.input-custom-field{width: 300px; margin-bottom: 15px;margin-top: 15px;}
            label.testimonial-lbl{min-width: 70px;}
        </style>
        <?php
    }
 
    //this is to save the meta information
    public function save_meta_boxes($post_id)
    {
        if ( get_post_type( $post_id ) ==  'testimonial' ){
 
            // check against external requests -- check for hacks
            if ( ! isset( $_POST['tf_post_nonce'] ) )
                return $post_id;
 
            if ( ! wp_verify_nonce( $_POST['tf_post_nonce'], 'tf_post_nonce' ) )
                return $post_id;
 
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;
 
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
 
            if(isset($_POST['tf_team_position']))
                update_post_meta( $post_id, 'tf_team_position', $_POST['tf_team_position'] );
            if(isset($_POST['client_words']))
                update_post_meta($post_id,'client_words',$_POST['client_words']);
 
        }
        return $post_id;
    }
 
 
}
 
new addMetaBoxes();
 
 
Limit_Excerpt_Words::on_load();
 
//this class is to limit number of words in testimonial text area
class Limit_Excerpt_Words 
{
    static function on_load() 
    {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
    }
 
    static function admin_enqueue_scripts() 
    {
        global $hook_suffix;
        if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) 
        {
            wp_enqueue_script( 'jquery-simply-countable', plugins_url( '/jquery.simplyCountable.js'), array( 'jquery' ));
            add_action( 'admin_print_footer_scripts', array( __CLASS__, 'admin_print_footer_scripts' ) );
        }
    }
 
    static function admin_print_footer_scripts() 
    {
        ?>
        <script type='text/javascript'>
        /*this is the script to limit the characters in textarea of testimonials*/
            jQuery(document).ready(function ($){
 
                $('textarea.simpleLimitTextarea').simplyCountable({
                    counter:'#counter',
                    strictMax:true,
                    countType:'characters',
                    maxCount:400,
                    strictMax:true,
                });
 
            });
        </script>
    <?php
    }
}
 
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
