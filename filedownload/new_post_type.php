<?php 

function add_file_type($name, $args = array()) 
{
	add_action('init', function() use($name,$args) 
	{            //anonymous function works only with php 5.3 and above
		$upper =  ucwords($name);
		$name = strtolower(str_replace(' ', '_', $name));

		$arg = array_merge( 
			array(
				'public'     => true,
				'label'      => "All $upper".'s',
				'labels'     => array('add_new_item'=>"Add New $upper")
			), 
			$args);

		register_post_type($name,$arg);
	});

}

//post_type = the custom post type it is associated with
function add_file_taxonomy($name,$post_type, $args=array()) 
{                     
	add_action('init',function() use($name,$post_type, $args) 
	{
		register_taxonomy($name,$post_type,$args);
	});
}

add_action('add_meta_boxes', function() 
{
	add_meta_box( 
		'add_file_info',
		'file Info',		//label of the custom field
		'aa_file_info', //function to be called
		'file',		  //associated to post type
		'normal',
    	'high' 
    );
});

function aa_file_info() 
{ 
	global $post;
	$url=get_post_meta( $post->ID, 'aa_file_url', true );
	//unique identifier of hidden field
	//nonce creates a hidden field with a unique id
	wp_nonce_field(__FILE__,'aa_file_url' );
	?>
	<?php var_dump($post->ID); ?>
	<label for="aa_file_url">Associated URL</label>
	<input type="text" name="aa_file_url" id="aa_file_url" value="<?= $url; ?>" />
	
	<?php 
}

add_action('save_post', function(){
	global $post;
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	//nonce security check
	if(!isset($_POST['aa_file_url']) || wp_verify_nonce( $_POST['aa_file_url'], __FILE__ )) 
	{
		if(isset($_POST['aa_file_url']) ) 
		{
			update_post_meta( $post->ID, 'aa_file_url', $_POST['aa_file_url']);
		}
	}	
});






function add_file_meta_box() {  
    add_meta_box(  
        'custom_meta_box', // $id  
        'Add file Details', // $title   
        'show_custom_file_box', // $callback  
        'file', // $page  
        'normal', // $context  
        'high'); // $priority  
         
    }     
add_action('add_meta_boxes', 'add_file_meta_box');

$prefix = 'custom_';
$custom_meta_file_fields = array(  
        'label'=> 'Type',  
        'desc'  => 'What type is it eg:noun,verb etc',  
        'id'    => $prefix.'type',  
        'type'  => 'image',
        'name'  =>  'type'
    );  

 


function show_custom_file_box() 
{
    global $custom_meta_file_fields, $post;  
    // Use nonce for verification  
    echo '<input type="hidden" name="custom_box" value="'.wp_create_nonce(basename(__FILE__)).'" />';
      
    // Begin the field table and loop
    echo '<table class="form-table">';  
    foreach ($custom_meta_file_fields as $field) {  
        // get value of this field if it exists for this post  
        $meta = get_post_meta(get_the_id(), $field['id'], true);
        var_dump($field);
        // begin a table row with  
        echo '<tr> 
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
                <td>';  
                switch($field['type']) {  
                    
                    case 'image':  
                        $image = get_template_directory_uri().'/images/image.png';    
                        echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';  
                        if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }                 
                        echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" /> 
                                    <img src="'.$image.'" class="custom_preview_image" alt="" /><br /> 
                                        <input class="custom_upload_image_button button" type="button" value="Choose Image" /> 
                                        <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small> 
                                        <br clear="all" /><span class="description">'.$field['desc'].'';  
                        break; 
                           
                } //end switch
        echo '</td></tr>';  
    } // end foreach  
    echo '</table>'; // end table  
}  

function save_file_custom_meta($post_id) 
{  
    global $custom_meta_file_fields;  
      
    // verify nonce  
    if (!isset($_POST['custom_box']) || !wp_verify_nonce($_POST['custom_box'], basename(__FILE__)) )   
        return $post_id;  
    // check autosave  
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  
        return $post_id;  
    // check permissions  
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  

    //----------------END OF FILE UPLOAD SAVING  CODE-------------------///
    // loop through fields and save the data  
    foreach ($custom_meta_file_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true);  
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  
            update_post_meta($post_id, $field['id'], $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old);  
        }  
    } // end foreach 
     

    //----------------END OF FILE UPLOAD SAVING  CODE-------------------///
    
}


add_action('save_post', 'save_file_custom_meta'); 