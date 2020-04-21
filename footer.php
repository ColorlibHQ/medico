<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package
 */

    $url = 'https://colorlib.com/';
    $copyText = sprintf( __( 'Theme by %s colorlib %s Copyright &copy; %s  |  All rights reserved.', 'medico' ), '<a target="_blank" href="' . esc_url( $url ) . '">', '</a>', date( 'Y' ) );
    $copyRight = !empty( medico_opt( 'medico_footer_copyright_text' ) ) ? medico_opt( 'medico_footer_copyright_text' ) : $copyText;
    $footer_class = medico_opt( 'medico_footer_widget_toggle' ) == 1 ? 'footer-area' : 'no_widget';

    ?>

    <!-- footer part start-->
    
    <footer class="footer-area">
        <?php
            if( medico_opt( 'medico_footer_widget_toggle' ) == 1 ) {
        ?>
        <div class="container">
            <div class="row justify-content-between">
                <?php
                    // Footer Widget 1
                    if ( is_active_sidebar( 'footer-1' ) ) {
                        echo '<div class="col-xl-2 col-md-4 col-sm-6">';
                            dynamic_sidebar( 'footer-1' );
                        echo '</div>';
                    }

                    // Footer Widget 2
                    if ( is_active_sidebar( 'footer-2' ) ) {
                        dynamic_sidebar( 'footer-2' );
                    }

                    // Footer Widget 3
                    if ( is_active_sidebar( 'footer-3' ) ) {
                        dynamic_sidebar( 'footer-3' );
                    }

                    // Footer Widget 4
                    if ( is_active_sidebar( 'footer-4' ) ) {
                        dynamic_sidebar( 'footer-4' );
                    }

                    // Footer Widget 5
                    if ( is_active_sidebar( 'footer-5' ) ) {
                        dynamic_sidebar( 'footer-5' );
                    }
                ?>
            </div>
        </div>
        <?php
            } 
        ?>

        <div class="copyright_part">
            <div class="container">
                <div class="row align-items-center">
                    <p class="footer-text m-0 col-lg-8 col-md-12"><?php echo wp_kses_post( $copyRight ); ?></p>

                    <?php
                        $social_profile = medico_opt( 'medico_social_profile_toggle' );
                        $social_icons = medico_opt( 'medico_footer_social' );
                        if( $social_profile == 1 && 0 < count($social_icons) ) {
                    ?> 
                    <div class="col-lg-4 col-md-12 text-center text-lg-right footer-social">
                        <?php
                            for ( $i = 0; $i < count($social_icons); $i++ ) {
                                $social_icon = $social_icons[$i]['social_icon'];
                                ?>
                                <a href="<?php echo esc_url($social_icons[$i]['social_url']);?>"><i class="<?php echo esc_html( $social_icon );?>"></i></a>
                            <?php
                            }
                        ?>
                    </div>
                    <?php } ?>     
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
    </body>
</html>