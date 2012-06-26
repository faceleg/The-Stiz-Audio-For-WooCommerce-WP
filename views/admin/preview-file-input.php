<p class="form-field">
    <label for="_preview_file_path">Preview file path:</label>
    <input type="text" class="short file_path" name="<?php echo self::PREVIEW_URL_KEY; ?>" id="<?php echo self::PREVIEW_URL_KEY; ?>" value="<?php echo $previewUrl; ?>" placeholder="Preview File URL">
    <input type="button" id="wcjd_upload_preview_button" class="button" value="Upload a file">
</p>
<script type="text/javascript">
    (function($) {
        $(function() {
            /**
             * Extracts audio file's URL from the Media Library's html
             * @param  {string} html The HTML returned from the Media Library
             */
            window.send_to_editor_wcjd_preview = function(html) {
                // Return previous send_to_editor function
                window.send_to_editor = window.send_to_editor_default;

                // Get URI from preview URL
                var uri = $('<div>').html(html).children(':first').attr('href');

                if (uri[0] !== '/') {
                    var host = location.host;
                    uri = uri.substring(uri.indexOf(host) + host.length, uri.length);
                }

                $('#<?php echo self::PREVIEW_URL_KEY; ?>').val(uri);
                tb_remove();
            };
            $('#wcjd_upload_preview_button').click(function() {
                window.send_to_editor_default = window.send_to_editor;
                window.send_to_editor = window.send_to_editor_wcjd_preview;
                tb_show('Preview File', 'media-upload.php?wcjd=true&type=<?php echo WCJDOptions::UPLOAD_DIRECTORY_PATH_SEGMENT; ?>&TB_iframe=true');
            });
        });
    })(jQuery);
</script>
