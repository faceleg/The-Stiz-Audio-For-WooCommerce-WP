<?php
/**
 * Handle displaying & saving custom admin data.
 */
class WCJDWooCommerceAdminAdditions {

    /**
     * Preview file path post meta key.
     */
    const PREVIEW_URL_KEY = '_wcjd_preview_file_path';

    /**
     * Get the preview file path post meta for the current post & output the preview file input view.
     */
    public function editProduct() {
        global $post;

        $previewUrl = get_post_meta($post->ID, self::PREVIEW_URL_KEY, true);
        include WCJD_ROOT.'/views/admin/preview-file-input.php';
    }

    /**
     * Save or update the preview file path post meta.
     * @param  {integer} $postID The ID of the post being edited.
     */
    public function saveProduct($postID) {

        if (!isset($_POST[self::PREVIEW_URL_KEY])) {
            return;
        }

        global $wpdb;

        $previewUrl = $_POST[self::PREVIEW_URL_KEY];
        $previewUrl = $wpdb->_real_escape($previewUrl);

        add_post_meta($postID, self::PREVIEW_URL_KEY, $previewUrl, true) or update_post_meta($postID, self::PREVIEW_URL_KEY, $previewUrl);
    }

    public function uploadPreviewFile() {
        do_action('media_upload_file');
    }

    public function previewFileUploadDirectory($pathdata) {
        if (isset($_POST['type']) && $_POST['type'] === WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT) {

            // Uploading a downloadable file
            $subdir = '/'.WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT.$pathdata['subdir'];
            $pathdata['path'] = str_replace($pathdata['subdir'], $subdir, $pathdata['path']);
            $pathdata['url'] = str_replace($pathdata['subdir'], $subdir, $pathdata['url']);
            $pathdata['subdir'] = str_replace($pathdata['subdir'], $subdir, $pathdata['subdir']);
            return $pathdata;

        }
    }

}
