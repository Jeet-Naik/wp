/**
 * Hello World: Step 1
 *
 * Simple block, renders and saves the same content without interactivity.
 *
 * Using inline styles - no external stylesheet needed.  Not recommended
 * because all of these styles will appear in `post_content`.
 */
( function( blocks, i18n, element ) {
	var el = element.createElement;
	var __ = i18n.__;

	var blockStyle = {
		backgroundColor: '#009899',
		color: '#fff',
		padding: '20px',
	};
	// alert('test');
	blocks.registerBlockType( 'jeet-custom/basic-text', {
		title: __( 'Jeet Custom', 'gutenberg-examples' ),
		icon: 'smiley',
		category: 'layout',
		edit: function() {
			return el(
				'p',
				{ style: blockStyle },
				'Custom Block (Back-end).'
			);
		},
		save: function() {
			return el(
				'p',
				{ style: blockStyle },
				'Custom Block (Front-end).'
			);
		},
	} );
}(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element
) );
