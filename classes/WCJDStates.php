<?php
class WCJDStates {

    /**
     * Check if current user has admin rights.
     * @return boolean True if current user has admin rights.
     */
    public static function admin() {
        return is_admin();
    }

    /**
     * Check for the presence of the WooCommerce plugin.
     * @return boolean True if WooCommerce has been loaded.
     */
    public static function wooCommercePresent() {
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
    }

    /**
     * Determine whether the current request is a media library request initiated from this plugin.
     * @return {boolean} True if the current request is a media library request initiated from this plugin.
     */
    public static function ownMediaLibraryRequest() {
        global $pagenow;

        if ($pagenow !== 'media-upload.php') {
            return false;
        }

        if (!isset($_GET['wcjd'])){
            return false;
        }

        if (!$_GET['wcjd']) {
            return false;
        }

        return true;
    }
}
