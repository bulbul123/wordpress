<?php
/*
https://www.youtube.com/watch?v=RyvKe3ouK5g
*my custom meta box
*/
function cd_meta_box_add()
{

$multiple_posts=array('post','page');

foreach ($multiple_posts as $multiple_post) {

add_meta_box( 
	'my_meta_box_id', 
	__('Product', 'textdomain'),
	'cd_meta_box_cb', 
	$multiple_post, 
	'normal'
	 ); 
// add_meta_box( 
//     	'my_meta_box_id_price', 
//     	__('Price', 'textdomain'),
//     	'product_price_meta_box', 
//     	$multiple_post, 
//     	'normal'
//     	 );   


}
}
add_action( 'add_meta_boxes', 'cd_meta_box_add' );

function cd_meta_box_cb($post) // post object $post
{
	$product_name=get_post_meta($post->ID,'product_name',true);
	$discription=get_post_meta($post->ID,'discription',true);

	wp_nonce_field('product_nonce_action','product_nonce_name');
	?>
	<p>
	<label for="product_name">Product Name</label>
	<input type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>">
</p>
<p>
	<label for="discription">Product Description</label>
<textarea id="discription" class="widefat" name="discription"><?php echo $discription; ?></textarea>
</p>
	<?php
}
/*
function product_price_meta_box($posts) // post object $posts
{

	wp_nonce_field('product_price_nonce_action','product_price_nonce_name');
	?>
	<p>
	<label for="product_type">Product Type</label>
	<input type="text" id="product_type" name="product_type">
</p>
<p>
	<label for="product_price">Product Price</label>
	<input type="text" id="product_price" name="product_price">
</p>
	<?php
}
*/

//save data into database
function save_product_data($post_id)
{
	
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if(isset($_POST['product_nonce_name']) || !wp_verify_nonce($_POST['product_nonce_name'],'product_nonce_action'))
		return;


		update_post_meta($post_id,'product_name', esc_html($_POST['product_name']));
	
}
add_action('save_post','save_product_data');










// For All Widgets
require get_template_directory() . '/page_templates/all-widgets.php'; 

 
 //add theme option-framework
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

function create_services_review() {

    require get_template_directory() . '/page_templates/our-service.php';
    
    require get_template_directory() . '/page_templates/testimonial.php';

    require get_template_directory() . '/page_templates/welcome.php';

    require get_template_directory() . '/page_templates/our-standards.php';

    require get_template_directory() . '/page_templates/our-solutions.php';
}
add_action( 'init', 'create_services_review' );

// For navigation menu
require get_template_directory() . '/page_templates/navigation-menu.php';

wp_enqueue_style('font-awesome', get_template_directory_uri().'/cssmenu/styles.css');
wp_enqueue_style( 'bootstrap-styles', get_template_directory_uri() . '/cssmenu/font-awesome.min.css');



//Display Post Next/Prev buttons if enabled.
if ( ! function_exists( 'centilium_next_prev_post' ) ) {
function centilium_next_prev_post() { ?>
	<div class="next_prev_post">
		<?php 
			previous_post_link( '<div class="nav-previous"> %link</div>', '<i class="fa fa-chevron-left"></i>'. __('Previous Post','centilium'));
			next_post_link( '<div class="nav-next">%link</div>', __('Next Post','centilium'). '<i class="fa fa-chevron-right"></i>' );
		?>
	</div><!-- .next_prev_post -->
<?php }                 
}




add_theme_support( 'post-thumbnails' );
