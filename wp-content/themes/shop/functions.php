<?php
function my_custom_wc_theme_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'my_custom_wc_theme_support');

function initTheme()
{
    add_filter('use_block_editor_for_post', '__return_false');
    register_nav_menu('header-main', __('Menu chính'));
    register_nav_menu('footer-menu', __('Menu footer'));
    register_sidebar([
        'name' => 'First sidebar',
        'id' => 'first_sidebar',
        'before_widget'  => '<li id="%1$s" class="widget %2$s">',
        'after_widget'   => "</li>\n",
        'before_title'   => '<h2 class="widgettitle">',
        'after_title'    => "</h2>\n",
    ]);
}

add_action('init', 'initTheme');

function setpostview($postID)
{
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getpostviews($postID)
{
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}


function register_elementor_widgets($widgets_manager)
{
    require_once(__DIR__ . '/widgets/home.php');

    $widgets_manager->register(new \Elementor_home_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_widgets');


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
