<?php
class WCJDInstaller {

    public static function install() {

        // Install folder for uploading files and prevent hotlinking
        $downloadDirectory = WCJDOptions::downloadDirectory();

        if (wp_mkdir_p($downloadDirectory) && ! file_exists($downloadDirectory . '/.htaccess')) {
            file_put_contents($downloadDirectory . '/.htaccess', 'deny from all');
        }
    }
}
