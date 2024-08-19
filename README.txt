=== Product Payment Filter for WooCommerce ===
Contributors: jankotnik
Donate link: https://example.com/
Tags: woocommerce, payment, filter, product, checkout
Requires at least: 5.0
Tested up to: 5.8
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Customize WooCommerce payment options by hiding specific payment methods for selected products in the cart.

== Description ==

The Product Payment Filter for WooCommerce plugin allows you to selectively hide payment methods based on the products in the customer's cart. This gives you greater control over your checkout process and can be useful for various business scenarios.

Key features:

* Selectively hide payment methods for specific products
* Easy-to-use settings in the WooCommerce admin area
* RESTful API for programmatic settings management
* Dynamically updates to reflect currently active payment gateways

This plugin is ideal for store owners who need to restrict payment options for certain products due to shipping limitations, product characteristics, or business rules.

== Installation ==

1. Upload the `product-payment-filter` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to WooCommerce > Payment Method Filter to configure your settings

== Frequently Asked Questions ==

= Does this plugin work with all WooCommerce payment gateways? =

Yes, this plugin works with all active WooCommerce payment gateways. It dynamically updates to reflect your currently enabled payment methods.

= Can I programmatically update the settings? =

Yes, the plugin provides a RESTful API endpoint for updating settings. You'll need to use WordPress application passwords for authentication.

= What happens if a payment method is disabled after I've set up filters? =

The plugin automatically adjusts to only consider currently active payment methods. If a payment method is disabled, it will be removed from your filter settings.

== Screenshots ==

1. The Payment Method Filter settings page in the WooCommerce admin area.
2. Example of a checkout page with filtered payment methods.

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of the Product Payment Filter for WooCommerce plugin.

== API Usage ==

To update settings via the API, send a POST request to:
`https://your-site.com/wp-json/wc-payment-gateway-filter/v1/update-settings`

The request body should be in JSON format:

```json
{
  "products": [
    {
      "id": 123,
      "hidden_methods": ["cod", "bacs"]
    },
    {
      "id": 456,
      "hidden_methods": ["paypal"]
    }
  ]
}
```

Remember to use WordPress application passwords for authentication.

== Support ==

For support queries, please visit our website at https://example.com/support or contact us through the WordPress.org plugin support forums.