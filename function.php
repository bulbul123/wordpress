<?php

//past function name where you want to show 
//centilium_next_prev_post();
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



/*
* Print Powered by WordPress
*/
if (!function_exists ('centilium_copyright')){
	function centilium_copyright(){
	?>
	<div class="copyright">
		<p><a href="<?php echo esc_url( 'https://wordpress.org/' ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'centilium' ), 'WordPress' ); ?></a></p>
	</div>
	<?php
	}
}
