<?php

class WCJDOptions {

    const OPTIONS = 'wcjd-options';
    const HIDE_THUMBNAILS = 'wcjd-options-hide-thumbnails';
    const USE_CUSTOM_CSS = 'wcjd-options-use-custom-css';
    const CUSTOM_CSS = 'wcjd-options-custom-css';
    const USE_CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-use-custom-media-element-css';
    const CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-custom-media-element-css';

    // Player initialistion options
    const PLAYER_WIDTH = 'audioWidth';
    const PLAYER_HEIGHT = 'audioHeight';
    const PLAYER_POSITION = 'wcjd-options-player-position';

    // Values
    const DISPLAY_ABOVE_HEADING = 'wcjd-player-above-heading';
    const DISPLAY_BELOW_HEADING = 'wcjd-player-below-heading';

    const UPLOAD_DIRECTORY_PATH_SEGMENT = 'woocommerce-jive-dig-audio-preview-uploads';

    private $options = false;

    public function __construct() {
        $this->options = $this->load();
    }

    public static function downloadDirectory($file = null) {
        $uploadDirectory = wp_upload_dir();
        return $uploadDirectory['basedir'] . '/' . self::UPLOAD_DIRECTORY_PATH_SEGMENT . '/' . $file;
    }

    private function load() {
        $options = get_option(self::OPTIONS);
        if(!is_array($options)) {
            $options = array(
                self::HIDE_THUMBNAILS => '1',
                self::USE_CUSTOM_CSS => '1',
                self::CUSTOM_CSS => $this->defaultCss(),
                self::USE_CUSTOM_MEDIA_ELEMENT_CSS => '1',
                self::CUSTOM_MEDIA_ELEMENT_CSS => $this->defaultMediaElementCss(),
                self::PLAYER_HEIGHT => '30',
                self::PLAYER_WIDTH => '400',
                self::PLAYER_POSITION => self::DISPLAY_ABOVE_HEADING
            );
            update_option(self::OPTIONS, $options);
        }
        return $options;
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update_option(self::OPTIONS, $_POST);
            // Reload options
            $this->load();
        }
    }

    public function getOption($key) {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    public function hideThumbnails() {
        return $this->getOption(self::HIDE_THUMBNAILS);
    }

    public function useCustomMediaElementCss() {
        return $this->getOption(self::USE_CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function customMediaElementCss() {
        return $this->getOption(self::CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function defaultMediaElementCss() {
        return file_get_contents(WCJD_ROOT.'/mediaelement-default/mediaelementplayer.css');
    }

    public function defaultMediaElementSingleButtonCss () {
        return file_get_contents(WCJD_ROOT.'/mediaelement-single-button/style.css');
    }

    public function useCustomCss() {
        return $this->getOption(self::USE_CUSTOM_CSS);
    }

    public function customCss() {
        return $this->getOption(self::CUSTOM_CSS);
    }

    public function defaultCss() {
        return file_get_contents(WCJD_ROOT.'/css/custom.css');
    }

    public function playerHeight() {
        return $this->getOption(self::PLAYER_HEIGHT);
    }

    public function playerWidth() {
        return $this->getOption(self::PLAYER_WIDTH);
    }

    public function playerPosition() {
        return $this->getOption(self::PLAYER_POSITION);
    }
}
