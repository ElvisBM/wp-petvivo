<?php
return array(
	array(
		'title' => __('Logo & favicon', 'rehub_framework'),
		'name' => 'menu_12',
		'icon' => 'font-awesome:fa-gear',
		'controls' => array(

			array(
				'type' => 'section',
				'title' => __('Logo settings', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'upload',
						'name' => 'rehub_logo',
						'label' => __('Upload Logo', 'rehub_framework'),
						'description' => __('Upload your logo. Max width is 450px. (1200px for full width, 180px for logo + menu row layout)', 'rehub_framework'),
						'default' => '',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_pad_top',
						'label' => __('Set padding from top (without px)', 'rehub_framework'),
						'description' => __('This will add custom padding from top for logo section. Default is 20', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_pad_bottom',
						'label' => __('Set padding from bottom (without px)', 'rehub_framework'),
						'description' => __('This will add custom padding from bottom for logo section. Default is 20', 'rehub_framework'),
					),																
					array(
						'type' => 'upload',
						'name' => 'rehub_logo_retina',
						'label' => __('Upload Logo (retina version)', 'rehub_framework'),
						'description' => __('Upload retina version of the logo. It should be 2x the size of main logo.', 'rehub_framework'),
						'default' => '',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_retina_width',
						'label' => __('Logo width', 'rehub_framework'),
						'description' => __('Please enter the standard logo (1x) version width', 'rehub_framework'),
					),	
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_retina_height',
						'label' => __('Retina logo height', 'rehub_framework'),							
						'description' => __('Please enter the standard logo (1x) version height', 'rehub_framework'),
					),																	
					array(
						'type' => 'textbox',
						'name' => 'rehub_text_logo',
						'label' => __('Text logo', 'rehub_framework'),							
						'description' => __('You can type text logo. Use this field only if no image logo', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_text_slogan',
						'label' => __('Slogan', 'rehub_framework'),							
						'description' => __('You can type slogan below text logo. Use this field only if no image logo', 'rehub_framework'),
					),							
				),
			),

			array(
				'type' => 'section',
				'title' => __('Favicons', 'rehub_framework'),
				'fields' => array(
					 array(
						'type' => 'notebox',
						'name' => 'rehub_favicon_note',
						'label' => __('Note!', 'rehub_framework'),
						'description' => __('Wordpress 4.3 has built-in favicon function. You can set favicon from Appearance - Customize - Site Identity - Site Icon', 'rehub_framework'),
						'status' => 'info',
					),						
				),
			),
		),
	),
	array(
		'title' => __('Header and Menu', 'rehub_framework'),
		'name' => 'menu_2',
		'icon' => 'font-awesome:fa-wrench ',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Main Header Options', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'rehub_body_block',
						'label' => __('Enable block width of header', 'rehub_framework'),
						'default' => '0',
					),							
					array(
						'type' => 'select',
						'name' => 'rehub_header_style',
						'label' => __('Select Header style', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'header_first',
								'label' => __('Logo + code zone 468X60 + search box', 'rehub_framework'),
							),
							array(
								'value' => 'header_second',
								'label' => __('Logo + code zone 728X90', 'rehub_framework'),
							),
							array(
								'value' => 'header_third',
								'label' => __('Full width logo', 'rehub_framework'),
							),
							array(
								'value' => 'header_fourth',
								'label' => __('Full width logo + full width code zone', 'rehub_framework'),
							),	
							array(
								'value' => 'header_five',
								'label' => __('Logo + menu in one row', 'rehub_framework'),
							),	
							array(
								'value' => 'header_six',
								'label' => __('Customizable header', 'rehub_framework'),
							),	
							array(
								'value' => 'header_seven',
								'label' => __('Shop/Comparison header (logo + search + login + cart/compare icon)', 'rehub_framework'),
							),																												
						),
							'default' => array(
							'header_first',
						),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_padseven_top',
						'label' => __('Set padding from top and bottom (without px)', 'rehub_framework'),
						'description' => __('This will add custom padding from top and bottom for all custom elements in logo section. Default is 15', 'rehub_framework'),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_seven',
						),						
					),
					array(
						'type' => 'toggle',
						'name' => 'header_seven_compare_btn',
						'label' => __('Change cart to compare button', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_seven',
						),							
					),					
					array(
						'type' => 'textbox',
						'name' => 'header_seven_btn_login_url',
						'label' => __('Type url for login button', 'rehub_framework'),
						'description' => __('By default, login button triggers login popup, but you can redirect users to any link with registration form if you set this field', 'rehub_framework'),						
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_seven',
						),														
					),	
					array(
						'type' => 'textarea',
						'name' => 'header_seven_more_element',
						'label' => __('Add additional element (shortcodes and html supported)', 'rehub_framework'),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_seven',
						),														
					),														
					array(
						'type' => 'textbox',
						'name' => 'rehub_logo_padsix_top',
						'label' => __('Set padding from top and bottom (without px)', 'rehub_framework'),
						'description' => __('This will add custom padding from top and bottom for all custom elements in logo section. Default is 15', 'rehub_framework'),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),						
					),					

					array(
						'type' => 'toggle',
						'name' => 'header_six_login',
						'label' => __('Enable login/register section', 'rehub_framework'),
						'description' => __('Also, login popup must be enabled in Theme option - User options', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),							
					),
					array(
						'type' => 'textbox',
						'name' => 'header_six_btn_login_url',
						'label' => __('Type url for login button', 'rehub_framework'),
						'description' => __('By default, login button triggers login popup, but you can redirect users to any link with registration form if you set this field', 'rehub_framework'),						
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),														
					),					
					array(
						'type' => 'toggle',
						'name' => 'header_six_btn',
						'label' => __('Enable additional button in header', 'rehub_framework'),
						'description' => __('This will add button in header', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),							
					),	
					array(
						'type' => 'select',
						'name' => 'header_six_btn_color',
						'label' => __('Choose color style of button', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => 'green',
								'label' => __('green', 'rehub_framework'),
							),
							array(
								'value' => 'orange',
								'label' => __('orange', 'rehub_framework'),
							),
							array(
								'value' => 'red',
								'label' => __('red', 'rehub_framework'),
							),
							array(
								'value' => 'blue',
								'label' => __('blue', 'rehub_framework'),
							),	
							array(
								'value' => 'black',
								'label' => __('black', 'rehub_framework'),
							),
							array(
								'value' => 'rosy',
								'label' => __('rosy', 'rehub_framework'),
							),
							array(
								'value' => 'brown',
								'label' => __('brown', 'rehub_framework'),
							),
							array(
								'value' => 'pink',
								'label' => __('pink', 'rehub_framework'),
							),
							array(
								'value' => 'purple',
								'label' => __('purple', 'rehub_framework'),
							),
							array(
								'value' => 'gold',
								'label' => __('gold', 'rehub_framework'),
							),																															
						),
						'default' => array(
							'green',
						),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),						
					),						
					array(
						'type' => 'textbox',
						'name' => 'header_six_btn_txt',
						'label' => __('Type label for button', 'rehub_framework'),
						'default' => 'Submit a deal',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),														
					),	
					array(
						'type' => 'textbox',
						'name' => 'header_six_btn_url',
						'label' => __('Type url for button', 'rehub_framework'),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),														
					),	
					array(
						'type' => 'toggle',
						'name' => 'header_six_btn_login',
						'label' => __('Enable login popup for non registered users', 'rehub_framework'),
						'description' => __('This will open popup if non registered user clicks on button. Also, login popup must be enabled in Theme option - User options', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),							
					),	
					array(
						'type' => 'toggle',
						'name' => 'header_six_src',
						'label' => __('Enable search form in header', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),							
					),	
					array(
						'type' => 'select',
						'name' => 'header_six_menu',
						'label' => __('Enable additional menu near logo', 'rehub_framework'),
						'description' => __('Use short menu with small number of items!!!', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_menus',
								),
							),
						),
						'dependency' => array(
							'field'    => 'rehub_header_style',
							'function' => 'rehub_framework_is_header_six',
						),														
					),


					array(
						'type' => 'toggle',
						'name' => 'rehub_logo_inmenu',
						'label' => __('Enable compact logo of header on mobiles', 'rehub_framework'),
						'description' => __('This will add logo to menu row and disable top section in mobile view', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'upload',
						'name' => 'rehub_logo_inmenu_url',
						'label' => __('Upload Logo for mobiles', 'rehub_framework'),
						'description' => __('Upload your logo. Max height is 40px. By default, your main logo will be used', 'rehub_framework'),
						'default' => '',
						'dependency' => array(
                        	'field' => 'rehub_logo_inmenu',
                        	'function' => 'vp_dep_boolean',
                        ),							
					),																	
					array(
						'type' => 'toggle',
						'name' => 'rehub_sticky_nav',
						'label' => __('Sticky Menu Bar', 'rehub_framework'),
						'description' => __('Enable/Disable Sticky navigation bar.', 'rehub_framework'),
						'default' => '0',
					),		
					array(
						'type' => 'upload',
						'name' => 'rehub_logo_sticky_url',
						'label' => __('Upload Logo for sticky menu', 'rehub_framework'),
						'description' => __('Upload your logo. Max height is 40px.', 'rehub_framework'),
						'default' => '',
						'dependency' => array(
                        	'field' => 'rehub_sticky_nav',
                        	'function' => 'vp_dep_boolean',
                        ),							
					),															
					array(
						'type' => 'select',
						'name' => 'header_logoline_style',
						'label' => __('Choose color style of header logo section', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => '0',
								'label' => __('White style and dark fonts', 'rehub_framework'),
							),
							array(
								'value' => '1',
								'label' => __('Dark style and white fonts', 'rehub_framework'),
							),
						),
						'default' => array(
							'0',
						),
					),
					array(
						'type' => 'color',
						'name' => 'rehub_header_color_background',
						'label' => __('Custom Background Color', 'rehub_framework'),
						'description' => __('Choose the background color or leave blank for default', 'rehub_framework'),
						'format' => 'hex',	
					),
					array(
						'type' => 'upload',
						'name' => 'rehub_header_background_image',
						'label' => __('Custom Background Image', 'rehub_framework'),
						'description' => __('Upload a background image or leave blank', 'rehub_framework'),
						'default' => '',
						
					),
					array(
						'type' => 'select',
						'name' => 'rehub_header_background_repeat',
						'label' => __('Background Repeat', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'repeat',
								'label' => __('Repeat', 'rehub_framework'),
							),
							array(
								'value' => 'no-repeat',
								'label' => __('No Repeat', 'rehub_framework'),
							),
							array(
								'value' => 'repeat-x',
								'label' => __('Repeat X', 'rehub_framework'),
							),
							array(
								'value' => 'repeat-y',
								'label' => __('Repeat Y', 'rehub_framework'),
							),
						),
						
					),
					array(
						'type' => 'select',
						'name' => 'rehub_header_background_position',
						'label' => __('Background Position', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'left',
								'label' => 'Left',
							),
							array(
								'value' => 'center',
								'label' => 'Center',
							),
							array(
								'value' => 'right',
								'label' => 'Right',
							),
						),													
					),																										
				),
			),

			array(
				'type' => 'section',
				'title' => __('Header main menu Options', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'select',
						'name' => 'header_menuline_style',
						'label' => __('Choose color style of header menu section', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => '0',
								'label' => __('White style and dark fonts', 'rehub_framework'),
							),
							array(
								'value' => '1',
								'label' => __('Dark style and white fonts', 'rehub_framework'),
							),
						),
						'default' => array(
							'1',
						),
					),
					array(
						'type' => 'color',
						'name' => 'rehub_custom_color_nav',
						'label' => __('Custom color of menu background', 'rehub_framework'),
						'description' => __('Or leave blank for default color', 'rehub_framework'),
						'format' => 'hex',
						
					),	
					 array(
						'type' => 'color',
						'name' => 'rehub_custom_color_nav_font',
						'label' => __('Custom color of menu font', 'rehub_framework'),
						'description' => __('Or leave blank for default color', 'rehub_framework'),
						'format' => 'hex',							
					),
				),
			),

			array(
				'type' => 'section',
				'title' => __('Search', 'rehub_framework'),
				'fields' => array(				
					array(
						'type' => 'select',
						'name' => 'rehub_search_icon',
						'label' => __('Add additional search icon', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'no',
								'label' => __('No additional icon', 'rehub_framework'),
							),
							array(
								'value' => 'menu',
								'label' => __('In main menu', 'rehub_framework'),
							),															
						),
							'default' => array(
							'no',
						),
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_ajax_search',
						'label' => __('Add ajax search for header search', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'multiselect',
						'name' => 'rehub_search_ptypes',
						'label' => __('Choose custom post type for search', 'rehub_framework'),
						'description' => __('By default search form shows post and pages. You can change this here. Multiple post types are supported only for ajax search', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value'  => 'rehub_get_cpost_type',
								),
							),
						),
						'default' => '',			
					),							


				),
			),			

			array(
				'type' => 'section',
				'title' => __('Header top line Options', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'select',
						'name' => 'header_topline_style',
						'label' => __('Choose color style of header top line', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => '0',
								'label' => __('White style and dark fonts', 'rehub_framework'),
							),
							array(
								'value' => '1',
								'label' => __('Dark style and white fonts', 'rehub_framework'),
							),
						),
						'default' => array(
							'0',
						),
					),
					 array(
						'type' => 'color',
						'name' => 'rehub_custom_color_top',
						'label' => __('Custom color for top line of header', 'rehub_framework'),
						'description' => __('Or leave blank for default color', 'rehub_framework'),
						'format' => 'hex',
						
					),	
					 array(
						'type' => 'color',
						'name' => 'rehub_custom_color_top_font',
						'label' => __('Custom color of menu font for top line of header', 'rehub_framework'),
						'description' => __('Or leave blank for default color', 'rehub_framework'),
						'format' => 'hex',				
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_header_social',
						'label' => __('Enable Header Social Icons', 'rehub_framework'),
						'description' => __('You can set your social media URLs in the Social Media Options tab.', 'rehub_framework'),
						'default' => '1',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_logged_enable_intop',
						'label' => __('Replace top menu when user logined', 'rehub_framework'),
						'description' => __('Default top menu will be replaced with /User Logged In Menu/', 'rehub_framework'),
						'default' => '0',
					),												
					array(
						'type' => 'toggle',
						'name' => 'rehub_header_top',
						'label' => __('Disable top line', 'rehub_framework'),
						'description' => __('You can disable top line', 'rehub_framework'),
						'default' => '0',
					),									
	
				),
			),				

			array(
				'type' => 'section',
				'title' => __('News ticker', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'rehub_enable_newstick',
						'label' => __('Enable news ticker', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_enable_newstick_home',
						'label' => __('Show only on home', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'textbox',
						'name' => 'rehub_newstick_label',
						'label' => __('Type label of newsticker', 'rehub_framework'),
						'default' => 'Special',							
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_newstick_cat',
						'label' => __('Categories', 'rehub_framework'),
						'description' => __('Set ids of categories to show in Newsticker separated by comma', 'rehub_framework'),							
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_newstick_tag',
						'label' => __('Tags', 'rehub_framework'),
						'description' => __('Set ids of tags to show in Newsticker separated by comma', 'rehub_framework'),						
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_newstick_fetch',
						'label' => __('Number of posts to display', 'rehub_framework'),
						'default' => '5',
						'validation' => 'numeric',							
					),						

				),
			),							
		),
	),
	array(
		'title' => __('Footer Options', 'rehub_framework'),
		'name' => 'menu_3',
		'icon' => 'font-awesome:fa-caret-square-o-down',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Footer options', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'rehub_footer_widgets',
						'label' => __('Footer Widgets', 'rehub_framework'),
						'description' => __('Enable or Disable the footer widget area', 'rehub_framework'),
						'default' => '1',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_footer_block',
						'label' => __('Enable footer block width?', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'select',
						'name' => 'footer_style',
						'label' => __('Choose color style of footer widget section', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => '0',
								'label' => __('Dark style and white fonts', 'rehub_framework'),
							),
							array(
								'value' => '1',
								'label' => __('White style and dark fonts', 'rehub_framework'),
							),
						),
						'default' => array(
							'0',
						),
					),
					array(
						'type' => 'color',
						'name' => 'footer_color_background',
						'label' => __('Custom Background Color', 'rehub_framework'),
						'description' => __('Choose the background color or leave blank for default', 'rehub_framework'),
						'format' => 'hex',	
					),
					array(
						'type' => 'upload',
						'name' => 'footer_background_image',
						'label' => __('Custom Background Image', 'rehub_framework'),
						'description' => __('Upload a background image or leave blank', 'rehub_framework'),
						'default' => '',
						
					),
					array(
						'type' => 'select',
						'name' => 'footer_background_repeat',
						'label' => __('Background Repeat', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'repeat',
								'label' => __('Repeat', 'rehub_framework'),
							),
							array(
								'value' => 'no-repeat',
								'label' => __('No Repeat', 'rehub_framework'),
							),
							array(
								'value' => 'repeat-x',
								'label' => __('Repeat X', 'rehub_framework'),
							),
							array(
								'value' => 'repeat-y',
								'label' => __('Repeat Y', 'rehub_framework'),
							),
						),
						
					),
					array(
						'type' => 'select',
						'name' => 'footer_background_position',
						'label' => __('Background Position', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'left',
								'label' => 'Left',
							),
							array(
								'value' => 'center',
								'label' => 'Center',
							),
							array(
								'value' => 'right',
								'label' => 'Right',
							),
						),													
					),	
					array(
						'type' => 'select',
						'name' => 'footer_style_bottom',
						'label' => __('Choose color style of bottom section', 'rehub_framework'),							
						'items' => array(
							array(
								'value' => '0',
								'label' => __('Dark style and white fonts', 'rehub_framework'),
							),
							array(
								'value' => '1',
								'label' => __('White style and dark fonts', 'rehub_framework'),
							),
						),
						'default' => array(
							'0',
						),
					),																															
					array(
						'type' => 'textarea',
						'name' => 'rehub_footer_text',
						'label' => __('Footer Bottom Text', 'rehub_framework'),
						'description' => __('Enter your copyright text or whatever you want right here.', 'rehub_framework'),
						'default' => '2016 Wpsoul.com Design. All rights reserved.',
					),
					array(
						'type' => 'upload',
						'name' => 'rehub_footer_logo',
						'label' => __('Upload Logo for footer', 'rehub_framework'),
						'description' => __('Upload your logo for footer.', 'rehub_framework'),
						'default' => '',
					),						
				),
			),
		),
	),
	array(
		'title' => __('Social Media Options', 'rehub_framework'),
		'name' => 'menu_5',
		'icon' => 'font-awesome:fa-twitter',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Social Media Pages', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'textbox',
						'name' => 'rehub_facebook',
						'label' => __('Facebook link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_twitter',
						'label' => __('Twitter link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_google',
						'label' => __('Google plus link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_instagram',
						'label' => __('Instagram link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_wa',
						'label' => __('WhatsApp link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_youtube',
						'label' => __('Youtube link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_vimeo',
						'label' => __('Vimeo link', 'rehub_framework'),
						'validation' => 'url',
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_pinterest',
						'label' => __('Pinterest link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_linkedin',
						'label' => __('Linkedin link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_soundcloud',
						'label' => __('Soundcloud link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_dribbble',
						'label' => __('Dribbble link', 'rehub_framework'),
						'validation' => 'url',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_vk',
						'label' => __('Vk.com link', 'rehub_framework'),
						'validation' => 'url',
					),

					array(
						'type' => 'textbox',
						'name' => 'rehub_rss',
						'label' => __('Rss link', 'rehub_framework'),
						'validation' => 'url',
					),												
				),
			),
		),
	),
	array(
		'title' => __('Fonts Options', 'rehub_framework'),
		'name' => 'menu_7',
		'icon' => 'font-awesome:fa-font',
		'controls' => array(

			array(
				'type' => 'section',
				'title' => __('Navigation Font', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'select',
						'name' => 'rehub_nav_font',
						'label' => __('Navigation Font Family', 'rehub_framework'),
						'description' => __('Font for navigation', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_gwf_family',
								),
							),
						),
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_nav_font_style',
						'label' => __('Font Style', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_nav_font',
									'value' => 'vp_get_gwf_style',
								),
							),
						),
						'default' => array(
							'{{first}}',
						),							
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_nav_font_weight',
						'label' => __('Font Weight', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_nav_font',
									'value' => 'vp_get_gwf_weight',
								),
							),
						),
					),
					array(
						'type' => 'multiselect',
						'name' => 'rehub_nav_font_subset',
						'label' => __('Font Subset', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_nav_font',
									'value' => 'vp_get_gwf_subset',
								),
							),
						),
						'default' => 'latin',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_nav_font_trans',
						'label' => __('Disable uppercase?', 'rehub_framework'),
						'default' => '0',							
					),												
				),
			),//END NAV FONT

			array(
				'type' => 'section',
				'title' => __('Headings Font', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'select',
						'name' => 'rehub_headings_font',
						'label' => __('Headings Font Family', 'rehub_framework'),
						'description' => __('Font for headings in text, sidebar, footer', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_gwf_family',
								),
							),
						),
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_headings_font_style',
						'label' => __('Font Style', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_headings_font',
									'value' => 'vp_get_gwf_style',
								),
							),
						),
						'default' => array(
							'{{first}}',
						),							
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_headings_font_weight',
						'label' => __('Font Weight', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_headings_font',
									'value' => 'vp_get_gwf_weight',
								),
							),
						),
					),
					array(
						'type' => 'multiselect',
						'name' => 'rehub_headings_font_subset',
						'label' => __('Font Subset', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_headings_font',
									'value' => 'vp_get_gwf_subset',
								),
							),
						),
						'default' => 'latin',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_headings_font_upper',
						'label' => __('Enable uppercase?', 'rehub_framework'),
						'default' => '0',							
					),												
				),
			),//END Headings FONT

			array(
				'type' => 'section',
				'title' => __('Body Font', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'select',
						'name' => 'rehub_body_font',
						'label' => __('Body Font Family', 'rehub_framework'),
						'description' => __('Font for body text', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_gwf_family',
								),
							),
						),
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_body_font_style',
						'label' => __('Font Style', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_body_font',
									'value' => 'vp_get_gwf_style',
								),
							),
						),
						'default' => array(
							'{{first}}',
						),							
					),
					array(
						'type' => 'radiobutton',
						'name' => 'rehub_body_font_weight',
						'label' => __('Font Weight', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_body_font',
									'value' => 'vp_get_gwf_weight',
								),
							),
						),
					),
					array(
						'type' => 'multiselect',
						'name' => 'rehub_body_font_subset',
						'label' => __('Font Subset', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'binding',
									'field' => 'rehub_body_font',
									'value' => 'vp_get_gwf_subset',
								),
							),
						),
						'default' => 'latin',
					),	
					array(
						'type' => 'textbox',
						'name' => 'body_font_size',
						'label' => __('Set body font size', 'rehub_framework'),
						'description' => __('Set font size in px', 'rehub_framework'),
					),											
				),
			),//END Body FONT


		),
	),
	array(
		'title' => __('Global Enable/Disable', 'rehub_framework'),
		'name' => 'menu_8',
		'icon' => 'font-awesome:fa-globe',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Global options', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'aq_resize',
						'label' => __('Enable resizer script', 'rehub_framework'),
						'description' => __('Use resizer script for thumbnails', 'rehub_framework'),
						'default' => '1',
					),
					array(
						'type' => 'toggle',
						'name' => 'aq_resize_crop',
						'label' => __('Disable crop in resizer script', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'enable_lazy_images',
						'label' => __('Enable lazyload script on thumbnails for better image perfomance. Sometimes can be buggy with other scripts', 'rehub_framework'),
						'default' => '0',
					),											
					array(
						'type' => 'toggle',
						'name' => 'shortcode_enable',
						'label' => __('Enable theme shortcode', 'rehub_framework'),
						'description' => __('Enable built-in shortcode plugin', 'rehub_framework'),
						'default' => '1',
					),	
					array(
						'type' => 'toggle',
						'name' => 'repick_social_disable',
						'label' => __('Disable social buttons on images', 'rehub_framework'),
						'description' => __('Enable/Disable buttons in grid loop', 'rehub_framework'),
						'default' => '0',
					),											
					array(
						'type' => 'toggle',
						'name' => 'exclude_author_meta',
						'label' => __('Disable author link', 'rehub_framework'),
						'description' => __('Disable author link from meta in string', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'exclude_cat_meta',
						'label' => __('Disable category link', 'rehub_framework'),
						'description' => __('Disable category link from meta in string', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'exclude_date_meta',
						'label' => __('Disable date', 'rehub_framework'),
						'description' => __('Disable date from meta in string', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'exclude_comments_meta',
						'label' => __('Disable comments count', 'rehub_framework'),
						'description' => __('Disable comments count from meta in string', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'hotmeter_disable',
						'label' => __('Disable hot and thumb metter', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'post_view_disable',
						'label' => __('Disable post view script', 'rehub_framework'),
						'default' => '0',
					),					
					array(
						'type' => 'toggle',
						'name' => 'disable_btn_offer_loop',
						'label' => __('Disable offer button in archives and loops?', 'rehub_framework'),
						'default' => '0',
					),																																																								
				),
			),
			array(
				'type' => 'section',
				'title' => __('Global disabling parts on single pages', 'rehub_framework'),
				'fields' => array(												
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_breadcrumbs',
						'label' => __('Disable breadcrumbs', 'rehub_framework'),
						'description' => __('Disable breadcrumbs from pages', 'rehub_framework'),
						'default' => '0',
					),

					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_share',
						'label' => __('Disable share buttons', 'rehub_framework'),
						'description' => __('Disable share buttons after content on pages', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_share_top',
						'label' => __('Disable share buttons', 'rehub_framework'),
						'description' => __('Disable share buttons before content on pages', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_social_footer',
						'label' => __('Disable share buttons in footer on mobiles', 'rehub_framework'),
						'default' => '0',
					),																	
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_prev',
						'label' => __('Disable previous and next', 'rehub_framework'),
						'description' => __('Disable previous and next post buttons', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_totop',
						'label' => __('Disable to top button', 'rehub_framework'),
						'default' => '0',
					),																	
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_tags',
						'label' => __('Disable tags', 'rehub_framework'),
						'description' => __('Disable tags after content from pages', 'rehub_framework'),
						'default' => '0',
					),
	
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_author',
						'label' => __('Disable author box', 'rehub_framework'),
						'description' => __('Disable author box after content from pages', 'rehub_framework'),
						'default' => '1',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_relative',
						'label' => __('Disable relative posts', 'rehub_framework'),
						'description' => __('Disable relative posts box after content from pages', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_enable_tag_relative',
						'label' => __('Enable relative posts by tags', 'rehub_framework'),
						'description' => __('By default, relative posts use category as base, you can switch to tags', 'rehub_framework'),
						'default' => '0',
					),						
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_feature_thumb',
						'label' => __('Disable top thumbnail on single page', 'rehub_framework'),
						'default' => '0',
					),						
					array(
						'type' => 'toggle',
						'name' => 'rehub_disable_comments',
						'label' => __('Disable standart comments', 'rehub_framework'),
						'default' => '0',
					),							
					array(
						'type' => 'textarea',
						'name' => 'rehub_widget_comments',
						'label' => __('Insert comments widget code', 'rehub_framework'),
						'description' => __('You can set here comments widget, for example, from disqus', 'rehub_framework'),
					),																											

				),
			),
		),
	),
	array(
		'title' => __('Ads Options', 'rehub_framework'),
		'name' => 'menu_9',
		'icon' => 'font-awesome:fa-bullhorn',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Ads code in header and footer', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'textarea',
						'name' => 'rehub_ads_top',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This banner code will be visible in header. Width of this zone depends on style of header (You can choose it in Header and menu tab)', 'rehub_framework'),
						'default' => '',
					),	
					array(
						'type' => 'textarea',
						'name' => 'rehub_ads_megatop',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This banner code will be visible before header.', 'rehub_framework'),
						'default' => '',
					),
					array(
						'type' => 'textarea',
						'name' => 'rehub_ads_infooter',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This banner code will be visible before footer', 'rehub_framework'),
						'default' => '',
					),																																				
				),
			),
			array(
				'type' => 'section',
				'title' => __('Global code for single page', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'textarea',
						'name' => 'rehub_single_after_title',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This code will be visible after title', 'rehub_framework'),
						'default' => '',
					),	
					array(
						'type' => 'textarea',
						'name' => 'rehub_single_before_post',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This code will be visible before post content', 'rehub_framework'),
						'default' => '',
					),	
					 array(
						'type' => 'notebox',
						'name' => 'rehub_single_before_post_note',
						'label' => __('Tips', 'rehub_framework'),
						'description' => __('You can wrap your code with &lt;div class=&quot;right_code&quot;&gt;your ads code&lt;/div&gt; if you want to add right float or &lt;div class=&quot;left_code&quot;&gt;your ads code&lt;/div&gt; for left float. Please, use square ads with width 250-300px for floated ads.', 'rehub_framework'),
						'status' => 'info',
					),																	
					array(
						'type' => 'textarea',
						'name' => 'rehub_single_code',
						'label' => __('Insert custom ads code', 'rehub_framework'),
						'description' => __('This code will be visible after post', 'rehub_framework'),
						'default' => '',
					),	
					array(
						'type' => 'textarea',
						'name' => 'rehub_shortcode_ads',
						'label' => __('Insert custom ads code for shortcode', 'rehub_framework'),
						'description' => __('You can insert this code in any place of content by shortcode [wpsm_ads1]', 'rehub_framework'),
					),
					array(
						'type' => 'textarea',
						'name' => 'rehub_shortcode_ads_2',
						'label' => __('Insert custom ads code for shortcode', 'rehub_framework'),
						'description' => __('You can insert this code in any place of content by shortcode [wpsm_ads2]', 'rehub_framework'),
					),																							
				),
			),																
			array(
				'type' => 'section',
				'title' => __('Global branded area', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'notebox',
						'name' => 'rehub_branded_banner_note',
						'label' => __('Note', 'rehub_framework'),
						'description' => __('Branded area displays after header. You can set direct link on image or insert any html code or shortcode', 'rehub_framework'),
						'status' => 'normal',							
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_branded_banner_image',
						'label' => __('Branded area', 'rehub_framework'),
						'description' => __('Set any custom code or link to image', 'rehub_framework'),
						'default' => '',
					),												
				),
			),

		),
	),
	array(
		'title' => __('Reviews', 'rehub_framework'),
		'name' => 'menu_10',
		'icon' => 'font-awesome:fa-signal',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Reviews, links, rating', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'select',
						'name' => 'type_user_review',
						'label' => __('Type of user ratings', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'simple',
								'label' => __('simple rating, no criterias', 'rehub_framework'),
							),
							array(
								'value' => 'full_review',
								'label' => __('full review with criterias and pros, cons', 'rehub_framework'),
							),	
							array(
								'value' => 'user',
								'label' => __('Show only user\'s reviews with criterias (don\'t show editor\'s review)', 'rehub_framework'),
							),									
							array(
								'value' => 'none',
								'label' => __('none', 'rehub_framework'),
							),																						
						),
						'default' => 'simple',
					),
					array(
						'type' => 'select',
						'name' => 'type_total_score',
						'label' => __('How to calculate total score of review', 'rehub_framework'),
						'items' => array(
							array(
							'value' => 'editor',
							'label' => __('based on editor\'s score', 'rehub_framework'),
							),
							array(
							'value' => 'average',
							'label' => __('average (editor\'s and user\'s)', 'rehub_framework'),
							),	
							array(
							'value' => 'user',
							'label' => __('based on user\'s', 'rehub_framework'),
							),																							
						),
						'dependency' => array(
							'field'    => 'type_user_review',
							'function' => 'rehub_framework_rev_type',
						),							
						'default' => 'average',
					),							
					array(
						'type' => 'textbox',
						'name' => 'rehub_user_rev_criterias',
						'label' => __('User review criteria names', 'rehub_framework'),
						'description' => __('Type with commas and no spaces. Example: Design,Price,Battery life', 'rehub_framework'),
						'dependency' => array(
							'field'    => 'type_user_review',
							'function' => 'user_rev_type',
						),							
					),
					array(
						'type' => 'select',
						'name' => 'type_schema_review',
						'label' => __('Type of schema for reviews', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'editor',
								'label' => __('Based on editor\'s review', 'rehub_framework'),
							),
							array(
								'value' => 'user',
								'label' => __('Based on user reviews', 'rehub_framework'),
							),																						
						),
						'default' => 'editor',
					),																						
					array(
						'type' => 'toggle',
						'name' => 'enable_btn_userreview',
						'label' => __('Enable plus and minus buttons', 'rehub_framework'),
						'description' => __('This will work only in user reviews', 'rehub_framework'),							
						'default' => '0',							
					),																							
					array(
						'type' => 'select',
						'name' => 'allowtorate',
						'label' => __('Allow to rate posts', 'rehub_framework'),
						'description' => __('Who can rate review posts?', 'rehub_framework'),
						'items' => array(
							array(
							'value' => 'guests',
							'label' => __('guests', 'rehub_framework'),
							),
							array(
							'value' => 'users',
							'label' => __('users', 'rehub_framework'),
							),
							array(
							'value' => 'guests_users',
							'label' => __('guests and users', 'rehub_framework'),
							),								
							),
						'default' => 'guests_users',
					),
					array(
						'type' => 'select',
						'name' => 'color_type_review',
						'label' => __('Color type of review box', 'rehub_framework'),
						'items' => array(
							array(
							'value' => 'simple',
							'label' => __('one color', 'rehub_framework'),
							),
							array(
							'value' => 'multicolor',
							'label' => __('multicolor', 'rehub_framework'),
							),								
						),
						'default' => 'simple',
					),						
					array(
						'type' => 'color',
						'name' => 'rehub_review_color',
						'label' => __('Default color for editor\'s review box and total score', 'rehub_framework'),
						'description' => __('Choose the background color or leave blank for default red color', 'rehub_framework'),	
						'format' => 'hex',
						'dependency' => array(
							'field'    => 'color_type_review',
							'function' => 'rehub_framework_rev_color_is_mono',
						),							
					),	
					array(
						'type' => 'color',
						'name' => 'rehub_review_color_user',
						'label' => __('Default color for user review box and user stars', 'rehub_framework'),
						'description' => __('Choose the background color or leave blank for default blue color', 'rehub_framework'),	
						'format' => 'hex',
						'dependency' => array(
							'field'    => 'color_type_review',
							'function' => 'rehub_framework_rev_color_is_mono',
						),							
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_replace_color',
						'label' => __('Replace colors by category color', 'rehub_framework'),
						'description' => __('Do you want to replace default colors of review box with custom color of category?', 'rehub_framework'),							
						'default' => '0',
						'dependency' => array(
							'field'    => 'color_type_review',
							'function' => 'rehub_framework_rev_color_is_mono',
						),							
					),	
					array(
						'type' => 'color',
						'name' => 'rehub_userreview_multicolor',
						'label' => __('Color for stars in comments (default is blue)', 'rehub_framework'),
						'format' => 'hex',
						'dependency' => array(
							'field'    => 'color_type_review',
							'function' => 'rehub_framework_rev_color_is_multi',
						),							
					),																		
				),
			),
			array(
				'type' => 'section',
				'title' => __('Add review fields to frontend form', 'rehub_framework'),
				'fields' => array(					
					array(
						'type' => 'textbox',
						'name' => 'rh_front_reviewform_id',
						'label' => __('Type form ID', 'rehub_framework'),
						'description' => __('Set form ID (RH Frontend publishing plugin) where you want to add review fields. You can download plugin in Rehub - Plugins tab. ', 'rehub_framework'),
						'default' => '',
					),		
					array(
						'type' => 'textbox',
						'name' => 'rh_front_review_fields',
						'label' => __('Type names of criterias', 'rehub_framework'),
						'description' => __('Type names of criterias for review form with commas without spaces', 'rehub_framework'),
						'default' => '',
					),																	
				),
			),		
		),
	),
	array(
		'title' => __('Affiliate', 'rehub_framework'),
		'name' => 'menu_aff',
		'icon' => 'font-awesome:fa-money',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Content Egg synchronization', 'rehub_framework'),
				'fields' => array(					
					array(
						'type' => 'multiselect',
						'name' => 'save_meta_for_ce',
						'label' => __('Save data from Content Egg to post offer section', 'rehub_framework'),
						'description' => __('This option will store data from Content Egg modules to main offer of post. Works only with enabled Content Egg plugin', 'rehub_framework'),	
						'items' => array(
							array(
								'value' => 'Amazon',
								'label' => 'Amazon',
							),	
							array(
								'value' => 'Ebay',
								'label' => 'Ebay',
							),	
							array(
								'value' => 'Zanox',
								'label' => 'Zanox',
							),
							array(
								'value' => 'Aliexpress',
								'label' => 'Aliexpress',
							),	
							array(
								'value' => 'CjProducts',
								'label' => 'CJ products',
							),
							array(
								'value' => 'AffilinetProducts',
								'label' => 'Affili.net',
							),
							array(
								'value' => 'Affiliatewindow',
								'label' => 'Affiliatewindow.com',
							),
							array(
								'value' => 'TradedoublerProducts',
								'label' => 'Tradedoubler.com products',
							),	
							array(
								'value' => 'Optimisemedia',
								'label' => 'Optimisemedia.com',
							),																				
							array(
								'value' => 'Linkshare',
								'label' => 'Linkshare',
							),	
							array(
								'value' => 'Shareasale',
								'label' => 'Shareasale',
							),
							array(
								'value' => 'Flipkart',
								'label' => 'Flipkart',
							),	
							array(
								'value' => 'PayTM',
								'label' => 'Paytm.com',
							),								
							array(
								'value' => 'AdmitadProducts',
								'label' => 'Admitad Products',
							),																
							array(
								'label' => 'AE: Amazon.com',
								'value' => 'AE__amazoncom',
							),
							array(
								'label' => 'AE: Amazon.de',
								'value' => 'AE__amazonde',
							),
							array(
								'label' => 'AE: Amazon.it',
								'value' => 'AE__amazonit',
							),
							array(
								'label' => 'AE: Amazon.fr',
								'value' => 'AE__amazonfr',
							),
							array(
								'label' => 'AE: Amazon.in',
								'value' => 'AE__amazonin',
							),	
							array(
								'label' => 'AE: Amazon.es',
								'value' => 'AE__amazones',
							),
							array(
								'label' => 'AE: Groupon US',
								'value' => 'AE__grouponus',
							),
							array(
								'label' => 'AE: Banggood',
								'value' => 'AE__banggood',
							),
							array(
								'label' => 'AE: Ebay.com',
								'value' => 'AE__ebaycom',
							),	
							array(
								'label' => 'AE: Ebay.de',
								'value' => 'AE__ebayde',
							),
							array(
								'label' => 'AE: Ebay.in',
								'value' => 'AE__ebayin',
							),
							array(
								'label' => 'AE: Ebay.es',
								'value' => 'AE__ebayes',
							),
							array(
								'label' => 'AE: Ebay.com.au',
								'value' => 'AE__ebaycomau',
							),
							array(
								'label' => 'AE: Booking.com',
								'value' => 'AE__booking',
							),	
							array(
								'label' => 'AE: Airbnb.com',
								'value' => 'AE__airbnbcom',
							),							
							array(
								'label' => 'AE: Etsy.com',
								'value' => 'AE__etsy',
							),	
							array(
								'label' => 'AE: Infibeam.com',
								'value' => 'AE__infibeam',
							),
							array(
								'label' => 'AE: Jabong.com',
								'value' => 'AE__jabongcom',
							),
							array(
								'label' => 'AE: Shopclues.com',
								'value' => 'AE__shopclues',
							),
							array(
								'label' => 'AE: Snapdeal.com',
								'value' => 'AE__snapdeal',
							),							
							array(
								'label' => 'AE: Bodybuilding.com',
								'value' => 'AE__bodybuildingcom',
							),							
							array(
								'label' => 'AE: Suppz.com',
								'value' => 'AE__suppzcom',
							),	
							array(
								'label' => 'AE: Wiggle.com',
								'value' => 'AE__wigglecom',
							),	
							array(
								'label' => 'AE: Ru.Iherb.com',
								'value' => 'AE__ruiherbcom',
							),
						),
						'default' => 'none',
					),	
					array(
						'type' => 'toggle',
						'name' => 'delete_meta_for_ce',
						'label' => __('Auto delete offer?', 'rehub_framework'),
						'description' => __('This option will automatically delete main post offer if Content Egg modules are empty. Be carefull if you have already offers in post offer section', 'rehub_framework'),							
						'default' => '0',
					),																
				),
			),	
			array(
				'type' => 'section',
				'title' => __('Other', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'enable_multioffer',
						'label' => __('Enable multi offer option', 'rehub_framework'),
						'description' => __('Use this if you want to add multi offers instead of single in Post Offer section', 'rehub_framework'),							
						'default' => '0',							
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_post_exclude_expired',
						'label' => __('Delete all expired offers', 'rehub_framework'),
						'description' => __('This will delete expired offers from archives', 'rehub_framework'),
						'default' => '0',							
					),						
					array(
						'type' => 'toggle',
						'name' => 'enable_brand_taxonomy',
						'label' => __('Enable brand(store) taxonomy for posts', 'rehub_framework'),
						'description' => __('When enabled, save permalinks in Settings - Permalinks', 'rehub_framework'),													
						'default' => '0',							
					),	
					array(
						'type' => 'textbox',
						'name' => 'rehub_deal_store_tag',
						'label' => __('Set custom taxonomy slug for brand. Update permalinks after this in Settings - permalinks', 'rehub_framework'),							
					),	
					array(
						'type' => 'toggle',
						'name' => 'enable_blog_posttype',
						'label' => __('Enable separate blog post type', 'rehub_framework'),
						'description' => __('When enabled, save permalinks in Settings - Permalinks', 'rehub_framework'),													
						'default' => '0',							
					),
					array(
						'type' => 'textbox',
						'name' => 'blog_posttype_slug',
						'label' => __('Set custom blog permalink slug for Blog. Update permalinks after this in Settings - permalinks', 'rehub_framework'),	
						'dependency' => array(
                        	'field' => 'enable_blog_posttype',
                        	'function' => 'vp_dep_boolean',
                        ),												
					),	
					array(
						'type' => 'textbox',
						'name' => 'blog_posttypecat_slug',
						'label' => __('Set custom blog permalink slug for Blog Category. Update permalinks after this in Settings - permalinks', 'rehub_framework'),	
						'dependency' => array(
                        	'field' => 'enable_blog_posttype',
                        	'function' => 'vp_dep_boolean',
                        ),												
					),	
					array(
						'type' => 'textbox',
						'name' => 'blog_posttypetag_slug',
						'label' => __('Set custom blog permalink slug for Blog Tag. Update permalinks after this in Settings - permalinks', 'rehub_framework'),	
						'dependency' => array(
                        	'field' => 'enable_blog_posttype',
                        	'function' => 'vp_dep_boolean',
                        ),												
					),													
					array(
						'type' => 'select',
						'name' => 'blog_archive_layout',
						'label' => __('Select Blog Archive Layout', 'rehub_framework'),
						'description' => __('Select what kind of post string layout you want to use for blog, archives', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'big_blog',
								'label' => __('Big images Blog Layout', 'rehub_framework'),
							),								
							array(
								'value' => 'list_blog',
								'label' => __('List Layout with left thumbnails', 'rehub_framework'),
							),	
							array(
								'value' => 'grid_blog',
								'label' => __('Grid layout', 'rehub_framework'),
							),
							array(
								'value' => 'gridfull_blog',
								'label' => __('Full width Grid layout', 'rehub_framework'),
							),																							
						),
						'default' => array(
							'list_blog',
						),
						'dependency' => array(
                        	'field' => 'enable_blog_posttype',
                        	'function' => 'vp_dep_boolean',
                        ),						
					),																											
					array(
						'type' => 'toggle',
						'name' => 'enable_adsense_opt',
						'label' => __('Enable adsense optimized layout for desktop', 'rehub_framework'),
						'description' => __('Use this only if you have adsense as main money income source', 'rehub_framework'),							
						'default' => '0',							
					),															
				),
			),						
		),
	),
	array(
		'title' => __('Localization', 'rehub_framework'),
		'name' => 'menu_loc',
		'icon' => 'font-awesome:fa-language',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('Localization', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'textbox',
						'name' => 'rehub_currency',
						'label' => __('Set symbol of main currency (example, $)', 'rehub_framework'),
					),
					array(
						'type' => 'select',
						'name' => 'price_pattern',
						'label' => __('Choose price pattern', 'rehub_framework'),
						'items' => array(
							array(
							'value' => 'us',
							'label' => __('USA. Example: 1000.00', 'rehub_framework'),
							),
							array(
							'value' => 'eu',
							'label' => __('EU. Example: 1000,00', 'rehub_framework'),
							),	
							array(
							'value' => 'in',
							'label' => __('IN. Example: 1,000.00', 'rehub_framework'),
							),															
						),
						'default' => 'us',
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_btn_text',
						'label' => __('Set text for button', 'rehub_framework'),
						'description' => __('It will be used on button for product reviews, top rating pages instead BUY THIS ITEM', 'rehub_framework'),
						'validation' => 'maxlength[14]',
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_mask_text',
						'label' => __('Set text for coupon mask', 'rehub_framework'),
						'description' => __('It will be used on coupon mask instead REVEAL COUPON', 'rehub_framework'),
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_btn_text_aff_links',
						'label' => __('Set text for button', 'rehub_framework'),
						'description' => __('It will be used on button for products with list of links instead CHOOSE OFFER.', 'rehub_framework'),
						'validation' => 'maxlength[14]',
					),	
					array(
						'type' => 'textbox',
						'name' => 'rehub_btn_text_best',
						'label' => __('Set text for button', 'rehub_framework'),
						'description' => __('It will be used on button for products with comparison list instead BEST PRICE.', 'rehub_framework'),
					),						
					array(
						'type' => 'textbox',
						'name' => 'rehub_readmore_text',
						'label' => __('Set text for read more link', 'rehub_framework'),
						'description' => __('It will be used instead READ MORE', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_choosedeal_text',
						'label' => __('Set text for deals list title', 'rehub_framework'),
						'description' => __('It will be used in list of offers instead CHOOSE YOUR DEAL', 'rehub_framework'),
					),	
					array(
						'type' => 'textbox',
						'name' => 'buy_best_text',
						'label' => __('Set text for comparison list layout', 'rehub_framework'),
						'description' => __('It will be used instead BUY FOR BEST PRICE', 'rehub_framework'),
					),																					
					array(
						'type' => 'textbox',
						'name' => 'rehub_review_text',
						'label' => __('Set text for full review link', 'rehub_framework'),
						'description' => __('It will be used in top review pages instead READ FULL REVIEW', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_search_text',
						'label' => __('Set text for Search placeholder', 'rehub_framework'),
						'description' => __('It will be used in default search form instead SEARCH', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_wherebuy_text',
						'label' => __('Set text for title before offer block in post', 'rehub_framework'),
						'description' => __('It will be used instead: Where to buy', 'rehub_framework'),
					),					
					array(
						'type' => 'textbox',
						'name' => 'rehub_commenttitle_text',
						'label' => __('Set text for comment title, when no comments', 'rehub_framework'),
						'description' => __('It will be used instead: We will be happy to see your thoughts', 'rehub_framework'),
					),							
					array(
						'type' => 'textbox',
						'name' => 'rehub_related_text',
						'label' => __('Set text for Related article title', 'rehub_framework'),
						'description' => __('It will be used instead Related Articles', 'rehub_framework'),
					),		
					array(
						'type' => 'textbox',
						'name' => 'rehub_userposts_text',
						'label' => __('Set text for User posts label in Profile', 'rehub_framework'),
						'description' => __('It will be used instead User Posts', 'rehub_framework'),
					),
					array(
						'type' => 'textbox',
						'name' => 'rehub_userdeals_text',
						'label' => __('Set text for User deals label in Profile', 'rehub_framework'),
						'description' => __('It will be used instead User deals', 'rehub_framework'),
					),																																
				),
			),
		),
	),
	array(
		'title' => __('User options', 'rehub_framework'),
		'name' => 'usersmenus',
		'icon' => 'font-awesome:fa-user',
		'controls' => array(
			array(
				'type' => 'section',
				'title' => __('BuddyPress and MyCred options', 'rehub_framework'),
				'fields' => array(					
					array(
						'type' => 'toggle',
						'name' => 'bp_redirect',
						'label' => __('Enable redirect to BP profiles?', 'rehub_framework'),
						'description' => __('By default, user link goes to author page. You can redirect all author links from posts to BuddyPress profiles', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'bp_full_width',
						'label' => __('Make BP pages full width?', 'rehub_framework'),
						'default' => '0',
					),					
					array(
						'type' => 'toggle',
						'name' => 'bp_enable_mycred_comment_badge',
						'label' => __('Enable badges from MyCred plugin in comments for Buddypress?', 'rehub_framework'),
						'description' => __('Can slow your activity pages', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'rh_enable_mycred_comment',
						'label' => __('Enable badges, points, ranks from MyCred plugin in regular comments?', 'rehub_framework'),
						'description' => __('Can slow your single pages', 'rehub_framework'),
						'default' => '0',
					),					
					array(
						'type' => 'toggle',
						'name' => 'bp_deactivateemail_confirm',
						'label' => __('Disable email activation in BP?', 'rehub_framework'),
						'description' => __('Use this only if you plan to to use BP Register page and deactivate email activation', 'rehub_framework'),
						'default' => '0',
					),																																																											
				),
			),			
			array(
				'type' => 'section',
				'title' => __('Options for User login popup', 'rehub_framework'),
				'fields' => array(
					 array(
						'type' => 'notebox',
						'name' => 'rehub_user_note',
						'label' => __('Note!', 'rehub_framework'),
						'description' => __('Please, read about user functions in our <a href="http://rehub.wpsoul.com/documentation/docs.html#user1" target="_blank">documentation</a>.', 'rehub_framework'),
						'status' => 'info',
					),						
					array(
						'type' => 'toggle',
						'name' => 'userlogin_enable',
						'label' => __('Enable user login modal?', 'rehub_framework'),
						'description' => __('If you disable this, user modal will not work', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'userpopup_xprofile',
						'label' => __('Add xprofile fields to register form?', 'rehub_framework'),
						'description' => __('Set additional fields in User - Profile fields. Works only with enabled Buddypress', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'userpopup_xprofile_hidename',
						'label' => __('Hide xprofile name field?', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
                        	'field' => 'userpopup_xprofile',
                        	'function' => 'vp_dep_boolean',
                        ),						
					),										
					array(
						'type' => 'textbox',
						'name' => 'custom_msg_popup',
						'label' => __('Add custom message', 'rehub_framework'),
						'description' => __('Add text or shortcode in registration popup', 'rehub_framework'),							
					),	
					array(
						'type' => 'textbox',
						'name' => 'custom_register_link',
						'label' => __('Add custom register link', 'rehub_framework'),
						'description' => __('Add custom link if you want to use custom register page instead of sign up in popup', 'rehub_framework'),							
					),									
					array(
						'type' => 'select',
						'name' => 'rehub_login_icon',
						'label' => __('Add additional login icon in header', 'rehub_framework'),
						'description' => __('You can also add login-register link to any place with shortcode [wpsm_user_modal]', 'rehub_framework'),
						'items' => array(
							array(
								'value' => 'no',
								'label' => __('No additional icon', 'rehub_framework'),
							),
							array(
								'value' => 'top',
								'label' => __('In top line', 'rehub_framework'),
							),
							array(
								'value' => 'menu',
								'label' => __('In main menu', 'rehub_framework'),
							),															
						),
							'default' => array(
							'no',
						),
					),							
					array(
						'type' => 'toggle',
						'name' => 'userlogin_captcha_enable',
						'label' => __('Enable google captcha in modal?', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'textbox',
						'name' => 'userlogin_gapi_sitekey',
						'label' => __('Google API Site Key', 'rehub_framework'),
						'description' => __('A Google API Site Key for activating captcha. Register your <a href="https://www.google.com/recaptcha/admin#list">reCAPTCHA here</a>. Will not work on local virtual servers', 'rehub_framework'),
						'dependency' => array(
                        	'field' => 'userlogin_captcha_enable',
                        	'function' => 'vp_dep_boolean',
                        ),							
					),	
					array(
						'type' => 'textbox',
						'name' => 'userlogin_gapi_secretkey',
						'label' => __('Google API Secret Key', 'rehub_framework'),
						'description' => __('A Google API Secret Key for activating captcha. Register your <a href="https://www.google.com/recaptcha/admin#list">reCAPTCHA here</a>', 'rehub_framework'),
						'dependency' => array(
                        	'field' => 'userlogin_captcha_enable',
                        	'function' => 'vp_dep_boolean',
                        ),						
					),
					array(
						'type' => 'toggle',
						'name' => 'userlogin_terms_enable',
						'label' => __('Enable terms and conditions in modal?', 'rehub_framework'),
						'default' => '0',
					),						
					array(
						'type' => 'select',
						'name' => 'userlogin_term_page',
						'label' => __('Select page with Terms and Conditions', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_pages',
								),
							),
						),	
						'dependency' => array(
                        	'field' => 'userlogin_terms_enable',
                        	'function' => 'vp_dep_boolean',
                        ),												
					),
					array(
						'type' => 'select',
						'name' => 'userlogin_profile_page',
						'label' => __('Select page for user profile', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_pages',
								),
							),
						),													
					),	
					array(
						'type' => 'select',
						'name' => 'userlogin_submit_page',
						'label' => __('Select page for user submit', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_pages',
								),
							),
						),													
					),		
					array(
						'type' => 'select',
						'name' => 'userlogin_edit_page',
						'label' => __('Select common post edit page', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_pages',
								),
							),
						),													
					),									
					array(
						'type' => 'toggle',
						'name' => 'remove_admin_bar',
						'label' => __('Disable admin bar for users?', 'rehub_framework'),
						'description' => __('Only admin can see admin bar', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'enable_comment_link',
						'label' => __('Enable link on user profile in comment?', 'rehub_framework'),
						'description' => __('Can slow a bit your site if you have many comments', 'rehub_framework'),
						'default' => '0',
					),					
					array(
						'type' => 'select',
						'name' => 'post_type_for_uu',
						'label' => __('Choose custom post type for UM', 'rehub_framework'),
						'description' => __('Choose custom post type which will show in profile (works with plugin Ultimate Member)', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value'  => 'rehub_get_cpost_type',
								),
							),
						),
						'default' => '',			
					),																																											
				),
			),
		),
	),
	array(
		'title' => __('Dynamic comparison', 'rehub_framework'),
		'name' => 'compare',
		'icon' => 'font-awesome:fa-database',
		'controls' => array(
			 array(
				'type' => 'notebox',
				'name' => 'rehub_user_note',
				'label' => __('Note!', 'rehub_framework'),
				'description' => __('Please, read about dynamic comparison in our <a href="http://rehub.wpsoul.com/documentation/docs.html#dynamicchart" target="_blank">documentation</a>.', 'rehub_framework'),
				'status' => 'info',
			),				
			array(
				'type' => 'section',
				'title' => __('Options for single group dynamic comparison', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'select',
						'name' => 'compare_page',
						'label' => __('Select page for comparison', 'rehub_framework'),
						'description' => __('Page must have top chart constructor template', 'rehub_framework'),
						'items' => array(
							'data' => array(
								array(
									'source' => 'function',
									'value' => 'vp_get_pages',
								),
							),
						),													
					),																				
				),
			),
			array(
				'type' => 'section',
				'title' => __('Options for multigroup dynamic comparison', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'compare_multicats_toggle',
						'label' => __('Enable Multicategory compare', 'rehub_framework'),
						'description' => __('Before set, please, create pages for each comparison group', 'rehub_framework'),
					),	
					array(
						'type' => 'textarea',
						'name' => 'compare_multicats_textarea',
						'label' => __('Assign categories to pages', 'rehub_framework'),
						'description' => __('Example: 1,2,3;Title;23, where 1,2,3 - category IDs, Title - a general name for category group, 23 - a page ID of comparison. You can add also custom taxonomy in the end. By default, categories will be used. Delimiter is ";"', 'rehub_framework'),
						'dependency' => array(
                        	'field' => 'compare_multicats_toggle',
                        	'function' => 'vp_dep_boolean',
                        ),							
					),																					
				),
			),	
			array(
				'type' => 'section',
				'title' => __('Common', 'rehub_framework'),
				'fields' => array(						
					array(
						'type' => 'toggle',
						'name' => 'compare_btn_single',
						'label' => __('Enable compare button in top of each single post?', 'rehub_framework'),
						'description' => __('You can also use [wpsm_compare_button] to insert button to any place', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'textbox',
						'name' => 'compare_btn_cats',
						'label' => __('Set ids of categories where to show button', 'rehub_framework'),
						'dependency' => array(
                        	'field' => 'compare_btn_single',
                        	'function' => 'vp_dep_boolean',
                        ),
					),					
					array(
						'type' => 'toggle',
						'name' => 'compare_disable_button',
						'label' => __('Disable button in right side', 'rehub_framework'),
						'description' => __('You can disable button with compare icon on right side of site. You can place this icon in header. Use Shop/Comparison header in theme option - header and menu - Header layout', 'rehub_framework'),
					),																					
				),
			),					
		),
	),
	array(
		'title' => __('Shop settings', 'rehub_framework'),
		'name' => 'menu_woo',
		'icon' => 'font-awesome:fa-barcode',
		'controls' => array(				
			array(
				'type' => 'section',
				'title' => __('Woocommerce settings', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'select',
						'name' => 'woo_columns',
						'label' => __('Set columns for woo archive', 'rehub_framework'),
						'items' => array(
							array(
							'value' => '3_col',
							'label' => __('3 columns', 'rehub_framework'),
							),
							array(
							'value' => '4_col',
							'label' => __('4 columns', 'rehub_framework'),
							),								
						),
						'default' => '3_col',
					),	
					array(
						'type' => 'select',
						'name' => 'woo_design',
						'label' => __('Set design of woo archive', 'rehub_framework'),
						'items' => array(
							array(
							'value' => 'simple',
							'label' => __('Columns', 'rehub_framework'),
							),
							array(
							'value' => 'grid',
							'label' => __('Grid', 'rehub_framework'),
							),	
							array(
							'value' => 'list',
							'label' => __('List', 'rehub_framework'),
							),														
						),
						'default' => 'simple',
					),
					array(
						'type' => 'select',
						'name' => 'woo_number',
						'label' => __('Set count of products in loop', 'rehub_framework'),
						'items' => array(
							array(
							'value' => '12',
							'label' => __('12', 'rehub_framework'),
							),
							array(
							'value' => '16',
							'label' => __('16', 'rehub_framework'),
							),								
						),
						'default' => '12',
					),	
					array(
						'type' => 'toggle',
						'name' => 'woo_single_sidebar',
						'label' => __('Enable sidebar on single product pages?', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'woo_archive_sidebar',
						'label' => __('Disable sidebar on archive product pages?', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'woo_rhcompare',
						'label' => __('Enable dynamic comparison?', 'rehub_framework'),
						'description' => __('You need also to enable and configure options in Theme option - Dynamic comparison and use [wpsm_woocharts] on page for comparison', 'rehub_framework'),
						'default' => '0',
					),														
					array(
						'type' => 'toggle',
						'name' => 'woo_btn_disable',
						'label' => __('Disable button in product loop?', 'rehub_framework'),
						'default' => '0',
					),
					array(
						'type' => 'toggle',
						'name' => 'woo_exclude_expired',
						'label' => __('Exclude expired products?', 'rehub_framework'),
						'description' => __('This option can slow your shop pages (if you have many products)', 'rehub_framework'),		
						'default' => '0',
					),														
					array(
						'type' => 'toggle',
						'name' => 'woo_thumb_enable',
						'label' => __('Show thumbs counter?', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'woo_enable_share',
						'label' => __('Enable share buttons on product page?', 'rehub_framework'),
						'default' => '0',
					),					
					array(
						'type' => 'select',
						'name' => 'woo_cart_place',
						'label' => __('Place for cart icon', 'rehub_framework'),
						'items' => array(
							array(
							'value' => '0',
							'label' => __('No place', 'rehub_framework'),
							),
							array(
							'value' => '1',
							'label' => __('In top line', 'rehub_framework'),
							),	
							array(
							'value' => '2',
							'label' => __('In main menu', 'rehub_framework'),
							),														
						),
						'default' => 'simple',
					),					
					array(
						'type' => 'toggle',
						'name' => 'rehub_woo_print',
						'label' => __('Enable print coupon function?', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'wooregister_xprofile',
						'label' => __('Add xprofile fields to register form?', 'rehub_framework'),
						'description' => __('Set additional fields in User - Profile fields. Works only with enabled Buddypress', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'wooregister_xprofile_hidename',
						'label' => __('Hide xprofile name field?', 'rehub_framework'),
						'default' => '0',
						'dependency' => array(
                        	'field' => 'wooregister_xprofile',
                        	'function' => 'vp_dep_boolean',
                        ),						
					),
					array(
						'type' => 'toggle',
						'name' => 'post_sync_with_user_location',
						'label' => __('Synchronize product and user location?', 'rehub_framework'),
						'description' => __('This works for Geo My wordpress plugin. If user has location and adds a product, product will have also his location automatically', 'rehub_framework'),
						'default' => '0',
					),						

				),
			),
			array(
				'type' => 'section',
				'title' => __('WC Vendor settings', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'upload',
						'name' => 'wcv_vendor_bg',
						'label' => __('Default background on store page', 'rehub_framework'),
						'description' => __('This background will be used if user don\'t specify background for shop. WC Vednor PRO has own default background in WC Vednor-PRO tab', 'rehub_framework'),
						'default' => '',
					),	
					array(
						'type' => 'upload',
						'name' => 'wcv_vendor_avatar',
						'label' => __('Default store logo on store page', 'rehub_framework'),
						'description' => __('This logo will be used if user don\'t specify logo for shop. Recommended size is 150x150', 'rehub_framework'),
						'default' => '',
					),	
					array(
						'type' => 'textbox',
						'name' => 'url_for_add_product',
						'label' => __('Add url of submit product page', 'rehub_framework'),
						'description' => __('Use it if you want to change default submit page of WC Vendor Free. You can use our RH Frontend PRO plugin to create frontend form for woocommerce. Find it in Rehub-Plugins', 'rehub_framework'),					
					),
					array(
						'type' => 'textbox',
						'name' => 'url_for_edit_product',
						'label' => __('Add url of edit product page', 'rehub_framework'),					
					),	
					array(
						'type' => 'toggle',
						'name' => 'rehub_wcv_related',
						'label' => __('Enable related products by vendor?', 'rehub_framework'),
						'default' => '0',
					),	
					array(
						'type' => 'toggle',
						'name' => 'rehub_wcv_dash_redirect',
						'label' => __('Redirect users after registration form to vendor dashboard?', 'rehub_framework'),
						'default' => '0',
					),																															
				),
			),			
			array(
				'type' => 'section',
				'title' => __('Easydigitaldownload settings', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'select',
						'name' => 'rehub_framework_edd_layout',
						'label' => __('Select Easydigitaldownload Layout', 'rehub_framework'),
						'description' => __('Select what layout you want to use for archives of easydigitaldownload plugin pages.', 'rehub_framework'),
						'items' => array(							
							array(
								'value' => 'rehub_framework_edd_list',
								'label' => __('List Layout with left thumbnails', 'rehub_framework'),
							),
							array(
								'value' => 'rehub_framework_edd_grid',
								'label' => __('Grid layout with sidebar', 'rehub_framework'),
							),	
							array(
								'value' => 'rehub_framework_edd_gridfull',
								'label' => __('Full width Grid layout', 'rehub_framework'),
							),																									
						),
						'default' => array(
							'rehub_framework_edd_gridfull',
						),
					),
					array(
						'type' => 'toggle',
						'name' => 'rehub_framework_edd_rating',
						'label' => __('Enable rating?', 'rehub_framework'),
						'description' => __('Enable built-in user rating system?', 'rehub_framework'),
						'default' => '1',
					),	
					array(
						'type' => 'toggle',
						'name' => 'rehub_framework_edd_counter',
						'label' => __('Enable counter for sales and downloads?', 'rehub_framework'),
						'description' => __('Enable counter in widget download details?', 'rehub_framework'),
						'default' => '1',
					),										
				),
			),
			array(
				'type' => 'section',
				'title' => __('Ecwid settings', 'rehub_framework'),
				'fields' => array(
					array(
						'type' => 'toggle',
						'name' => 'rehub_ecwid_enable',
						'label' => __('Enable ecwid store customization?', 'rehub_framework'),
						'default' => '0',
					),										
				),
			),
		),
	),
	array(
		'title' => __('Custom badges for posts', 'rehub_framework'),
		'name' => 'badges',
		'icon' => 'font-awesome:fa-certificate',
		'controls' => array(				
			array(
				'type' => 'section',
				'title' => __('First badge', 'rehub_framework'),
				'fields' => array(
				    array(
				        'type' => 'html',
				        'name' => 'admin_badge_preview_1',
				        'binding' => array(
				            'field'    => 'badge_label_1, badge_color_1',
				            'function' => 'admin_badge_preview_html',
				        ),
				    ),						
					array(
						'type' => 'textbox',
						'name' => 'badge_label_1',
						'label' => __('Label', 'rehub_framework'),
						'default' => __('Editor choice', 'rehub_framework'),
						'validation' => 'maxlength[20]',	
					),						
					array(
						'type' => 'color',
						'name' => 'badge_color_1',
						'label' => __('Color', 'rehub_framework'),
						'format' => 'hex',	
					),						
				),
			),
			array(
				'type' => 'section',
				'title' => __('Second badge', 'rehub_framework'),
				'fields' => array(
				    array(
				        'type' => 'html',
				        'name' => 'admin_badge_preview_2',
				        'binding' => array(
				            'field'    => 'badge_label_2, badge_color_2',
				            'function' => 'admin_badge_preview_html',
				        ),
				    ),						
					array(
						'type' => 'textbox',
						'name' => 'badge_label_2',
						'label' => __('Label', 'rehub_framework'),
						'default' => __('Best seller', 'rehub_framework'),
						'validation' => 'maxlength[20]',																
					),						
					array(
						'type' => 'color',
						'name' => 'badge_color_2',
						'label' => __('Color', 'rehub_framework'),
						'format' => 'hex',	
					),						
				),
			),	
			array(
				'type' => 'section',
				'title' => __('Third badge', 'rehub_framework'),
				'fields' => array(
				    array(
				        'type' => 'html',
				        'name' => 'admin_badge_preview_3',
				        'binding' => array(
				            'field'    => 'badge_label_3, badge_color_3',
				            'function' => 'admin_badge_preview_html',
				        ),
				    ),						
					array(
						'type' => 'textbox',
						'name' => 'badge_label_3',
						'label' => __('Label', 'rehub_framework'),
						'default' => __('Best value', 'rehub_framework'),
						'validation' => 'maxlength[20]',															
					),						
					array(
						'type' => 'color',
						'name' => 'badge_color_3',
						'label' => __('Color', 'rehub_framework'),
						'format' => 'hex',	
					),						
				),
			),
			array(
				'type' => 'section',
				'title' => __('Fourth badge', 'rehub_framework'),
				'fields' => array(
				    array(
				        'type' => 'html',
				        'name' => 'admin_badge_preview_4',
				        'binding' => array(
				            'field'    => 'badge_label_4, badge_color_4',
				            'function' => 'admin_badge_preview_html',
				        ),
				    ),						
					array(
						'type' => 'textbox',
						'name' => 'badge_label_4',
						'label' => __('Label', 'rehub_framework'),
						'default' => __('Best price', 'rehub_framework'),
						'validation' => 'maxlength[20]',								
					),						
					array(
						'type' => 'color',
						'name' => 'badge_color_4',
						'label' => __('Color', 'rehub_framework'),
						'format' => 'hex',	
					),						
				),
			),											
		),
	),
);

/**
 *EOF
 */