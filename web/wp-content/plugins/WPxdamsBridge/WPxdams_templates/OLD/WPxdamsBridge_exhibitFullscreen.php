
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
	</head>
        <body <?php body_class(); ?>>



            <div class="content">
	
		
		<?php //if(have_posts()): the_post(); ?>
			
				
                <?php      the_content(); ?>
			
                            <div class="clear"></div>
		
                <?php //endif;?>
		
		<?php // get_sidebar(); ?>
		<div class="clear"></div>
	
            </div>
<?php  // get_footer(); ?>

