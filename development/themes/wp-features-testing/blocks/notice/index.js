/**
 * Editor registration of the Notice block. It runs without a build step,
 * so it uses the `wp` globals and `createElement` instead of JSX.
 *
 * The block has no style attribute of its own. The Styles panel offers the
 * variations that block.json declares and theme.json paints.
 */
( function ( wp ) {
	const { createElement: el, Fragment } = wp.element;
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, RichText, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl } = wp.components;
	const { __ } = wp.i18n;

	registerBlockType( 'wp-features-testing/notice', {
		edit: function Edit( { attributes, setAttributes } ) {
			const { title, content, dismissLabel } = attributes;
			const blockProps = useBlockProps();

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Settings', 'wp-features-testing' ) },
						el( TextControl, {
							label: __( 'Dismiss label', 'wp-features-testing' ),
							help: __(
								'The accessible name of the dismiss button.',
								'wp-features-testing'
							),
							value: dismissLabel,
							onChange: ( value ) => setAttributes( { dismissLabel: value } ),
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'div',
						{ className: 'wp-block-wp-features-testing-notice__body' },
						el( RichText, {
							tagName: 'p',
							className: 'wp-block-wp-features-testing-notice__title',
							value: title,
							allowedFormats: [],
							placeholder: __( 'Notice title', 'wp-features-testing' ),
							onChange: ( value ) => setAttributes( { title: value } ),
						} ),
						el( RichText, {
							tagName: 'p',
							className: 'wp-block-wp-features-testing-notice__content',
							value: content,
							placeholder: __( 'Notice message', 'wp-features-testing' ),
							onChange: ( value ) => setAttributes( { content: value } ),
						} )
					),
					el(
						'span',
						{
							className: 'wp-block-wp-features-testing-notice__dismiss',
							'aria-hidden': 'true',
						},
						el(
							'svg',
							{ viewBox: '0 0 24 24', width: 16, height: 16 },
							el( 'path', {
								d: 'M6 6l12 12M18 6L6 18',
								fill: 'none',
								stroke: 'currentColor',
								strokeWidth: 2,
								strokeLinecap: 'round',
							} )
						)
					)
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
