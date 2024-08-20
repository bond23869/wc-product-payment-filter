<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Payment_Method_Filter {
    public function __construct() {
        add_filter('woocommerce_available_payment_gateways', array($this, 'filter_payment_gateways'));
    }

    public function filter_payment_gateways($available_gateways) {
        if (is_admin() || !is_checkout()) {
            return $available_gateways;
        }

        $cart_items = WC()->cart->get_cart();
        $settings = get_field('payment_method_filter_products', 'option') ?? [];

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
}