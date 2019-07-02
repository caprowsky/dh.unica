<?php

/**
 * Categories: List Layout.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */

$list_categories = wp_list_categories( array(            
    'child_of'         => (int) $attributes['id'],
    'echo'             => 0,
    'hierarchical'     => (int) $attributes['hierarchical'],
    'hide_empty'       => (int) $attributes['hide_empty'], 
    'orderby'          => sanitize_text_field( $attributes['orderby'] ),
    'order'            => sanitize_text_field( $attributes['order'] ),            
    'show_count'       => (int) $attributes['show_count'],
    'show_option_none' => '',
    'taxonomy'         => 'aiovg_categories',
    'title_li'         => ''
) ); 

if ( empty( $list_categories ) ) {
    $empty_message = aiovg_get_message( 'empty' );
    echo esc_html( $empty_message );
    return;
}
?>

<div class="aiovg aiovg-categories aiovg-categories-list">
	<ul>
		<?php echo $list_categories; ?>
    </ul>
</div>