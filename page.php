<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	//  Call Header
	get_header(); ?>
	<section class="page_section section_padding">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 page_content">
					<?php
					if( have_posts() ){
						while( have_posts() ){
							the_post();
							the_content();

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'medico' ),
									'after'  => '</div>',
								)
							);
						}
					} ?>
				</div>
			</div>
		</div>
	</section>
	<?php 	
	 // Call Footer
	 get_footer();
