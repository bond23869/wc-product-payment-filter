<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Payment_Method_Filter {
    public function __construct() {
        add_filter('woocommerce_available_payment_gateways', array($this, 'filter_payment_gateways'));
        add_action('acf/init', array($this, 'add_options_page'));
        add_filter('acf/load_field/name=hidden_payment_fields', array($this, 'load_payment_gateways'));
        add_action('acf/init', array($this, 'register_acf_fields'));
    }

    public function filter_payment_gateways($available_gateways) {
        if (is_admin()) {
            return $available_gateways;
        }

        if(!WC()->cart) {
            return $available_gateways;
        }

        $cart_items = WC()->cart->get_cart();
        $settings = get_field('payment_method_filter_products', 'option');

        if (!$settings) {
            return $available_gateways;
        }

        foreach ($cart_items as $cart_item) {
            $product_id = $cart_item['product_id'];
            foreach ($settings as $row) {
                if ($row['product']->ID == $product_id) {
                    foreach ($row['hidden_payment_fields'] as $gateway_id) {
                        unset($available_gateways[$gateway_id]);
                    }
                }
            }
        }

        return $available_gateways;
    }

    public function add_options_page() {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title' => 'Payment Method Filter',
                'menu_title' => 'Payment Method Filter',
                'parent_slug' => 'woocommerce',
                'capability' => 'manage_woocommerce',
                'menu_slug' => 'payment-method-filter',
            ));
        }
    }

    public function load_payment_gateways($field) {
        $gateways = WC()->payment_gateways->payment_gateways();
        $field['choices'] = array();
        foreach ($gateways as $gateway) {
            if($gateway->enabled == 'yes'){
                $field['choices'][$gateway->id] = $gateway->get_title();
            }
        }
        return $field;
    }

    public function register_acf_fields() {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_payment_method_filter',
                'title' => 'Payment Method Filter',
                'fields' => array(
                    array(
                        'key' => 'field_payment_method_filter_products',
                        'label' => 'Payment method filter products',
                        'name' => 'payment_method_filter_products',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'table',
                        'button_label' => 'Add Row',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_product',
                                'label' => 'Product',
                                'name' => 'product',
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
                                'taxonomy' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'return_format' => 'object',
                                'ui' => 1,
                            ),
                            array(
                                'key' => 'field_hidden_payment_fields',
                                'label' => 'Hidden Payment fields',
                                'name' => 'hidden_payment_fields',
                                'type' => 'checkbox',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(),
                                'allow_custom' => 0,
                                'default_value' => array(),
                                'layout' => 'vertical',
                                'toggle' => 0,
                                'return_format' => 'value',
                                'save_custom' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'payment-method-filter',
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
            ));
        }
    }
}