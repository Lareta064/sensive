<?php		
	global $post;

	$query = new WP_Query( [
		'posts_per_page' =>  4,
		'post_type'        => 'social',
		'order'           =>'ASC'
	] );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
		$query->the_post();
		?>
			<li><a href="<?php the_field('soc_link'); ?>"><?php the_field('soc_icon'); ?></a></li>
		<?php 
		}
	}
	wp_reset_postdata(); // Сбрасываем $post
?>