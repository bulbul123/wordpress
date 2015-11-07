<?php
/*
Plugin Name: Ajax post from front
Plugin URI: 
Description:Allows to post from front end
Author: Abbas Suterwala
Version: 
Author URI: http://code.tutsplus.com/tutorials/adding-posts-to-a-sites-front-end-using-ajax--wp-25652
*/
define('APFSURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('APFPATH', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );


function apf_enqueuescripts()
{
    wp_enqueue_script('apf', APFSURL.'/js/apf.js', array('jquery'));
    wp_localize_script( 'apf', 'apfajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', apf_enqueuescripts);


function apf_post_form()
{
?> 
    <form id="apfform" action="" method="post"enctype="multipart/form-data">
 
        <div id="apf-text">
 
            <div id="apf-response" style="background-color:#E6E6FA"></div>
 
            <strong>Title </strong> <br/>
            <input type="text" id="apftitle" name="apftitle"/><br />
            <br/>
 
            <strong>Contents </strong> <br/>
            <textarea id="apfcontents" name="apfcontents"  rows="10" cols="20"></textarea><br />
            <br/>
 
            <a onclick="apfaddpost(apftitle.value,apfcontents.value);" style="cursor: pointer"><b>Create Post</b></a>
 
        </div>
    </form>
 
    <?php
}

//end part one top up all



//start part three
function apf_addpost() {
    $results = '';
 
    $title = $_POST['apftitle'];
    $content =  $_POST['apfcontents'];
 
    $post_id = wp_insert_post( array(
        'post_title'        => $title,
        'post_content'      => $content,
        'post_status'       => 'publish',
        'post_author'       => '1'
    ) );
 
    if ( $post_id != 0 )
    {
        $results = '*Post Added';
    }
    else {
        $results = '*Error occurred while adding the post';
    }
    // Return the String
    die($results);
}

// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_apf_addpost', 'apf_addpost' );
add_action( 'wp_ajax_apf_addpost', 'apf_addpost' );
//end part three







//start part two
//start widget area 
class AjaxPostFromFrontWidget extends WP_Widget {
    function AjaxPostFromFrontWidget() {
        // widget actual processes
        $widget_ops = array('classname' => 'AjaxPostFromFrontWidget', 'description' => 'Lets you create post from front end' );
        $this->WP_Widget('AjaxPostFromFrontWidget','AjaxPostFromFrontWidget', $widget_ops);
    }
 
    function form($instance) {
        // outputs the options form on admin
        $defaults = array( 'title' => 'Ajax Post From Front' );
        $instance = wp_parse_args( (array) $instance, $defaults );
 
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
        </p>
        <?php
    }
 
    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
 
        return $instance;
    }
     
    function widget($args, $instance) {
        // outputs the content of the widget
        extract( $args );
 
        $title = apply_filters('widget_title', $instance['title'] );
        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        echo '<ul>';
        echo apf_post_form();
        echo '</ul>';
        echo $after_widget;
    }
}

function apf_widget_init() {
    // Check for the required API functions
    if ( !function_exists('register_widget') )
        return;
 
    register_widget('AjaxPostFromFrontWidget');
}
add_action('widgets_init', 'apf_widget_init');

//end widget area
//end part two