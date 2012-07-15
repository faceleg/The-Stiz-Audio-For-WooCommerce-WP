<?php
/**
 * Used to display admin messages to the user
 */
class WCJDMessages {

    /**
     * Display error message to user explaining that this plugin cannot be used without the WooCommerce plugin.
     */
    public static function showWooCommerceNotLoadedMessage() {
        $message = 'The Stiz - Audio for WooCommerce requires the WooCommerce plugin.';
        include WCJD_ROOT.'/views/messages/error.php';
    }
}
