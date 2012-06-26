<?php
class WCJDServeAudio {

    private $request;
    private $file = null;

    const KEY = 'vMfMDP2o4G56Q7m';

    public function __construct($request) {
        $this->request = $request;
    }

    public static function encode($url) {

        $baseUrl = plugins_url('preview.php', dirname(__FILE__));
        $nonce = wp_create_nonce(__FILE__);
        $audioFile = WCJDEncryption::encrypt($url, self::KEY);

        return "{$baseUrl}?nonce={$nonce}&audio={$audioFile}";
    }

    /**
     * Converts a URI like /wordpress/wp-content/uploads/woocommerce-jive-dig-audio-preview-uploads/2012/06/Damn-It-Feels-Good-To-Be-A-Gangsta.mp3
     * to something like: /var/www/site.co.nz/public/wordpress/wp-content/uploads/woocommerce-jive-dig-audio-preview-uploads/2012/06/Damn-It-Feels-Good-To-Be-A-Gangsta.mp3
     * @param  {String} $file The public URI to be converted.
     * @return {String} The private path to the URI's file.
     */
    private static function convertPublicPathToPrivate($file) {
        $publicPathPortion = str_replace('http://'.$_SERVER['SERVER_NAME'], '', home_url());
        $privatePathPortion = substr(ABSPATH, 0, strpos(ABSPATH, $publicPathPortion));
        return $privatePathPortion.$file;
    }

    public function validRequest() {

        if (!isset($this->request['nonce'])) {
            return false;
        }

        if (!wp_verify_nonce($this->request['nonce'], __FILE__)) {
            return false;
        }

        if (!isset($_SERVER['HTTP_REFERER'])) {
            return false;
        }

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https://' : 'http://';
        if (strpos($_SERVER['HTTP_REFERER'], $protocol.$_SERVER['SERVER_NAME']) !== 0) {
            return false;
        }

        if (!isset($this->request['audio'])) {
            return false;
        }

        $audioFile = WCJDEncryption::decrypt($this->request['audio'], self::KEY);
        if (!$audioFile) {
            return false;
        }

        $this->file = $this->convertPublicPathToPrivate($audioFile);

        if (!is_file($this->file)) {
            return false;
        }

        return true;
    }

    public function output() {
        // Session locking prevents multiple files from buffering simultaneously
        if (session_id()) {
            session_write_close();
        }
        header('Content-Disposition: binary; filename='.basename($this->file));
        $mimeTypes = 'audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3';
        header('Content-type: {$mime_type}');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . filesize($this->file));
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($this->file);
    }

}
