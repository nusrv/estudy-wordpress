<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'ESTUDY24_VERSION', '1.0.0' );

function estudy24_setup() {
    load_theme_textdomain( 'estudy24', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 320, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'align-wide' );
    register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'estudy24' ), 'footer' => __( 'Footer Navigation', 'estudy24' ) ) );
}
add_action( 'after_setup_theme', 'estudy24_setup' );

class eStudy24_Nav_Walker extends Walker_Nav_Menu {
    private $item_number = 0;
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $this->item_number++;
        $output .= '<a href="' . esc_url( $item->url ) . '"><i>' . esc_html( str_pad( (string) $this->item_number, 2, '0', STR_PAD_LEFT ) ) . '</i>' . esc_html( $item->title ) . '</a>';
    }
    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

function estudy24_menu_fallback() {
    echo '<nav aria-label="التنقل الرئيسي"><a href="' . esc_url( home_url( '/courses/' ) ) . '"><i>01</i>المقررات</a><a href="' . esc_url( home_url( '/university/' ) ) . '"><i>02</i>الجامعات</a><a href="' . esc_url( home_url( '/instructors/' ) ) . '"><i>03</i>المدرّسون</a></nav>';
}

function estudy24_assets() {
    wp_enqueue_style( 'estudy24-site', get_template_directory_uri() . '/site.css', array(), ESTUDY24_VERSION );
    wp_enqueue_style( 'estudy24-theme', get_stylesheet_uri(), array( 'estudy24-site' ), ESTUDY24_VERSION );
    wp_enqueue_script( 'estudy24-site', get_template_directory_uri() . '/theme.js', array(), ESTUDY24_VERSION, true );
    $width = absint( get_theme_mod( 'estudy24_logo_width', 150 ) );
    wp_add_inline_style( 'estudy24-site', '.brand img{width:' . $width . 'px;max-width:60vw;height:auto}' );
    wp_add_inline_style( 'estudy24-site', 'html,body,#page{margin:0!important;padding:0!important;width:100%}' );
}
add_action( 'wp_enqueue_scripts', 'estudy24_assets' );

