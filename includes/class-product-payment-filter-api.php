<?php

class WC_Payment_Gateway_Filter_API {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_api_routes'));
    }

    public function register_api_routes() {
        register_rest_route('wc-payment-gateway-filter/v1', '/update-settings', array(
            'methods' => 'POST',
            'callback' => array($this, 'update_settings'),
            'permission_callback' => array($this, 'check_permission'),
        ));
    }

    public function check_permission($request) {
        $user = wp_authenticate($request->get_header('PHP_AUTH_USER'), $request->get_header('PHP_AUTH_PW'));

        if (is_wp_error($user)) {
            return false;
        }

        return user_can($user, 'manage_options');
    }

    public function update_settings($request) {
        $params = $request->get_params();
        
        if (!isset($params['products']) || !is_array($params['products'])) {
            return new WP_Error('invalid_data', 'Invalid data format', array('status' => 400));
        }

        $settings = array();
        foreach ($params['products'] as $product) {
            if (isset($product['id']) && isset($product['hidden_methods']) && is_array($product['hidden_methods'])) {
                $settings[] = array(
                    'product' => $product['id'],
                    'hidden_payment_fields' => $product['hidden_methods']
                );
            }
        }

        // Update the ACF field
        update_field('payment_method_filter_products', $settings, 'option');

        return new WP_REST_Response(array('message' => 'Settings updated successfully'), 200);
    }
}