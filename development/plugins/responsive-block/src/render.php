<?php
/**
 * Frontend of the Responsive Grid block.
 *
 * @package responsive-block
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner blocks markup.
 * @var WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$responsive_block_class   = responsive_block_enqueue_instance_styles( $attributes );
$responsive_block_wrapper = get_block_wrapper_attributes( array( 'class' => $responsive_block_class ) );
?>
<div <?php echo $responsive_block_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
