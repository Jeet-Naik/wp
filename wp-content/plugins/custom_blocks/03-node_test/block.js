	alert('block 3');
	const { registerBlockType } = wp.blocks;
	const { RichText } = wp.editor;

	// alert('test');
	registerBlockType('jeet-custom/node-test', {
		title: __('Name Badge', 'gutenberg-examples'),
		description: __('A Custom Block'),
		icon: 'admin-users',
		category: 'design',
		icon: 'nametag',
		keywords: [
			__('Name'),
			__('Badge'),
			__('Name Badge'),
		],
		attributes: {
			firstName: {
				type: 'string',
			},
			lastName: {
				type: 'string',
			}
		},


		edit: props => {

			const {
				attributes: { firstName, lastName },
				className, setAttributes
			} = props;

			return (
				<section class={'name-badge ' + className} >
					<header class="name-badge__header">
						<h1 class="name-badge__title">Hello, my name is:</h1>
					</header>
					<div class="name-badge__main">
						<RichText
							tagName="p"
							className={'name-badge__first-name'}
							placeholder={'Enter First Name'}
							onChange={firstName => { setAttributes({ firstName }) }}
							value={firstName}
							keepPlaceholderOnFocus
						/>
						<RichText
							tagName="p"
							className={'name-badge__last-name'}
							placeholder={'Enter Last Name'}
							onChange={lastName => { setAttributes({ lastName }) }}
							value={lastName}
							keepPlaceholderOnFocus
						/>
					</div>
				</section>
			);
		},
		save: props => {
			const {
				attributes: { firstName, lastName },
				className
			} = props;

			return (
				<section className={['name-badge', className].join(' ')} >
					<header class="name-badge__header">
						<h1 class="name-badge__title">Hello, my name is:</h1>
					</header>
					<div class="name-badge__main">
						<p class="name-badge__first-name">{firstName}</p>
						<p class="name-badge__last-name">{lastName}</p>
					</div>
				</section>
			);
		},
	});


	