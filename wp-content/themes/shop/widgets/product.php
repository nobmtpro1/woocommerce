<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor product Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_product_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'product';
    }
    public function get_title()
    {
        return esc_html__('product', 'elementor-product-widget');
    }
    public function get_keywords()
    {
        return ['product'];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        global $product;
        $related = new WP_Query([
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'terms' => [@get_the_terms($product->ID, 'product_cat')[0]->slug],
                    'field' => 'slug',
                    'operator' => 'IN'
                ],
            ]
        ]);
        $gallery = $product->get_gallery_image_ids();
?>

        <!-- Open Content -->
        <section class="bg-light">
            <div class="container pb-5">
                <div class="row">
                    <div class="col-lg-5 mt-5">
                        <div class="card mb-3">
                            <img style="height:300px; object-fit:cover" class="card-img img-fluid" src="<?= get_the_post_thumbnail_url() ?>" alt="Card image cap" id="product-detail">
                        </div>
                        <div class="row">
                            <!--Start Controls-->
                            <div class="col-1 align-self-center">
                                <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                    <i class="text-dark fas fa-chevron-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </div>
                            <!--End Controls-->
                            <!--Start Carousel Wrapper-->
                            <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                                <!--Start Slides-->
                                <div class="carousel-inner product-links-wap" role="listbox">
                                    <?php $i = 0; ?>
                                    <?php foreach ($gallery as $image) : ?>
                                        <?php if (($i % 3) == 0) : ?>
                                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                                <div class="row">
                                                <?php endif ?>
                                                <div class="col-4">
                                                    <a href="#">
                                                        <img style="height:100px; object-fit:cover" class="card-img img-fluid" src="<?= wp_get_attachment_image_url($image, 'full') ?>" alt="Product Image 1">
                                                    </a>
                                                </div>
                                                <?php if (($i % 3) == 2 || $i == count($gallery) - 1) : ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <?php $i++ ?>
                                    <?php endforeach ?>
                                </div>
                                <!--End Slides-->
                            </div>
                            <!--End Carousel Wrapper-->
                            <!--Start Controls-->
                            <div class="col-1 align-self-center">
                                <a href="#multi-item-example" role="button" data-bs-slide="next">
                                    <i class="text-dark fas fa-chevron-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <!--End Controls-->
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-lg-7 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="h2"><?= $product->name ?></h1>
                                <p class="h3 py-2"><?= $product->get_price_html() ?></p>
                                <!-- <p class="py-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                                </p> -->
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <h6>Brand:</h6>
                                    </li>
                                    <li class="list-inline-item">
                                        <p class="text-muted"><strong><?= @end(@get_the_terms($product->ID, 'product_cat'))->name ?></strong></p>
                                    </li>
                                </ul>

                                <h6>Description:</h6>
                                <p><?= $product->short_description ?></p>
                                <?php woocommerce_template_single_add_to_cart() ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Close Content -->

        <!-- Start Article -->
        <section class="py-5">
            <div class="container">
                <div class="row text-left p-2 pb-3">
                    <h4>Related Products</h4>
                </div>

                <!--Start Carousel Wrapper-->
                <div id="carousel-related-product">
                    <?php
                    while ($related->have_posts()) {

                        $related->the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');
                    ?>
                        <div class="p-2 pb-3">
                            <?php
                            wc_get_template_part('content', 'product');
                            ?>
                        </div>
                    <?php
                    }

                    ?>

                </div>


            </div>
        </section>
        <!-- End Article -->

<?php
    }
}
