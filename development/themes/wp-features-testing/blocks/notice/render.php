<?php
/**
 * Render the Notice block.
 *
 * The look comes from theme.json: the base style, and the `destructive` block
 * style variation. This file only renders the structure.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner blocks content.
 * @var WP_Block $block      Block instance.
 */

declare(strict_types=1);

$notice_title   = $attributes['title'] ?? '';
$notice_text    = $attributes['content'] ?? '';
$dismiss_label  = $attributes['dismissLabel'] ?? __( 'Dismiss', 'wp-features-testing' );
$is_destructive = str_contains( $attributes['className'] ?? '', 'is-style-destructive' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'role'                 => $is_destructive ? 'alert' : 'status',
		'data-wp-interactive'  => 'wp-features-testing/notice',
		'data-wp-context'      => wp_json_encode( array( 'isOpen' => true ) ),
		'data-wp-bind--hidden' => '!context.isOpen',
	)
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wp-block-wp-features-testing-notice__body">
		<?php if ( '' !== $notice_title ) : ?>
			<p class="wp-block-wp-features-testing-notice__title"><?php echo wp_kses_post( $notice_title ); ?></p>
		<?php endif; ?>
		<?php if ( '' !== $notice_text ) : ?>
			<p class="wp-block-wp-features-testing-notice__content"><?php echo wp_kses_post( $notice_text ); ?></p>
		<?php endif; ?>
	</div>
	<button
		type="button"
		class="wp-block-wp-features-testing-notice__dismiss"
		aria-label="<?php echo esc_attr( $dismiss_label ); ?>"
		data-wp-on--click="actions.dismiss"
	>
		<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
			<path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
		</svg>
	</button>
</div>
