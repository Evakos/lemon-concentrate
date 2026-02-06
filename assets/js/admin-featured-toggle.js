jQuery(document).ready(function($) {
    $('.lemon-toggle-featured').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $icon = $this.find('.dashicons');
        var post_id = $this.data('id');
        var nonce = $this.data('nonce');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'lemon_toggle_featured',
                post_id: post_id,
                nonce: nonce
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.status === '1') {
                        $icon.removeClass('dashicons-star-empty').addClass('dashicons-star-filled').css('color', '#f0ad4e');
                    } else {
                        $icon.removeClass('dashicons-star-filled').addClass('dashicons-star-empty').css('color', '#ccc');
                    }
                } else {
                    alert('Error: ' + response.data);
                }
            }
        });
    });
});