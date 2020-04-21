<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
}
/**
 * @Packge     : Medico
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */



$sidebar1 = is_active_sidebar( 'footer-1' );
$sidebar2 = is_active_sidebar( 'footer-2' );
$sidebar3 = is_active_sidebar( 'footer-3' );

// Check sidebar active
if( $sidebar1 || $sidebar2 || $sidebar3 ):
?>

<div class="container">
    <div class="row justify-content-between">
        <?php
            // Footer Widget 1
            if ( is_active_sidebar( 'footer-1' ) ) {
                dynamic_sidebar( 'footer-1' );
            }

            // Footer Widget 2
            if ( is_active_sidebar( 'footer-2' ) ) {
                echo '<div class="col-sm-6 col-md-6 col-xl-4">';
                    dynamic_sidebar( 'footer-2' );
                echo '</div>';
            }

            // Footer Widget 3
            if ( is_active_sidebar( 'footer-3' ) ) {
                dynamic_sidebar( 'footer-3' );
            }
        ?>
    </div>
</div>

<?php 
endif;
?>