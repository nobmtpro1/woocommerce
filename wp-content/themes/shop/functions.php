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

function register_elementor_widgets($widgets_manager)
{
    require_once(__DIR__ . '/widgets/home.php');
    require_once(__DIR__ . '/widgets/header.php');
    require_once(__DIR__ . '/widgets/footer.php');
    require_once(__DIR__ . '/widgets/shop.php');
    require_once(__DIR__ . '/widgets/product.php');

    $widgets_manager->register(new \Elementor_home_Widget());
    $widgets_manager->register(new \Elementor_header_Widget());
    $widgets_manager->register(new \Elementor_footer_Widget());
    $widgets_manager->register(new \Elementor_shop_Widget());
    $widgets_manager->register(new \Elementor_product_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_widgets');

function add_styles()
{
?>
    <link rel="stylesheet" href="<?= bloginfo('template_directory') ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= bloginfo('template_directory') ?>/assets/css/templatemo.css">
    <link rel="stylesheet" href="<?= bloginfo('template_directory') ?>/assets/css/custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="<?= bloginfo('template_directory') ?>/assets/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= bloginfo('template_directory') ?>/assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="<?= bloginfo('template_directory') ?>/assets/css/slick-theme.css">
<?php
}
add_action('wp_head', 'add_styles', 999999999);

add_action('elementor/frontend/after_register_scripts', function () {
    wp_register_script('script-1', get_template_directory_uri() . '/assets/js/jquery-1.11.0.min.js');
    wp_register_script('script-2', get_template_directory_uri() . '/assets/js/jquery-migrate-1.2.1.min.js');
    wp_register_script('script-3', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js');
    wp_register_script('script-4', get_template_directory_uri() . '/assets/js/templatemo.js');
    wp_register_script('script-5', get_template_directory_uri() . '/assets/js/custom.js');
    wp_register_script('script-6', get_template_directory_uri() . '/assets/js/slick.min.js');
    wp_register_script('script-7', get_template_directory_uri() . '/assets/js/product.js');

    wp_enqueue_script('script-1', 'script-1', [], '', true);
    wp_enqueue_script('script-2', 'script-2', [], '', true);
    wp_enqueue_script('script-3', 'script-3', [], '', true);
    wp_enqueue_script('script-4', 'script-4', [], '', true);
    wp_enqueue_script('script-5', 'script-5', [], '', true);
    wp_enqueue_script('script-6', 'script-6', [], '', true);
    wp_enqueue_script('script-7', 'script-7', [], '', true);
});

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

function cipher_add_to_cart_redirect($url = false)
{
    if (!empty($url)) {
        return $url;
    }
    return  add_query_arg(array(), remove_query_arg('add-to-cart'));
}
add_action('add_to_cart_redirect', 'cipher_add_to_cart_redirect');

add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
function iconic_cart_count_fragments($fragments)
{
    $fragments['.cart-contents-count'] = '<span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark cart-contents-count" id="mini-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}

add_filter('woocommerce_form_field_args', 'custom_form_field_args', 10, 3);
function custom_form_field_args($args, $key, $value)
{
    $args['input_class']  =  ['form-control'];
    return $args;
};


add_action('rest_api_init', function () {
    register_rest_route('shop', '/search', array(
        'methods' => 'GET',
        'callback' => function ($data) {
            $product = new WP_Query([
                'post_type' => 'product',
                's' => @$data->get_param('s')
            ]);
            wp_send_json_success($product->posts);
        },
    ));
});
