<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php if ( trim( get_the_content() ) ) { the_content(); } else { echo wp_kses_post( estudy24_content_file( get_post_field( 'post_name', get_the_ID() ) ) ); } ?>
<?php endwhile; ?>
<?php get_footer(); ?>
