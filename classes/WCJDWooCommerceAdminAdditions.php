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

    public function limitMediaLibraryTabs($tabs) {
        if (isset($_GET['wcjd']) && $_GET['wcjd']) {
            return array(
                'type' => 'From Computer',
                'library' => 'Media Library'
            );
        }
        return $tabs;
    }

    public function filterPostMimeTypes($postMimeTypes) {
        if (isset($_GET['wcjd']) && $_GET['wcjd']) {
            return array();//'audio' => $postMimeTypes['audio']);
        }
        return $postMimeTypes;
    }

    public function limitMediaLibraryEditFields($form_fields, $post) {

        $url_type = get_option('image_default_link_type');

        if('post' === $url_type ) {
            update_option('image_default_link_type', 'file');
            $url_type = 'file';
        }

        if(empty($url_type )) {
            $url_type = get_user_setting('urlbutton', 'file');
        }

        $file = wp_get_attachment_url($post->ID);
        $url = '';
        if($url_type === 'file') {
            $url = $file;
        }
        $url = esc_attr($url);

        $form_fields['url'] = array(
            'label'      => __('Audio Preview URL'),
            'input'      => 'html',
            'html'       => "<input type='text' readonly='readonly' class='text urlfield' name='attachments[{$post->ID}][url]' value='{$url}' />"
        );

        unset($form_fields['post_excerpt']);
        unset($form_fields['post_content']);
        unset($form_fields['post_title']);

        return $form_fields;
    }

    public function limitMediaLibraryItems($where, &$wp_query) {
        global $pagenow, $wpdb;
        if ($pagenow !== 'media-upload.php') {
            return $where;
        }
        if (!isset($_GET['wcjd']) && !$_GET['wcjd']) {
            return $where;
        }
        $uploadDirectorySegment = WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT;

        $where .= " AND {$wpdb->posts}.guid LIKE '%{$uploadDirectorySegment}%'";

        return $where;
    }


}
