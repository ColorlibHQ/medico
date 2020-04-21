(function( $ ) {
	'use strict';
	$(document).on('click', '.sl-button', function() {
		var button = $(this);
		var post_id = button.attr('data-post-id');
		var medico = button.attr('data-nonce');
		var iscomment = button.attr('data-iscomment');
		var allbuttons;
		if ( iscomment === '1' ) { /* Comments can have same id */
			allbuttons = $('.sl-comment-button-'+post_id);
		} else {
			allbuttons = $('.sl-button-'+post_id);
		}
		var loader = allbuttons.next('#sl-loader');
		if (post_id !== '') {
			$.ajax({
				type: 'POST',
				url: simpleLikes.ajaxurl,
				data : {
					action : 'medico_process_simple_like',
					post_id : post_id,
					nonce : medico,
					is_comment : iscomment,
				},
				beforeSend:function(){
					loader.html('&nbsp;<div class="loader">Loading...</div>');
				},	
				success: function(response){
					var icon = response.icon;
					var customIcon = button.prev();
					var count = response.count;
					allbuttons.html(count);
					if(response.status === 'unliked') {
						var like_text = simpleLikes.like;
						allbuttons.prop('title', like_text);
						allbuttons.removeClass('liked');
						if( customIcon.hasClass( 'fa-heart' )){
							customIcon.removeClass('fa-heart');
						}
						customIcon.addClass('fa-heart-o');
					} else {
						var unlike_text = simpleLikes.unlike;
						allbuttons.prop('title', unlike_text);
						allbuttons.addClass('liked');
						if( customIcon.hasClass( 'fa-heart-o' )){
							customIcon.removeClass('fa-heart-o');
						}
						customIcon.addClass('fa-heart');
					}
					loader.empty();					
				}
			});
			
		}
		return false;
	});
})( jQuery );
