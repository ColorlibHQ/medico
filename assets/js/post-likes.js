/**
 * Like buttons (.sl-button): records the like over admin-ajax and updates every
 * button for the same post or comment. No jQuery.
 */
(function () {
  'use strict';

  var UI = window.ColorlibUI;
  var likes = window.simpleLikes;
  if (!UI || !likes) return;

  document.addEventListener('click', function (e) {
    var button = e.target.closest && e.target.closest('.sl-button');
    if (!button) return;
    e.preventDefault();

    var postId = button.getAttribute('data-post-id');
    if (!postId) return;
    var isComment = button.getAttribute('data-iscomment');
    // Comments can share an id with a post, so they have their own class.
    var all = UI.toElements((isComment === '1' ? '.sl-comment-button-' : '.sl-button-') + postId);
    var loaders = all.map(function (b) {
      var next = b.nextElementSibling;
      return next && next.id === 'sl-loader' ? next : null;
    }).filter(Boolean);
    loaders.forEach(function (l) { l.innerHTML = '&nbsp;<div class="loader">Loading...</div>'; });

    UI.request(likes.ajaxurl, {
      data: {
        action: 'medico_process_simple_like',
        post_id: postId,
        nonce: button.getAttribute('data-nonce'),
        is_comment: isComment
      }
    }).then(function (response) {
      var liked = response.status !== 'unliked';
      all.forEach(function (b) {
        b.innerHTML = response.count;
        // Only the texts the theme passes; otherwise the title stays as it was.
        var title = liked ? likes.unlike : likes.like;
        if (title) b.title = title;
        b.classList.toggle('liked', liked);
      });
        // The heart beside the clicked button: solid when liked, outline when not.
        var icon = button.previousElementSibling;
        if (icon && icon.classList.contains('fa-heart')) {
          icon.classList.toggle('fa-solid', liked);
          icon.classList.toggle('fa-regular', !liked);
        }
      loaders.forEach(function (l) { l.innerHTML = ''; });
    });
  });
}());
