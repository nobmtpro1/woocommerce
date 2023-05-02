<?php

/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined('ABSPATH') || exit;

/* translators: %s: Quantity. */
$label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'woocommerce'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'woocommerce');

?>
<div class="quantity col-auto">

	<ul class="list-inline pb-3">
		<li class="list-inline-item text-right">
			Quantity

			<?php
			/**
			 * Hook to output something before the quantity input field.
			 *
			 * @since 7.2.0
			 */
			do_action('woocommerce_before_quantity_input_field');
			?>
			<label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>
			<input type="hidden" <?php echo $readonly ? 'readonly="readonly"' : ''; ?> id="<?php echo esc_attr($input_id); ?>" class="input-text qty text <?php echo esc_attr(join(' ', (array) $classes)); ?>" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($input_value); ?>" title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>" size="4" min="<?php echo esc_attr($min_value); ?>" max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>" <?php if (!$readonly) : ?> step="<?php echo esc_attr($step); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" inputmode="<?php echo esc_attr($inputmode); ?>" autocomplete="<?php echo esc_attr(isset($autocomplete) ? $autocomplete : 'on'); ?>" <?php endif; ?> />
			<?php
			/**
			 * Hook to output something after quantity input field
			 *
			 * @since 3.6.0
			 */
			do_action('woocommerce_after_quantity_input_field');
			?>
		</li>
		<li class="list-inline-item"><span class="btn btn-success btn-minus" id="btn-minus">-</span></li>
		<li class="list-inline-item"><span class="badge bg-secondary var-value" id="var-value"><?php echo esc_attr($input_value); ?></span></li>
		<li class="list-inline-item"><span class="btn btn-success btn-plus" id="btn-plus">+</span></li>
	</ul>


</div>
<?php
