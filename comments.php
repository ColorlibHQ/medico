<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package medico
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>

    <?php if ( have_comments() ) : ?>
        <div class="comments-area">
            <h4 class="comment-head"><?php comments_number( ' ', '1 Comment', '% Comments' ); ?></h4>
            <?php
            wp_list_comments(
                array(
                    'style'      => 'div',
                    'short_ping' => true,
                    'avatar_size' => 70,
                    'type' => 'all',
                    'callback'	 => 'medico_comment_callback',
                )
            );
            the_comments_pagination(); ?>
    </div>
    
    <?php endif; ?>

    <?php
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'medico' ); ?></p>
        <?php
	endif;
    ?>

<div class="comment-form">
    <?php if( comments_open() ){ ?>
        <h4><?php esc_html_e('Leave a reply', 'medico') ?></h4>
    <?php } ?>

    <?php
    $commenter      = wp_get_current_commenter();
    $req            = get_option( 'require_name_email' );
    $aria_req       = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<div class="col-sm-6"><div class="form-group"><input type="text" class="form-control" name="author" id="author" value="'.esc_attr($commenter['comment_author']).'" placeholder="'.esc_attr__('Enter Name', 'medico').'" '.$aria_req.' ></div></div>',
        'email'	 => '<div class="col-sm-6"><div class="form-group"><input type="email" class="form-control" name="email" id="email" value="'.esc_attr($commenter['comment_author_email']).'" placeholder="'.esc_attr__('Enter email address', 'medico').'" '.$aria_req.'></div></div>',
        'url'	 => '<div class="col-12"><div class="form-group"><input class="form-control" name="url" id="url" type="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. esc_html__( 'Website', 'medico' ) .'"></div></div>'
    );
    $comments_args = array(
        'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
        'class_form'            => 'form-contact comment_form',
        'id_form'               => 'commentForm',
        'submit_button'         => '</div><div class="form-group"><button type="submit" class="button button-contactForm btn_4 mt-3">'.esc_html__('Post Comment', 'medico').'</button></div>',
        'id_submit'             => 'submit-btn',
        'title_reply'           => '',
        'comment_notes_before'  => '',
        'comment_field'         => '<div class="row"><div class="col-12"><div class="form-group"><textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="'. esc_html__( 'Write Comment', 'medico' ) .'"></textarea></div></div>',
        'comment_notes_after'   => '',
    );
    comment_form($comments_args);
    ?>
</div>