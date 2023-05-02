<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
// dd($product);
// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
?>

<div class="card mb-4 product-wap rounded-0">
	<div class="card rounded-0">
		<img style="height:300px; object-fit:cover" class="card-img rounded-0 img-fluid" src="<?= get_the_post_thumbnail_url() ?>">
		<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
			<ul class="list-unstyled">
				<li style="display:flex; flex-direction:column;"><?php woocommerce_template_loop_add_to_cart() ?></li>
				<style>
					.added_to_cart {
						color: white !important;
					}
				</style>
			</ul>
		</div>
	</div>
	<div class="card-body">
		<a href="<?= get_permalink() ?>" class="h3 text-decoration-none"><?= get_the_title() ?></a>
		<p class="text-left mb-0">
			<?= $product->get_price_html() ?>
		</p>
	</div>
</div>