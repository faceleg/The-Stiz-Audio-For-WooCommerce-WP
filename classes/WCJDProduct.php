<?php
class WCJDProduct {

    public function addAudioPreviewResources() {

        // JavaScripts
        wp_enqueue_script('media-element', plugins_url('javascript/media-element/mediaelement-and-player.min.js', dirname(__FILE__)), 'jquery', '2.9.1');
        wp_enqueue_script('media-element-initialisation', plugins_url('javascript/media-element/initialisation.js', dirname(__FILE__)), 'media-element', '2.9.1', true);

        // CSS
        // @todo get CSS from DB
        // @todo create admin page allowing user to modify CSS
        wp_register_style('media-element-style', plugins_url('css/mediaelementplayer.css', dirname(__FILE__)), false, '2.9.1');
        wp_enqueue_style('media-element-style');
    }

    public function displayAudioPreview() {
        global $product;
        $previewUrl = get_post_meta($product->id, WCJDAdmin::PREVIEW_URL_KEY, true);
        include WCJD_ROOT.'/views/product/audio-preview.php';
    }
}
