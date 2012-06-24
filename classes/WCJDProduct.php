<?php
class WCJDProduct {

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function addAudioPreviewResources() {

        // Media Element JavaScript
        wp_enqueue_script('media-element', plugins_url('javascript/media-element/mediaelement-and-player.min.js', dirname(__FILE__)), 'jquery', '2.9.1');
        wp_enqueue_script('media-element-initialisation', plugins_url('javascript/media-element/initialisation.js', dirname(__FILE__)), 'media-element', '2.9.1', true);

        // Media Element CSS
        // If the user has not chosen to use custom media element CSS, or they have but haven't actually modified the CSS, output the default style.
        $useCustomMediaElementCss = $this->options->useCustomMediaElementCss() && ($this->options->defaultMediaElementCss() !== $this->options->customMediaElementCss());
        if ($useCustomMediaElementCss) {
            add_action('wp_head', array(&$this, 'outputCustomMediaElementCss'));
        } else {
            wp_register_style('media-element-style', plugins_url('woocommerce-jive-dig-audio-preview/css/mediaelementplayer.css', dirname(__FILE___)), false, '2.9.1');
            wp_enqueue_style('media-element-style');
        }
        // Custom CSS
        $useCustomCss = $this->options->useCustomCss();
        if ($useCustomCss) {
            add_action('wp_head', array(&$this, 'outputCustomCss'));
        }
    }

    public function outputCustomMediaElementCss() {
        $css = WCJDCSS::minify($this->options->customMediaElementCss());
        include WCJD_ROOT.'/views/head/css/custom-media-element.php';
    }

    public function outputCustomCss() {
        $useCustom = $this->options->defaultCss() !== $this->options->customCss();
        $css = $this->options->defaultCss();
        if ($useCustom) {
            $css = $this->options->customCss();
        }
        $css = WCJDCSS::minify($css);
        include WCJD_ROOT.'/views/head/css/custom.php';
    }

    public function displayAudioPreview() {
        global $product;
        $previewUrl = get_post_meta($product->id, WCJDWooCommerceAdminAdditions::PREVIEW_URL_KEY, true);
        include WCJD_ROOT.'/views/product/audio-preview.php';
    }

    /**
     * Output HTML for product information button.
     */
    public function informationButton() {
        $productUrl = get_permalink($product->id);
        include WCJD_ROOT.'/views/product/information.php';
    }

    public function displayRating() {
        global $product;
        $rating = $product->get_rating_html('sidebar');
// var_dump($rating, get_class($product));
        // die($rating);
        include WCJD_ROOT.'/views/product/rating.php';
    }

    public function addProductsWrapOpen() {
        echo '<div class="wcjd-products">';
    }

    public function addProductsWrapClose() {
        echo '</div>';
    }

    /**
     * Output HTML for the product author's name. Use display_name, nickname & user_login in that order.
     */
    public function displayAuthor() {
        global $product;

        $authorID = $product->get_post_data()->post_author;
        $authorDisplayName = get_the_author_meta('display_name', $authorID);
        $authorUsername = get_the_author_meta('user_login', $authorID);
        $authorNickname = get_the_author_meta('nickname', $authorID);

        $authorName = $authorDisplayName ?: $authorNickname ?: $authorUsername;
        include WCJD_ROOT.'/views/product/author.php';
    }

    /**
     * Output HTML for product categories.
     */
    public function displayCategories() {
        global $product;

        $categories = $product->get_categories();
        if (!$categories) {
            return;
        }
        include WCJD_ROOT.'/views/product/categories.php';
    }

}
