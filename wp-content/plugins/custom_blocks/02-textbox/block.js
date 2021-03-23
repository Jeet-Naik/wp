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
	// alert('test');
	blocks.registerBlockType( 'jeet-custom/basic-textbox', {
		title: __( 'Custom Textbox', 'gutenberg-examples' ),
		icon: 'admin-appearance',
		category: 'layout',
		attributes: {
			content: {type: 'string'},
			color: {type: 'string'},
			password: {type: 'string'}
		},
		edit: function(props) {
			function updateContent(event) {
			  props.setAttributes({content: event.target.value})
			}
			function updatePassword(event) {
				props.setAttributes({password: event.target.value})
			  }
			function updateColor(value) {
			  props.setAttributes({color: value.hex})
			}
			return React.createElement(
			  "div",
			  null,
			  React.createElement(
				"h3",
				null,
				"Color Box"
			  ),
			  React.createElement("label", { },'Textbox example'),
			  React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
			  React.createElement("br"),
			  React.createElement("label", { },'Password example'),
			  React.createElement("input", { type: "password", value: props.attributes.password, onChange: updatePassword }),
			  React.createElement("br"),
			  React.createElement("p",{} ,'choose text color for this content'),
			  React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
			);
		  },
		  save: function(props) {
			  
			  console.log("data"+props.attributes);
			return wp.element.createElement(
			  "h3",
			  { style: { color:  props.attributes.color } },
			  "Text:- "+  props.attributes.content +"\n\npassword:-" +  props.attributes.password
			);

		  },
	} );
}(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element
) );
