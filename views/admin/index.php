<div class="wrap wcjd-wrap">
    <div class="wcjd-settings-form">
        <h2>The Stiz - Audio for WooCommerce Options</h2>

        <form method="post" action="" autocomplete="off">

            <?php $this->options->save(); ?>
            <?php settings_fields(WCJDOptions::OPTIONS); ?>

            <div id="wcjd-options-tabs">
                <ul>
                    <li><a href="#wcjd-options-general">General</a></li>
                    <li><a href="#wcjd-options-general-styling">Product list Styling</a></li>
                    <li><a href="#wcjd-options-audio-preview-settings">Audio Preview Settings</a></li>
                    <li><a href="#wcjd-options-audio-preview-styling">Audio Preview Styling</a></li>
                </ul>
                <!-- General -->
                <div id="wcjd-options-general">
                    <label for="wcjd-hide-preview-thumbnails">
                        <input autocomplete="off" id="wcjd-hide-preview-thumbnails" type="checkbox" value="1" name="<?php echo WCJDOptions::HIDE_THUMBNAILS; ?>" <?php if ($this->options->hideThumbnails()) echo 'checked="checked"'; ?> />
                        Hide preview thumbnails
                    </label>
                </div>
                <!-- Styling -->
                <div id="wcjd-options-general-styling">
                    <label for="wcjd-use-custom-css">
                        <input autocomplete="off" id="wcjd-use-custom-css" type="checkbox" value="1" name="<?php echo WCJDOptions::USE_CUSTOM_CSS; ?>" <?php if ($this->options->useCustomCss()) echo 'checked="checked"'; ?> />
                        Use custom CSS
                    </label>
                    <div id="wcjd-custom-css-wrap" <?php if (!$this->options->useCustomCss()) 'style="display:none"'; ?> >
                        <textarea id="wcjd-custom-css" name="<?php echo WCJDOptions::CUSTOM_CSS; ?>"><?php echo $this->options->customCss(); ?></textarea>
                        <p class="submit">
                            <input id="wcjd-reset-custom-css" type="button" class="button-primary" value="<?php _e('Reset Custom CSS') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-use-custom-css').change(function() {
                                $('#wcjd-custom-css-wrap').toggle($(this).is(':checked'));
                            });
                            $('#wcjd-reset-custom-css').click(function() {
                                $('#wcjd-custom-css').html(<?php echo json_encode($this->options->defaultCss()); ?>);
                            });
                        })(jQuery);
                    </script>
                </div>
                <!-- Media Element Settings -->
                <div id="wcjd-options-audio-preview-settings">
                    <label for="wcjd-position-above">
                        <input autocomplete="off" id="wcjd-position-above" type="radio" value="<?php echo WCJDOptions::DISPLAY_ABOVE_HEADING; ?>" name="<?php echo WCJDOptions::PLAYER_POSITION; ?>" <?php if ($this->options->playerPosition() === WCJDOptions::DISPLAY_ABOVE_HEADING) echo 'checked="checked"'; ?>/>
                        Above product heading
                    </label>
                    <br/>
                    <label for="wcjd-position-below">
                        <input autocomplete="off" id="wcjd-position-below" type="radio" value="<?php echo WCJDOptions::DISPLAY_BELOW_HEADING; ?>" name="<?php echo WCJDOptions::PLAYER_POSITION; ?>" <?php if ($this->options->playerPosition() === WCJDOptions::DISPLAY_BELOW_HEADING) echo 'checked="checked"'; ?>/>
                        Below product heading
                    </label>
                    <br/>
                    <br/>
                    <label for="wcjd-width">Width</label>
                    <input autocomplete="off" id="wcjd-width" type="text" value="<?php echo $this->options->playerWidth(); ?>" name="<?php echo WCJDOptions::PLAYER_WIDTH; ?>" />
                    <br/>
                    <label for="wcjd-height">Height</label>
                    <input autocomplete="off" id="wcjd-height" type="text" value="<?php echo $this->options->playerHeight(); ?>" name="<?php echo WCJDOptions::PLAYER_HEIGHT; ?>" />
                </div>
                <!-- Media Element Styling -->
                <div id="wcjd-options-audio-preview-styling">
                    <label for="wcjd-use-custom-media-element-css">
                        <input autocomplete="off" id="wcjd-use-custom-media-element-css" type="checkbox" value="1" name="<?php echo WCJDOptions::USE_CUSTOM_MEDIA_ELEMENT_CSS; ?>" <?php if ($this->options->useCustomMediaElementCss()) echo 'checked="checked"'; ?> />
                        Use custom Media Element CSS
                    </label>
                    <div id="wcjd-custom-media-element-css-wrap" <?php if (!$this->options->useCustomMediaElementCss()) 'style="display:none"'; ?> >
                        <textarea id="wcjd-custom-media-element-css" name="<?php echo WCJDOptions::CUSTOM_MEDIA_ELEMENT_CSS; ?>"><?php echo $this->options->customMediaElementCss(); ?></textarea>
                        <p class="submit">
                            Use default:
                            <input id="wcjd-reset-custom-media-element-css" type="button" class="button-primary" value="<?php _e('Standard Media Element CSS') ?>" />
                            <input id="wcjd-reset-custom-media-element-single-button-css" type="button" class="button-primary" value="<?php _e('Single Button Media Element CSS') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-use-custom-media-element-css').change(function() {
                                $('#wcjd-custom-media-element-css-wrap').toggle($(this).is(':checked'));
                            });
                            $('#wcjd-reset-custom-media-element-css').click(function() {
                                $('#wcjd-custom-media-element-css').html(<?php echo json_encode($this->options->defaultMediaElementCss()); ?>);
                            });
                            $('#wcjd-reset-custom-media-element-single-button-css').click(function() {
                                $('#wcjd-custom-media-element-css').html(<?php echo json_encode($this->options->defaultMediaElementSingleButtonCss()); ?>);
                            });
                        })(jQuery);
                    </script>
                </div>
            </div>

            <script type="text/javascript">
                jQuery(function() {
                    jQuery('#wcjd-options-tabs').tabs({
                        cookie: {
                            expires: 10
                        }
                    });
                });
            </script>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                <input id="wcjd-cancel" type="reset" class="button-secondary" value="Cancel" />
                <script type="text/javascript">
                    jQuery('#wcjd-cancel').click(function() {
                        window.location.reload(true);
                    })
                </script>
            </p>
        </form>
    </div>

    <div class="wcjd-settings-information">
        <a href="http://www.thestiz.com/?utm_source=wp-wcjd&utm_medium=admin-index&utm_content=stiz-logo&utm_campaign=wcjd" target="_blank" title="New Jersey's premier recording studio for hip-hop, rap and mixtape recording">
            <img src="<?php echo plugins_url('css/admin/logo-the-stiz.png', __FILE__.'/../../../../'); ?>" />
        </a>
        <h2>The Stiz - Audio for WooCommerce</h2>
        <p>
            The Stiz - Audio for WooCommerce is the brainchild of Mike Hemberger, who lives at <a target="_blank" href="http://jivedigdesign.com//?utm_source=wcjd&utm_medium=admin-index&utm_content=mike-hemberger&utm_campaign=wcjd">jivedigdesign.com</a>, and uses Twitter.
            <br/>
            <br/>
            <a href="https://twitter.com/JiveDig" class="twitter-follow-button" data-show-count="false">Follow @JiveDig</a>
        </p>
        <hr/>
        <p>
            Plugin programming by by Michael Robinson, who lives at <a target="_blank" href="http://pagesofinterest.net/?utm_source=wp-wcjd&utm_medium=admin-index&utm_content=michael-robinson&utm_campaign=wcjd" title="Michael Robinson!">pagesofinterest.net</a>, and uses Twitter.
            <br/>
            <br/>
            <a href="https://twitter.com/pagesofinterest" class="twitter-follow-button" data-show-count="false">Follow @pagesofinterest</a>
        </p>
        <hr/>
        <p>
            The Stiz - Audio for WooCommerce uses <a target="_blank" href="http://mediaelementjs.com/">MediaElement</a>, created by John Dyer.
            <blockquote>
                <strong>MediaElement</strong>
                <br/>
                HTML5 &lt;video&gt; and &lt;audio&gt; made easy.
                <br/>
                One file. Any browser. Same UI.
            </blockquote>
            <br/>
            <a href="https://twitter.com/johndyer" class="twitter-follow-button" data-show-count="false">Follow @johndyer</a>
        </p>
    </div>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>


















