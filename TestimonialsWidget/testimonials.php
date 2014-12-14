<?php // Template Name: Testimonials ?>
<?php $curly->header(); ?>
<?php $curly->slider(); ?>

<article <?php post_class(); ?>>
	<div class="container page-content">
		<div class="row">
		
			<div class="col-lg-12">
			<?php  $query = new WP_Query( array('post_type' => 'Testimonials', 'posts_per_page' =>0 ) ); ?>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="testimonials">
<?php 
if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    }
?>				
<?php the_content() ?>	
				<div class="author">
				-- <?php the_title() ?>
				</div>
				</div>
				<?php wp_reset_postdata(); ?>
				<?php endwhile; ?>	
								
				<!-- Sharing -->
				<?php get_template_part( 'template-parts/sharing' ); ?>
				
				<!-- Comments -->
				<?php get_template_part( 'template-parts/comments' ); ?>		
			</div
			
		</div>
	</div>
</article>

<?php $curly->footer(); ?>
