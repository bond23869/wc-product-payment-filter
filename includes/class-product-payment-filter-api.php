<?php

class WC_Payment_Gateway_Filter_API {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_api_routes'));
    }

    public function register_api_routes() {
        register_rest_route('wc-payment-gateway-filter/v1', '/add-product', array(
            'methods' => 'POST',
            'callback' => array($this, 'add_product'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        register_rest_route('wc-payment-gateway-filter/v1', '/delete-product/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_product'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        register_rest_route('wc-payment-gateway-filter/v1', '/get-settings', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_settings'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        register_rest_route('wc-payment-gateway-filter/v1', '/get-payment-methods', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_payment_methods'),
            'permission_callback' => array($this, 'check_permission'),
        ));
    }

    public function check_permission($request) {
        // Check if the Authorization header is present
        $auth_header = $request->get_header('Authorization');
        if (empty($auth_header)) {
            return false;
        }
    
        // Extract credentials from the Authorization header
        list($type, $credentials) = explode(' ', $auth_header, 2);
        if (strtolower($type) !== 'basic') {
            return false;
        }
    
        $credentials = base64_decode($credentials);
        list($username, $password) = explode(':', $credentials, 2);
    
        // Authenticate the user
        $user = wp_authenticate($username, $password);
    
        if (is_wp_error($user)) {
            return false;
        }
    
        // Check if the user has the required capability
        return user_can($user, 'manage_options');
    }

    public function add_product($request) {
        $params = $request->get_params();
        
        if (!isset($params['product_id']) || !isset($params['hidden_methods']) || !is_array($params['hidden_methods'])) {
            return new WP_Error('invalid_data', 'Invalid data format', array('status' => 400));
        }

        $current_settings = get_field('payment_method_filter_products', 'option') ?: array();

        $product_id = $params['product_id'];
        $hidden_methods = $params['hidden_methods'];

        // Find if the product already exists in the settings
        $existing_product_key = array_search($product_id, array_column($current_settings, 'product'));

        if ($existing_product_key !== false) {
            // Update existing product
            $current_settings[$existing_product_key]['hidden_payment_fields'] = $hidden_methods;
        } else {
            // Add new product
            $current_settings[] = array(
                'product' => $product_id,
                'hidden_payment_fields' => $hidden_methods
            );
        }

        // Update the ACF field
        update_field('payment_method_filter_products', $current_settings, 'option');

        return new WP_REST_Response(array('message' => 'Product added/updated successfully'), 200);
    }

    public function delete_product($request) {
        $product_id = $request['id'];

        $current_settings = get_field('payment_method_filter_products', 'option') ?: array();

        // Find and remove the product
        $current_settings = array_filter($current_settings, function($item) use ($product_id) {
            return $item['product'] != $product_id;
        });

        // Re-index the array
        $current_settings = array_values($current_settings);

        // Update the ACF field
        update_field('payment_method_filter_products', $current_settings, 'option');

        return new WP_REST_Response(array('message' => 'Product removed successfully'), 200);
    }

    public function get_settings($request) {
        $settings = get_field('payment_method_filter_products', 'option') ?: array();
        return new WP_REST_Response($settings, 200);
    }

    public function get_payment_methods($request) {
        // Ensure WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return new WP_Error('woocommerce_required', 'WooCommerce is not active', array('status' => 400));
        }

        // Get all payment gateways
        $payment_gateways = WC()->payment_gateways->payment_gateways();

        $active_methods = array();

        foreach ($payment_gateways as $gateway) {
            if ($gateway->enabled == 'yes') {
                $active_methods[] = array(
                    'id' => $gateway->id,
                    'title' => $gateway->get_title(),
                    'description' => $gateway->get_description(),
                    'method_title' => $gateway->get_method_title(),
                );
            }
        }

        return new WP_REST_Response($active_methods, 200);
    }
}