<?php 
/**
 * Template Name: Blog Right Sidebar
 */
get_header();  
innofit_breadcrumbs();
?>
<!-- Blog & Sidebar Section -->
<section class="site-content">
	<div class="container">
		
		<div class="row">	
			<!--Blog Posts-->
			<div class="col-md-<?php echo ( !is_active_sidebar( 'sidebar_primary' ) ? '12' :'8' ); ?> col-sm-12 col-xs-12">
			<div class="blog">
			<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array( 'post_type' => 'post','paged'=>$paged);
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) :
					// Start the Loop.
					while ( $loop->have_posts() ) : $loop->the_post();
						// Include the post format-specific template for the content.
						get_template_part( 'content','');
					endwhile;
					
					// pagination function
					$obj = new innofit_pagination();
					$obj->innofit_page($loop);
				 
				endif;
				?>
			</div>
			</div>
			<!--/Blog Posts-->
			<!--Sidebar-->
			<?php  get_sidebar(); ?>
			<!--/Sidebar-->
		</div>			
	</div>
</section>
<!--/End of Blog & Sidebar Section-->
<?php get_footer(); ?>