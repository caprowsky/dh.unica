/**
 * Post Gallery Init Script.
 * Used to initialize gallery's lightbox.
 *
 * COPY THIS FILE IN YOUR THEME FOR CUSTOMIZATIONS. LOCATION:
 * [theme-folder]/views/plugins/post-gallery/gallery-script.php
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.2
 */
(function($) { $(document).ready(function() {
    /**
     * Init swipebox.
     * @since 2.1.2
     * @see http://brutaldesign.github.io/swipebox/
     */
    $( '.swipebox' ).swipebox();
}) })(jQuery);