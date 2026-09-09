<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/favicon.svg' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="top"><span class="sr-only"><?php esc_html_e( 'Explore lessons', 'estudy24' ); ?></span><div class="wrap topin">
<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo_id = get_theme_mod( 'custom_logo' ); if ( $logo_id ) { echo wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) ); } else { ?><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php } ?><span><b>منصة التعليم الجامعي</b><small>تعلم بوضوح، أينما كنت</small></span></a>
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_aria_label' => 'التنقل الرئيسي', 'fallback_cb' => 'estudy24_menu_fallback', 'items_wrap' => '%3$s', 'walker' => new eStudy24_Nav_Walker() ) ); ?>
<div class="headActions"><a class="searchLink" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="البحث">⌕ <span>بحث</span></a><a class="bagLink" href="<?php echo esc_url( home_url( '/cart/' ) ); ?>">السلة <b>00</b></a><a class="accountLink" href="<?php echo esc_url( home_url( '/login/' ) ); ?>">دخول</a><button class="menu" aria-expanded="false" aria-label="فتح القائمة">القائمة</button></div>
</div></header>
