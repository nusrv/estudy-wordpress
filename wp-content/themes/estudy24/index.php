<?php get_header(); ?>
<main class="wrap block"><header class="sect"><h1><?php echo is_home() ? esc_html__( 'Latest posts', 'estudy24' ) : esc_html( get_the_archive_title() ); ?></h1></header><div class="rows">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><article class="crow"><div><small><?php echo esc_html( get_the_date() ); ?></small><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></div><a href="<?php the_permalink(); ?>">←</a></article><?php endwhile; the_posts_pagination(); else : ?><p><?php esc_html_e( 'No content found.', 'estudy24' ); ?></p><?php endif; ?>
</div></main><?php get_footer(); ?>
