<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor home Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_home_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'home';
    }
    public function get_title()
    {
        return esc_html__('home', 'elementor-home-widget');
    }
    public function get_keywords()
    {
        return ['home'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Slider', 'elementor-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        /* Start repeater */

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'elementor-home-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'elementor-home-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'elementor-home-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'elementor-home-widget'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        /* End repeater */

        $this->add_control(
            'list_items',
            [
                'label' => esc_html__('List Items', 'elementor-home-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        // dd($settings['list_items']);
?>
        <!-- Modal -->
        <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="w-100 pt-1 mb-5 text-right">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get" class="modal-content modal-body border-0 p-0">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                        <button type="submit" class="input-group-text bg-success text-light">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Start Banner Hero -->
        <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <?php $i = 0; ?>
                <?php foreach ($settings['list_items'] ?? [] as $item) : ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                        <div class="container">
                            <div class="row p-5">
                                <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                    <img class="img-fluid" src="<?= @$item['image']['url'] ?>" alt="">
                                </div>
                                <div class="col-lg-6 mb-0 d-flex align-items-center">
                                    <div class="text-align-left align-self-center">
                                        <h1 class="h1 text-success"><?= @$item['title'] ?></h1>
                                        <h3 class="h2"><?= @$item['description'] ?></h3>
                                        <p>
                                            <?= @$item['content'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $i++;
                endforeach ?>
            </div>
            <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </a>
            <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        <!-- End Banner Hero -->


        <!-- Start Categories of The Month -->
        <section class="container py-5">
            <div class="row text-center pt-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Categories of The Month</h1>
                    <p>
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
            <div class="row">
                <?php
                $terms = get_terms([
                    'taxonomy'   => 'product_cat',
                    'number' => 3,
                    'meta_query' => [
                        [
                            'key'     => 'thumbnail_id',
                            'value'   => array(''),
                            'compare' => 'NOT IN'
                        ]
                    ]
                ]);
                // dd($terms);
                foreach ($terms as $term) :
                ?>
                    <?php
                    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
                    ?>
                    <div class="col-12 col-md-4 p-5 mt-3">
                        <a href="#"><img src="<?= $image; ?>" class="rounded-circle img-fluid border"></a>
                        <h5 class="text-center mt-3 mb-3"><?= $term->name ?></h5>
                        <p class="text-center"><a href="<?= get_term_link($term) ?>" class="btn btn-success">Go Shop</a></p>
                    </div>
                <?php endforeach ?>
                <!-- <div class="col-12 col-md-4 p-5 mt-3">
                    <a href="#"><img src="<?= bloginfo('template_directory') ?>/assets/img/category_img_02.jpg" class="rounded-circle img-fluid border"></a>
                    <h2 class="h5 text-center mt-3 mb-3">Shoes</h2>
                    <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
                </div>
                <div class="col-12 col-md-4 p-5 mt-3">
                    <a href="#"><img src="<?= bloginfo('template_directory') ?>/assets/img/category_img_03.jpg" class="rounded-circle img-fluid border"></a>
                    <h2 class="h5 text-center mt-3 mb-3">Accessories</h2>
                    <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
                </div> -->
            </div>
        </section>
        <!-- End Categories of The Month -->


        <!-- Start Featured Product -->
        <section class="bg-light">
            <div class="container py-5">
                <div class="row text-center py-3">
                    <div class="col-lg-6 m-auto">
                        <h1 class="h1">Featured Product</h1>
                        <p>
                            Reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            Excepteur sint occaecat cupidatat non proident.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $query = new WP_Query(array(
                        'post_type'           => 'product',
                        'ignore_sticky_posts' => 1,
                        'posts_per_page'      => 6,
                        'tax_query'           => [[
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                        ]],
                        'meta_query' => array(
                            array(
                                'key' => '_stock_status',
                                'value' => 'instock'
                            ),
                            array(
                                'key' => '_backorders',
                                'value' => 'no'
                            ),
                        )
                    ));
                    ?>
                    <?php foreach ($query->posts as $product) : ?>
                        <?php $wcProduct = wc_get_product($product->ID); ?>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card h-100">
                                <a href="<?= get_permalink($product) ?>">
                                    <img style="height:200px; object-fit:cover" src="<?= get_the_post_thumbnail_url($product) ?>" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <ul class="list-unstyled d-flex justify-content-between">
                                        <li>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                        </li>
                                        <li class="text-muted text-right">
                                            <?php if ($wcProduct->get_sale_price()) : ?>
                                                <s>$<?= $wcProduct->get_regular_price() ?></s>
                                                $<?= $wcProduct->get_sale_price() ?>
                                            <?php else : ?>
                                                $<?= $wcProduct->get_regular_price() ?>
                                            <?php endif ?>

                                        </li>
                                    </ul>
                                    <a href="shop-single.html" class="h2 text-decoration-none text-dark"><?= get_the_title($product) ?></a>
                                    <p class="card-text">
                                        <?= get_the_excerpt($product) ?>
                                    </p>
                                    <p class="text-muted">Reviews (<?= get_comments_number($product) ?>)</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
        <!-- End Featured Product -->

<?php
    }
}
