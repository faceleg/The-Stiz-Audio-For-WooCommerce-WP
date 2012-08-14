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

        if (!isset($_GET['type'])){
            return $pathdata;
        }

        if ($_GET['type'] !== WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT) {
            return $pathdata;
        }

        // Uploading a downloadable file
        $subdir = '/'.WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT.$pathdata['subdir'];
        $pathdata['path'] = str_replace($pathdata['subdir'], $subdir, $pathdata['path']);
        $pathdata['url'] = str_replace($pathdata['subdir'], $subdir, $pathdata['url']);
        $pathdata['subdir'] = str_replace($pathdata['subdir'], $subdir, $pathdata['subdir']);
        return $pathdata;
    }

    public function limitMediaLibraryTabs($tabs) {

        if (!WCJDStates::ownMediaLibraryRequest()) {
            return $tabs;
        }

        return array(
            'type' => 'From Computer',
            'library' => 'Media Library'
        );
    }

    public function filterPostMimeTypes($postMimeTypes) {
        if (!WCJDStates::ownMediaLibraryRequest()) {
            return $postMimeTypes;
        }
        return array();//'audio' => $postMimeTypes['audio']);
    }

    public function limitMediaLibraryEditFields($formFields, $post) {

        if (!WCJDStates::ownMediaLibraryRequest()) {
            return $formFields;
        }

        $urlType = get_option('image_default_link_type');

        if('post' === $urlType ) {
            update_option('image_default_link_type', 'file');
            $urlType = 'file';
        }

        if(empty($urlType )) {
            $urlType = get_user_setting('urlbutton', 'file');
        }

        $file = wp_get_attachment_url($post->ID);
        $url = '';
        if($urlType === 'file') {
            $url = $file;
        }
        $url = esc_attr($url);

        $formFields['url'] = array(
            'label' => __('Audio Preview URL'),
            'input' => 'html',
            'html' => "<input type='text' readonly='readonly' class='text urlfield' name='attachments[{$post->ID}][url]' value='{$url}' />"
        );

        unset($formFields['post_excerpt']);
        unset($formFields['post_content']);
        unset($formFields['post_title']);

        return $formFields;
    }

    public function limitMediaLibraryItems($where, &$wp_query) {

        if (!WCJDStates::ownMediaLibraryRequest()) {
            return $where;
        }

        global $wpdb;

        $uploadDirectorySegment = WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT;

        $where .= " AND {$wpdb->posts}.guid LIKE '%{$uploadDirectorySegment}%'";

        return $where;
    }


}
