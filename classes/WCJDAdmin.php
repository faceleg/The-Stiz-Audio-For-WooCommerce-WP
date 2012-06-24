<?php
/**
 * Handle displaying & saving custom admin data.
 */
class WCJDAdmin {

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function setupMenu() {
        add_options_page('WC Jive Dig Audio Preview', 'WC Jive Dig Audio Preview', 1, 'WCJD', array(&$this, 'adminIndex'));
    }

    public function adminIndex() {
        // Include jQuery UI
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-cookie', plugins_url('javascript/jquery.cookie.js', dirname(__FILE__)), 'jquery', '1.0.0');

        // CSS
        wp_register_style('jquery-ui-smoothness', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css', false, '1.8.16');
        wp_enqueue_style('jquery-ui-smoothness');

        wp_register_style('wcjd-admin-styles', plugins_url('css/admin/style.css', dirname(__FILE__)), false, '1.0.0');
        wp_enqueue_style('wcjd-admin-styles');

        include WCJD_ROOT.'/views/admin/index.php';
    }
}
