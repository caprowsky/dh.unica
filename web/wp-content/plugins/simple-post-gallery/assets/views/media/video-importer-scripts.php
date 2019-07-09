<?php
/**
 * Video Importer styles.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.0
 */ 
?>
<script type="text/javascript">
(function($) { $(document).ready(function() {

    /**
     * Bind to input URL changes.
     * @since 2.1.0
     */
    $(':input.url').change(function() {
        $('.loader').show();
        $('.error').hide();
        $('.preview').hide();
        $('.actions').hide();
        $.post(
            $('form#video-importer').attr('action'), // url
            $('form#video-importer').serialize()+'&action=video_importer_validate', // data
            function(response) {
                $('.loader').hide();
                if (response.error === undefined) {
                    showError('Invalid response. Check your wordpress setup.');
                } else if (response.error === true) {
                    showError(response.message, response.errors);
                } else {
                    $('.actions').show();
                    $('.preview').show();
                    $('.preview').html(response.data.preview);
                }
            }
        );
    });

    /**
     * Bind to form submit button.
     * @since 2.1.0
     */
    $('button.import').click(function(e) {
        e.preventDefault();
        $('.loader').show();
        $('.error').hide();
        $.post(
            $('form#video-importer').attr('action'), // url
            $('form#video-importer').serialize()+'&action=video_importer_import', // data
            function(response) {
                $('.loader').hide();
                if (response.error === undefined) {
                    showError('Invalid response. Check your wordpress setup.');
                } else if (response.error === true) {
                    showError(response.message, response.errors);
                } else {
                    parent.send_to_editor(response.data.preview, parent.wp.media.editor.activeEditor);
                    parent.wp.media.frame.close();
                }
            }
        );
    });

    /**
     * Displays errors.
     * @since 2.1.0
     *
     * @param {string} message Error message.
     * @param {array}  errors  Errors.
     */
    showError = function(message, errors)
    {
        $('.error').show();
        $('.error').html(message);
    }

    <?php do_action( 'post_gallery_video_importer_scripts' ) ?>
});})(jQuery);
</script>