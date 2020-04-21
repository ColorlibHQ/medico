<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <!-- For Resposive Device -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php 
            echo medico_site_icon();
            wp_head(); 
            if ( is_front_page() ) {
                $dynamic_class = 'main_menu home_menu';
            } else {
                $dynamic_class = 'main_menu';
            }
        ?>
    </head>
    <body <?php body_class(); ?>>

    <!--::header part start::-->
    <header class="<?php echo $dynamic_class?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <?php
                            echo medico_theme_logo( 'navbar-brand' );
                        ?>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <?php
                            if(has_nav_menu('primary-menu')) {
                                wp_nav_menu(array(
                                    'menu'           => 'primary-menu',
                                    'theme_location' => 'primary-menu',
                                    'menu_id'        => 'menu-main-menu',
                                    'container_class'=> 'collapse navbar-collapse main-menu-item justify-content-center',
                                    'container_id'   => 'navbarSupportedContent',
                                    'menu_class'     => 'navbar-nav align-items-center',
                                    'walker'         => new medico_bootstrap_navwalker,
                                    'depth'          => 3
                                ));
                            }
                        
                            if( medico_opt( 'medico_header_right_button' ) == 1 ){
                                $btn_lbl = !empty( medico_opt( 'medico_header_right_button_lbl' ) ) ? medico_opt( 'medico_header_right_button_lbl' ) : '';
                                $btn_url = !empty( medico_opt( 'medico_header_right_button_url' ) ) ? medico_opt( 'medico_header_right_button_url' ) : '';
                            ?>
                                <div class="cta-btn-head">
                                    <a class="d-none d-lg-block btn_2" href="<?php echo esc_url( $btn_url )?>"><?php echo esc_html( $btn_lbl )?></a>
                                </div>
                            <?php } ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->

    <?php
    //Page Title Bar
    if( function_exists( 'medico_page_titlebar' ) ){
	    medico_page_titlebar();
    }