function estudy24_register_content() {
    register_post_type( 'course', array(
        'labels' => array( 'name' => __( 'Courses', 'estudy24' ), 'singular_name' => __( 'Course', 'estudy24' ), 'add_new_item' => __( 'Add New Course', 'estudy24' ) ),
        'public' => true, 'show_in_rest' => true, 'has_archive' => false, 'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ), 'rewrite' => array( 'slug' => 'course' ),
    ) );
    register_taxonomy( 'course_university', 'course', array( 'label' => __( 'Universities', 'estudy24' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => true ) );
    register_taxonomy( 'course_instructor', 'course', array( 'label' => __( 'Instructors', 'estudy24' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => false ) );
}
add_action( 'init', 'estudy24_register_content' );

function estudy24_course_meta_box() {
    add_meta_box( 'estudy24_course_details', __( 'Course Details', 'estudy24' ), 'estudy24_course_meta_box_html', 'course', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'estudy24_course_meta_box' );
function estudy24_course_meta_box_html( $post ) {
    wp_nonce_field( 'estudy24_save_course', 'estudy24_course_nonce' );
    $fields = array( 'price' => 'Price', 'old_price' => 'Old price', 'lessons' => 'Lessons', 'level' => 'Level' );
    foreach ( $fields as $key => $label ) {
        printf( '<p><label for="estudy24_%1$s"><strong>%2$s</strong></label><br><input class="widefat" id="estudy24_%1$s" name="estudy24_%1$s" value="%3$s"></p>', esc_attr( $key ), esc_html( $label ), esc_attr( get_post_meta( $post->ID, '_estudy24_' . $key, true ) ) );
    }
}
function estudy24_save_course( $post_id ) {
    if ( ! isset( $_POST['estudy24_course_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['estudy24_course_nonce'] ) ), 'estudy24_save_course' ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) { return; }
    foreach ( array( 'price', 'old_price', 'lessons', 'level' ) as $key ) {
        if ( isset( $_POST[ 'estudy24_' . $key ] ) ) { update_post_meta( $post_id, '_estudy24_' . $key, sanitize_text_field( wp_unslash( $_POST[ 'estudy24_' . $key ] ) ) ); }
    }
}
add_action( 'save_post_course', 'estudy24_save_course' );

function estudy24_customizer( $customizer ) {
    $customizer->add_setting( 'estudy24_logo_width', array( 'default' => 150, 'sanitize_callback' => 'absint' ) );
    $customizer->add_control( 'estudy24_logo_width', array( 'label' => __( 'Logo width (px)', 'estudy24' ), 'section' => 'title_tagline', 'type' => 'number' ) );
    $customizer->add_section( 'estudy24_contact', array( 'title' => __( 'eStudy24 Contact', 'estudy24' ) ) );
    $customizer->add_setting( 'estudy24_telegram', array( 'default' => 'https://t.me/eStudy_24', 'sanitize_callback' => 'esc_url_raw' ) );
    $customizer->add_control( 'estudy24_telegram', array( 'label' => __( 'Telegram URL', 'estudy24' ), 'section' => 'estudy24_contact', 'type' => 'url' ) );
}
add_action( 'customize_register', 'estudy24_customizer' );

function estudy24_content_file( $slug ) {
    $file = get_template_directory() . '/content/' . sanitize_file_name( $slug ) . '.html';
    if ( ! is_readable( $file ) ) { return ''; }
    $html = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
    return str_replace( array( '{{theme}}', '{{home}}' ), array( esc_url( get_template_directory_uri() ), esc_url( untrailingslashit( home_url() ) ) ), $html );
}

function estudy24_seed_theme() {
    estudy24_register_content();
    $pages = array( 'home' => 'الرئيسية', 'courses' => 'الدورات', 'university' => 'الجامعات', 'instructors' => 'المدرّسون', 'login' => 'تسجيل الدخول', 'register' => 'تسجيل طالب', 'student' => 'حساب الطالب', 'teacher' => 'حساب المدرّس', 'admin' => 'الإدارة', 'cart' => 'السلة', 'checkout' => 'الدفع' );
    $ids = array();
    foreach ( $pages as $slug => $title ) {
        $existing = get_page_by_path( $slug );
        $content = estudy24_content_file( $slug === 'home' ? 'index' : $slug );
        $id = $existing ? $existing->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug, 'post_content' => $content ) );
        if ( $id && ! is_wp_error( $id ) ) { $ids[ $slug ] = $id; }
    }
    if ( ! empty( $ids['home'] ) ) { update_option( 'show_on_front', 'page' ); update_option( 'page_on_front', $ids['home'] ); }
    if ( ! empty( $ids['courses'] ) ) { update_post_meta( $ids['courses'], '_wp_page_template', 'template-courses.php' ); }

    if ( ! get_posts( array( 'post_type' => 'course', 'posts_per_page' => 1, 'fields' => 'ids' ) ) ) {
        $courses = array(
            array( 'هياكل متقطعة للامن السيبراني -(القسم الثاني)', 'جامعة ام القرى', 'Ghadeer', '89', 'متوسط', '110.00', '150.00', 'course-discrete.gif' ),
            array( 'اشارات ونظم – القسم الاول', 'جامعة ام القرى', 'Ghadeer', '42', 'متوسط', '120.00', '', 'course-signals.png' ),
            array( 'احصاء (Probability & Statistics STAT 410) – القسم الثاني', 'كلية ينبع الصناعية', 'Ghadeer', '32', 'متوسط', '100.00', '110.00', 'course-statistics.jpg' ),
            array( 'احصاء 311 – القسم الثاني', 'كلية ينبع الصناعية', 'Ghadeer', '58', 'متوسط', '120.00', '', 'course-stat311.jpeg' ),
            array( 'فيزياء كلاسيكية 2 – القسم الاول', 'جامعة الإمام محمد', 'Ghadeer', '51', 'متوسط', '130.00', '', 'course-physics.jpg' ),
            array( 'احصاء 211 – القسم الثاني', 'كلية ينبع الصناعية', 'Ghadeer', '30', 'متوسط', '100.00', '125.00', 'course-stat211.jpg' ),
        );
        foreach ( $courses as $course ) {
            $course_id = wp_insert_post( array( 'post_type' => 'course', 'post_status' => 'publish', 'post_title' => $course[0], 'post_content' => '<p>يتضمن هذا المقرر شرحاً منظماً ودروساً مسجلة مع دعم مستمر طوال الفصل الدراسي.</p>' ) );
            if ( $course_id && ! is_wp_error( $course_id ) ) {
                wp_set_object_terms( $course_id, $course[1], 'course_university' );
                wp_set_object_terms( $course_id, $course[2], 'course_instructor' );
                foreach ( array( 'lessons' => $course[3], 'level' => $course[4], 'price' => $course[5], 'old_price' => $course[6], 'image' => $course[7] ) as $key => $value ) { update_post_meta( $course_id, '_estudy24_' . $key, $value ); }
            }
        }
    }

    $menu_name = 'eStudy24 Primary';
    $menu = wp_get_nav_menu_object( $menu_name );
    $menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
    if ( ! is_wp_error( $menu_id ) && ! wp_get_nav_menu_items( $menu_id ) ) {
        foreach ( array( 'courses' => 'المقررات', 'university' => 'الجامعات', 'instructors' => 'المدرّسون' ) as $slug => $label ) {
            if ( ! empty( $ids[ $slug ] ) ) { wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => $label, 'menu-item-object' => 'page', 'menu-item-object-id' => $ids[ $slug ], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) ); }
        }
        set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu_id ) );
    }
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'estudy24_seed_theme' );

function estudy24_body_classes( $classes ) { $classes[] = 'estudy24-wordpress'; return $classes; }
add_filter( 'body_class', 'estudy24_body_classes' );

function estudy24_course_image_url( $post_id ) {
    if ( has_post_thumbnail( $post_id ) ) { return get_the_post_thumbnail_url( $post_id, 'medium' ); }
    $file = get_post_meta( $post_id, '_estudy24_image', true );
    return $file ? get_template_directory_uri() . '/assets/' . rawurlencode( $file ) : get_template_directory_uri() . '/assets/course-signals.png';
}

