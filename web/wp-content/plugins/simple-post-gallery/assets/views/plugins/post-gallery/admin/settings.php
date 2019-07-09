<?php
/**
 * Settings view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.0
 */ 
?>
<?php use PostGallery\Controllers\AdminController as Software ?>
<div class="wrap">

    <h2><?php _e( 'Post Gallery Settings', 'simple-post-gallery' ) ?></h2>

    <?php if ( $notice ) : ?>
        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
            <p><strong><?php echo $notice ?></strong></p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'simple-post-gallery' ) ?></span>
            </button>
        </div>
    <?php endif ?>

    <?php if ( $error ) : ?>
        <div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"> 
            <p><strong><?php echo $error ?></strong></p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'simple-post-gallery' ) ?></span>
            </button>
        </div>
    <?php endif ?>

    <form method="POST">

        <h3 class="nav-tab-wrapper">
            <?php foreach ( $tabs as $key => $name ) : ?>
                <a class="nav-tab <?php if ( $tab == $key ) :?>nav-tab-active<?php endif ?>"
                    href="<?php echo admin_url( 'options-general.php?page=' . Software::ADMIN_MENU_SETTINGS . '&tab=' . $key ) ?>"
                >
                    <?php echo $name ?>
                </a>
            <?php endforeach ?>
        </h3>

        <?php $view->show( 'plugins.post-gallery.admin.settings-general', [
            'tab'           => $tab,
            'postGallery'   => $postGallery,
            'types'         => $types,
        ] ) ?>

        <?php $view->show( 'plugins.post-gallery.admin.settings-cache', [
            'tab'           => $tab,
            'postGallery'   => $postGallery,
        ] ) ?>

        <?php do_action( 'postgallery_settings_view', $tab, $postGallery ) ?>

        <?php if ( $tab != 'docs' && $tab != 'cache' ) : ?>

            <?php submit_button() ?>

        <?php endif ?>

    </form>

    <?php $view->show( 'plugins.post-gallery.admin.settings-doc', [ 'tab' => $tab, 'view' => $view ] ) ?>

</div>