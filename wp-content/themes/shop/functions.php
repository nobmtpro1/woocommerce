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


class My_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'my-text',  // Base ID
            'My Text'   // Name
        );
        add_action('widgets_init', function () {
            register_widget('My_Widget');
        });
    }

    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>',
    );

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        echo '<div class="textwidget">';
        echo esc_html__($instance['text'], 'text_domain');
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'text_domain');
        $text  = !empty($instance['text']) ? $instance['text'] : esc_html__('', 'text_domain');
?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('Text')); ?>"><?php echo esc_html__('Text:', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>" type="text" cols="30" rows="10"><?php echo esc_attr($text); ?></textarea>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance          = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['text']  = (!empty($new_instance['text'])) ? $new_instance['text'] : '';
        return $instance;
    }
}
$my_widget = new My_Widget();
