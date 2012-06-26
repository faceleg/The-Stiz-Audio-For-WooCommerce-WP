<?php

/**
 * @class Handles bootstrapping basic actions
 */
class WCJDInitialiser {

    private $wooCommerceAdminAdditions;
    private $admin;

    private $product;

    /**
     * Add actions depending on current state.
     */
    public function __construct() {

        $this->options = new WCJDOptions();

        if (WCJDStates::admin()) {

            // Provide message to admin if WooCommerce is not active.
            if (!WCJDStates::wooCommercePresent()) {
                add_action('admin_notices', array('WCJDMessages', 'showWooCommerceNotLoadedMessage'));
                return;
            }

            // Add Woo Commerce product admin page additions
            $this->wooCommerceAdminAdditions = new WCJDWooCommerceAdminAdditions();
            add_action('woocommerce_product_options_general_product_data', array(&$this->wooCommerceAdminAdditions, 'editProduct'), 1, 2);
            add_action('woocommerce_process_product_meta', array(&$this->wooCommerceAdminAdditions, 'saveProduct'), 10, 2);

            add_filter('upload_dir', array(&$this->wooCommerceAdminAdditions, 'previewFileUploadDirectory'));
            add_filter('media_upload_tabs', array(&$this->wooCommerceAdminAdditions, 'limitMediaLibraryTabs'));
            add_filter('attachment_fields_to_edit', array(&$this->wooCommerceAdminAdditions, 'limitMediaLibraryEditFields'), 10, 2 );
            add_filter('post_mime_types', array(&$this->wooCommerceAdminAdditions, 'filterPostMimeTypes'));
            add_action('media_upload_'.WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT, array(&$this->wooCommerceAdminAdditions, 'uploadPreviewFile'));
            add_filter('posts_where', array(&$this->wooCommerceAdminAdditions, 'limitMediaLibraryItems'), 10, 2 );

            // Plugin admin page
            $this->admin = new WCJDAdmin($this->options);
            add_action('admin_menu', array(&$this->admin, 'setupMenu'));
        } else {
            add_action('plugins_loaded', array(&$this, 'initialiseFrontEnd'));
        }
    }

    /**
     * Initialise front end actions
     */
    public function initialiseFrontEnd() {
        $this->product = new WCJDProduct($this->options);

        add_action('wp_print_scripts', array(&$this->product, 'addAudioPreviewResources'));

        add_action('woocommerce_before_shop_loop', array(&$this->product, 'addProductsWrapOpen'));

        // Remove undesired thumbnail
        if ($this->options->hideThumbnails()) {
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        }
        // add_action('woocommerce_before_shop_loop_item', array(&$this->product, 'displayRating'), 10);
        if ($this->options->playerPosition() === WCJDOptions::DISPLAY_ABOVE_HEADING) {
           add_action('woocommerce_before_shop_loop_item', array(&$this->product, 'displayAudioPreview'), 10);
        } else {
            add_action('woocommerce_after_shop_loop_item', array(&$this->product, 'displayAudioPreview'), 10);
        }

        add_action('woocommerce_after_shop_loop_item', array(&$this->product, 'displayAuthor'), 10);
        add_action('woocommerce_after_shop_loop_item', array(&$this->product, 'displayCategories'), 11);
        add_action('woocommerce_after_shop_loop_item', array(&$this->product, 'informationButton'), 9);

        add_action('woocommerce_after_shop_loop', array(&$this->product, 'addProductsWrapClose'));
    }
}
