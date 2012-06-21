<?php

/**
 * @class Handles bootstrapping basic actions
 */
class WCJDInitialiser {

    private $admin;

    /**
     * Add actions depending on current state.
     */
    public function __construct() {

        if (WCJDStates::admin()) {

            // Provide message to admin if WooCommerce is not active.
            if (!WCJDStates::wooCommercePresent()) {
                add_action('admin_notices', array('WCJDMessages', 'showWooCommerceNotLoadedMessage'));
                return;
            }

            $this->admin = new WCJDAdmin();
            add_action('woocommerce_product_options_general_product_data', array(&$this->admin, 'editProduct'), 10, 2);
            add_action('woocommerce_process_product_meta', array(&$this->admin, 'saveProduct'), 10, 2);
        } else {
            add_action('plugins_loaded', array(&$this, 'initialiseFrontEnd'));
        }
    }

    /**
     * Initialise front end actions
     */
    public function initialiseFrontEnd() {
        $this->product = new WCJDProduct();

        add_action('wp_print_scripts', array(&$this->product, 'addAudioPreviewResources'));

        // Remove undesired thumbnail
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        add_action('woocommerce_before_shop_loop_item_title', array(&$this->product, 'displayAudioPreview'), 10, 2);
    }
}
