<?php

add_action( 'acf/include_fields', function() {


    if (!defined('ABSPATH')) {
        exit; // Exit if accessed directly
    }

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_66c22bc2a388b',
	'title' => 'Payment Method Filter',
	'fields' => array(
		array(
			'show_column_filter' => false,
			'allow_bulkedit' => false,
			'allow_quickedit' => false,
			'show_column' => false,
			'show_column_weight' => 1000,
			'show_column_sortable' => false,
			'key' => 'field_66c22bc278708',
			'label' => 'Payment method filter products',
			'name' => 'payment_method_filter_products',
			'aria-label' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'table',
			'pagination' => 0,
			'min' => 0,
			'max' => 0,
			'collapsed' => '',
			'button_label' => 'Add Row',
			'rows_per_page' => 20,
			'sub_fields' => array(
				array(
					'show_column_filter' => false,
					'allow_bulkedit' => false,
					'allow_quickedit' => false,
					'show_column' => false,
					'show_column_weight' => 1000,
					'show_column_sortable' => false,
					'key' => 'field_66c22cee78709',
					'label' => 'Product',
					'name' => 'product',
					'aria-label' => '',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'product',
					),
					'post_status' => '',
					'taxonomy' => '',
					'return_format' => 'object',
					'multiple' => 0,
					'allow_null' => 0,
					'ui' => 1,
					'parent_repeater' => 'field_66c22bc278708',
				),
				array(
					'show_column_filter' => false,
					'allow_bulkedit' => false,
					'allow_quickedit' => false,
					'show_column' => false,
					'show_column_weight' => 1000,
					'show_column_sortable' => false,
					'key' => 'field_66c2325b7870a',
					'label' => 'Hidden Payment fields',
					'name' => 'hidden_payment_fields',
					'aria-label' => '',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'cod' => 'Utánvétes fizetés<span class=\'\'>1,49 &euro;</span>',
						'stripe' => 'Credit / Debit Card<span class=\'\'>0,00&euro;</span>',
						'ppcp' => 'PayPal<span class=\'\'>0,00&euro;</span>',
					),
					'default_value' => array(
					),
					'return_format' => 'value',
					'allow_custom' => 0,
					'layout' => 'vertical',
					'toggle' => 0,
					'save_custom' => 0,
					'custom_choice_button_text' => 'Add new choice',
					'parent_repeater' => 'field_66c22bc278708',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-checkout',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

