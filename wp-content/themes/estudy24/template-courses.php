<?php
/* Template Name: Course Catalog */
get_header();
$universities = get_terms( array( 'taxonomy' => 'course_university', 'hide_empty' => true ) );
$instructors = get_terms( array( 'taxonomy' => 'course_instructor', 'hide_empty' => true ) );
$selected_university = isset( $_GET['university'] ) ? sanitize_title( wp_unslash( $_GET['university'] ) ) : '';
$selected_instructor = isset( $_GET['instructor'] ) ? sanitize_title( wp_unslash( $_GET['instructor'] ) ) : '';
$search = isset( $_GET['course_search'] ) ? sanitize_text_field( wp_unslash( $_GET['course_search'] ) ) : '';
$tax_query = array();
if ( $selected_university ) { $tax_query[] = array( 'taxonomy' => 'course_university', 'field' => 'slug', 'terms' => $selected_university ); }
if ( $selected_instructor ) { $tax_query[] = array( 'taxonomy' => 'course_instructor', 'field' => 'slug', 'terms' => $selected_instructor ); }
$query = new WP_Query( array( 'post_type' => 'course', 'posts_per_page' => 12, 'paged' => max( 1, get_query_var( 'paged' ) ), 's' => $search, 'tax_query' => $tax_query ) ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
?>
<section class="intro"><div class="wrap"><span class="idx"><b>01</b><i>CATALOG MAP</i></span><div><p>اكتشف المقرر المناسب لجامعتك</p><h1><?php the_title(); ?></h1></div></div></section>
<main class="wrap catalog">
<aside><form method="get"><input name="course_search" value="<?php echo esc_attr( $search ); ?>" placeholder="ابحث في المقررات">
<fieldset><legend>01 / الجامعة</legend><label><input type="radio" name="university" value="" <?php checked( $selected_university, '' ); ?>> جميع الجامعات</label><?php foreach ( $universities as $term ) : ?><label><input type="radio" name="university" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( $selected_university, $term->slug ); ?>> <?php echo esc_html( $term->name ); ?></label><?php endforeach; ?></fieldset>
<fieldset><legend>02 / المدرّس</legend><label><input type="radio" name="instructor" value="" <?php checked( $selected_instructor, '' ); ?>> جميع المدرّسين</label><?php foreach ( $instructors as $term ) : ?><label><input type="radio" name="instructor" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( $selected_instructor, $term->slug ); ?>> <?php echo esc_html( $term->name ); ?></label><?php endforeach; ?></fieldset>
<button class="primary" type="submit">تطبيق الفلاتر</button></form></aside>
<section><header class="catalogHead"><small><?php echo esc_html( $query->found_posts ); ?> RESULT</small><h2>وجدنا <?php echo esc_html( $query->found_posts ); ?> دورة متاحة لك</h2></header><div class="rows">
<?php $index = 0; while ( $query->have_posts() ) : $query->the_post(); $index++; $universities_for_course = get_the_terms( get_the_ID(), 'course_university' ); $instructors_for_course = get_the_terms( get_the_ID(), 'course_instructor' ); ?>
<article class="crow <?php echo 1 === $index ? '' : 'small'; ?>"><b><?php echo esc_html( str_pad( (string) $index, 2, '0', STR_PAD_LEFT ) ); ?></b><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( estudy24_course_image_url( get_the_ID() ) ); ?>" alt="<?php the_title_attribute(); ?>"></a><div><small><?php echo esc_html( $universities_for_course && ! is_wp_error( $universities_for_course ) ? $universities_for_course[0]->name : '' ); ?></small><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( $instructors_for_course && ! is_wp_error( $instructors_for_course ) ? $instructors_for_course[0]->name : '' ); ?> · <?php echo esc_html( get_post_meta( get_the_ID(), '_estudy24_lessons', true ) ); ?> درس · <?php echo esc_html( get_post_meta( get_the_ID(), '_estudy24_level', true ) ); ?></p></div><span class="price"><b><?php echo esc_html( get_post_meta( get_the_ID(), '_estudy24_price', true ) ); ?> ر.س</b><?php if ( get_post_meta( get_the_ID(), '_estudy24_old_price', true ) ) : ?><del><?php echo esc_html( get_post_meta( get_the_ID(), '_estudy24_old_price', true ) ); ?> ر.س</del><?php endif; ?></span><a href="<?php the_permalink(); ?>">←</a></article>
<?php endwhile; wp_reset_postdata(); ?>
</div><?php echo wp_kses_post( paginate_links( array( 'total' => $query->max_num_pages, 'type' => 'list' ) ) ); ?></section></main>
<?php get_footer(); ?>
