<?php 
// Register Custom Post Type
function servicespost() {
	$labels = array(
		'name'                => _x( 'Services', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'New', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Services', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Services:', 'text_domain' ),
		'all_items'           => __( 'All Services', 'text_domain' ),
		'view_item'           => __( 'View Services', 'text_domain' ),
		'add_new_item'        => __( 'Add Services ', 'text_domain' ),
		'add_new'             => __( 'Add Services ', 'text_domain' ),
		'edit_item'           => __( 'Edit Services', 'text_domain' ),
		'update_item'         => __( 'Update Services', 'text_domain' ),
		'search_items'        => __( 'Search Services', 'text_domain' ),
		'not_found'           => __( 'No Services found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Services found in Trash', 'text_domain' ),
	);

	$args = array(
		'label'               => __( 'Services', 'text_domain' ),
		'description'         => __( 'Services information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'thumbnail', 'cats' ),
		'taxonomies'          => array( 'services_category', 'post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	register_post_type( 'services', $args );
}
add_action('init', 'create_services_taxonomies', 0);
function create_services_taxonomies() {
// Add new taxonomy, make it hierarchical (like categories)
$labels = array(
'name' => _x('Services Category', 'taxonomy general name'),
'singular_name' => _x('Services Category', 'taxonomy singular name'),
'search_items' => 'Search Services Category' ,
'all_items' => 'Services Category',
'parent_item' => 'Parent Services Category' ,
'parent_item_colon' => 'Parent Services Category:' ,
'edit_item' => 'Edit Services Category',
'update_item' => 'Update Services Category',
'add_new_item' => 'Add Services Category',
'new_item_name' => 'New Services Category Name',
'menu_name' => 'Services Category',
);

register_taxonomy('services_category', array('services'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'query_var' => true,
'rewrite' => array('slug' => 'services_category')
));
}
// Hook into the 'init' action
add_action( 'init', 'servicespost', 0 );


function services_add_default_boxes() {
register_taxonomy_for_object_type('services_category', 'demo');
}

//Create page for service
//Add custom field
add_action('add_meta_boxes', 'custom_services_meta_box');

function custom_services_meta_box() {
global $post;
add_meta_box('services_content', 'services details', 'services_content_cb', 'services', 'normal', 'high');
}

function services_content_cb() {
// $post is already set, and contains an object: the WordPress post
global $post;
$values = get_post_custom($post->ID);

$show_services = isset($values['show_services'][0]) ? $values['show_services'][0] : '';
$thumbnail = isset($values['thumbnail'][0]) ? $values['thumbnail'][0] : '';

?>

<p>
	<label for="mailing_address" style="line-height: 20px;"><?php echo 'Show in Home Page:'; ?></label>
	<select name="show_services">
		<option value="No" <?php if($show_services=='No'){ ?>selected="selected" <?php } ?>>No</option>
		<option value="Yes" <?php if($show_services=='Yes'){ ?>selected="selected" <?php } ?>>Yes</option>
		
	</select>
</p>



<?php
}

add_action('save_post', 'custom_meta_services_box_save');

function custom_meta_services_box_save($post_id) {


// Home page
// Make sure your data is set before trying to save it
if (isset($_POST['link']))
	update_post_meta($post_id, 'link', ( $_POST['link']));
if (isset($_POST['show_services']))
	update_post_meta($post_id, 'show_services', ( $_POST['show_services']));

}



add_filter('manage_edit-services_columns', 'custom_services_edit_columns');
add_action('manage_services_posts_custom_column', 'custom_services_columns', 10, 2 );
	
function custom_services_edit_columns( $columns ){
$columns = array(
'cb' => '<input type="checkbox" />',
'title' => __('Name'),
'description' => __('Description'),
'thumbnail' => __('Thumbnail')
);
return $columns;
}

function custom_services_columns( $column, $post_id ){
global $post;

$description = get_post_field('post_content', $post_id);
$show_services = get_post_meta( $post_id, 'show_services', true);
$thumbnail =  get_the_post_thumbnail($post_id,array(120, 120) );

switch ($column){
case 'title':
the_title();
break;


case 'description':
echo substr($description, 0,200);
break;

case 'thumbnail':
echo $thumbnail;
break;

case 'post_date':
the_date();
break;
}
}