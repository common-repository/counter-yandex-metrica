<div id="ymc-plugin-container">
    <div class="ymc-header">
        <div class="ymc-header__inner">
            <span class="ymc-header__yalogo"><?php _e( 'Yandex.Metrika', 'counter-yandex-metrica' ); ?></span>
            <span class="ymc-header__yalogospan"> by <a href="http://semikashev.com" target="_blank">Alexander Semikashev</a></span>
            <div class="ymc-header__donate">
                <div class="ymc-header__donate_title"><?php _e( 'Author on coffee:', 'counter-yandex-metrica' ); ?></div>
                <a href="https://money.yandex.ru/to/410013025062803" target="_blank" class="ymc-header__donate_link"><?php _e( 'Ya.Money', 'counter-yandex-metrica' ); ?></a> /
                <a href="https://www.paypal.me/semikashevalex" target="_blank" class="ymc-header__donate_link"><?php _e( 'PayPal', 'counter-yandex-metrica' ); ?></a>
            </div>
        </div>
    </div>

    <?php if( isset($message) ){ echo $message; } ?>

    <div class="ymc-content">
        <form action="<?php echo esc_url( YMC_Admin::get_page_url() ); ?>" method="POST">
            <?php wp_nonce_field( 'ymc_update_settings', 'ymc_settings_nonce' ); ?>
            <div class="ymc-box">
                <h3><?php _e('Enter the number of the counter', 'counter-yandex-metrica'); ?></h3>
                <div class="ymc-inputbox">
                    <input id="ymc_number_counter" name="ymc_number_counter" type="text" size="15" value="<?php if ( isset( YMC::$options['ymc_number_counter'] ) ) echo YMC::$options['ymc_number_counter']; ?>">
                </div>
            </div>

            <div class="ymc-groupbox">
			<div class="ymc-box">
                <h3><?php _e('Obsolete code snippet', 'counter-yandex-metrica'); ?></h3>
                <div class="ymc-checkbox">
                    <label for="ymc_oldtracker">
                        <input name="ymc_oldtracker" type="checkbox" id="ymc_oldtracker" value="1" <?php checked( YMC::$options['ymc_oldtracker'] ); ?>>
                        <?php _e('Yes', 'counter-yandex-metrica'); ?>
                    </label>
					<div id="ymc_oldtracker_options" class="ymc_oldtracker_options" <?php if( YMC::$options['ymc_oldtracker'] == false ){echo 'style="display: none;"';} ?>>
						<label for="ymc_option_async">
							<input name="ymc_option_async" type="checkbox" id="ymc_option_async" value="1" <?php checked( YMC::$options['ymc_option_async'] ); ?>>
							<?php _e('Asynchronous code', 'counter-yandex-metrica'); ?> <span class="info">(<?php _e('recommends', 'counter-yandex-metrica'); ?>)</span>
							<span class="hint"><?php _e('Asynchronous code does not block or influence the loading speed of your site.', 'counter-yandex-metrica'); ?></span>
						</label>
					</div>
				</div>
            </div>

            <div class="ymc-box">
                <h3><?php _e('Additional settings', 'counter-yandex-metrica'); ?></h3>
                <br>
                <div class="ymc-checkbox">
					<label for="ymc_option_clickmap">
                        <input name="ymc_option_clickmap" type="checkbox" id="ymc_option_clickmap" value="1" <?php checked( YMC::$options['ymc_option_clickmap'] ); ?>>
                        <?php _e('Gathering statistics for the click map report', 'counter-yandex-metrica'); ?> <span class="info">(<?php _e('recommends', 'counter-yandex-metrica'); ?>)</span>
                    </label>
                    <label for="ymc_option_trackLinks">
                        <input name="ymc_option_trackLinks" type="checkbox" id="ymc_option_trackLinks" value="1" <?php checked( YMC::$options['ymc_option_trackLinks'] ); ?>>
                        <?php _e('Tracking of external links', 'counter-yandex-metrica'); ?> <span class="info">(<?php _e('recommends', 'counter-yandex-metrica'); ?>)</span>
                    </label>
                    <label for="ymc_option_hash">
                        <input name="ymc_option_hash" type="checkbox" id="ymc_option_hash" value="1" <?php checked( YMC::$options['ymc_option_hash'] ); ?>>
                            <?php _e('Hash tracking in the browser address bar', 'counter-yandex-metrica'); ?>
                            <span class="hint"><?php _e('Option applied to AJAX sites.', 'counter-yandex-metrica'); ?></span>
                    </label>
					<label for="ymc_webvisor">
                        <input name="ymc_webvisor" type="checkbox" id="ymc_webvisor" value="1" <?php checked( YMC::$options['ymc_webvisor'] ); ?>>
                        <?php _e('Session Replay', 'counter-yandex-metrica'); ?> <span class="info">(<?php _e('recommends', 'counter-yandex-metrica'); ?>)</span>
                    </label>
					<label for="ymc_option_noindex">
                        <input name="ymc_option_noindex" type="checkbox" id="ymc_option_noindex" value="1" <?php checked( YMC::$options['ymc_option_noindex'] ); ?>>
                            <?php _e('Stop automatic page indexing', 'counter-yandex-metrica'); ?>
                        <span class="hint"><?php _e('Stop automatic Yandex.Search page indexing for sites with Yandex.Metrica tags', 'counter-yandex-metrica'); ?></span>
                    </label>

                </div>
            </div>
            <div class="ymc-box">
                <h3><?php _e('Alternative CDN', 'counter-yandex-metrica'); ?></h3>
                <p><?php _e('Allows you to correctly register sessions from regions in which access to Yandex resources is restricted. Using this option may affect the loading speed of the code snippet.', 'counter-yandex-metrica'); ?></p>
                <div class="ymc-checkbox">
                    <label for="ymc_option_cdn1">
                        <input name="ymc_option_cdn" type="radio" id="ymc_option_cdn1" value="none" <?php if( YMC::$options['ymc_option_cdn'] == 'none' ){ echo 'checked=\'checked\''; } ?>>
                        <?php _e('not use', 'counter-yandex-metrica'); ?>
                    </label>
                    <label for="ymc_option_cdn2">
                        <input name="ymc_option_cdn" type="radio" id="ymc_option_cdn2" value="default" <?php if( YMC::$options['ymc_option_cdn'] == 'default' ){ echo 'checked=\'checked\''; } ?>>
                        <?php _e('use standard', 'counter-yandex-metrica'); ?> <span class="info">(cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js)</span>
                    </label>
                    <label for="ymc_option_cdn3">
                        <input name="ymc_option_cdn" type="radio" id="ymc_option_cdn3" value="user" <?php if( YMC::$options['ymc_option_cdn'] == 'user' ){ echo 'checked=\'checked\''; } ?>>
                        <?php _e('enter another', 'counter-yandex-metrica'); ?>
                        <input name="ymc_option_cdnuser" type="text" id="ymc_option_cdnuser" size="15" value="<?php if ( isset( YMC::$options['ymc_option_cdnuser'] ) ) echo YMC::$options['ymc_option_cdnuser']; ?>">
                    </label>
                </div>
            </div>
            </div>

            <div class="ymc-box">
                <h3><?php _e('Ways to install the code snippet', 'counter-yandex-metrica'); ?></h3>

                <div class="ymc-checkbox" style="padding: 1.5rem 1.5rem 0 1.5rem;">
                    <span style="display: inline-block; vertical-align: top; margin-right: 15px;"><?php _e('Plugin output area:', 'counter-yandex-metrica'); ?></span>
                    <label for="ymc_position1" style="display: inline-block; width: auto; margin-right: 15px; vertical-align: middle;">
                        <input name="ymc_position" type="radio" id="ymc_position1" value="header" <?php if( YMC::$options['ymc_position'] == 'header' ){ echo 'checked=\'checked\''; } ?>>
                        header
                    </label>
                    <label for="ymc_position2" style="display: inline-block; width: auto; vertical-align: middle;">
                        <input name="ymc_position" type="radio" id="ymc_position2" value="footer" <?php if( YMC::$options['ymc_position'] == 'footer' ){ echo 'checked=\'checked\''; } ?>>
                        footer
                    </label>
                </div>

                <div class="ymc-checkbox" style="padding: 0.5rem 1.5rem 1.0rem 1.5rem;">
                    <span style="display: inline-block; vertical-align: top; margin-right: 15px;"><?php _e('Track logged in users:', 'counter-yandex-metrica'); ?> </span>
                    <label for="ymc_track_login1" style="display: inline-block; width: auto; margin-right: 15px; vertical-align: middle;">
                        <input name="ymc_track_login" type="radio" id="ymc_track_login1" value="1" <?php if( YMC::$options['ymc_track_login'] == true ){ echo 'checked=\'checked\''; } ?>>
                        <?php _e('Yes', 'counter-yandex-metrica'); ?>
                    </label>
                    <label for="ymc_track_login2" style="display: inline-block; width: auto; vertical-align: middle;">
                        <input name="ymc_track_login" type="radio" id="ymc_track_login2" value="0" <?php if( YMC::$options['ymc_track_login'] == false ){ echo 'checked=\'checked\''; } ?>>
                        <?php _e('No', 'counter-yandex-metrica'); ?>
                    </label>
                </div>

                <?php
                    $roles = $wp_roles->get_names();
                ?>

                <div class="ymc-checkbox">
                    <span style="display: block; margin-bottom: 20px;"><?php _e('User roles to not track:', 'counter-yandex-metrica'); ?> </span>
                    <?php
                        if ( !is_array(YMC::$options['ymc_role']) ) YMC::$options['ymc_role'] = array();

                        foreach ( $roles as $role => $name ) :
                    ?>
                        <label for="ymc_role_<?php echo $role; ?>">
                            <input name="ymc_role[]" type="checkbox" id="ymc_role_<?php echo $role; ?>" value="<?php echo $role; ?>" <?php if ( in_array( $role, YMC::$options['ymc_role'] ) ) echo 'checked=\'checked\''; ?>>
                            <?php echo translate_user_role( $name ); ?>
                        </label>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>

            <div class="save" style="text-align: right;">
                <?php submit_button( __( 'Save', 'counter-yandex-metrica' ), 'primary', 'ymc-save', false ); ?>
                <input type="submit" name="reset" value="<?php _e( 'Reset', 'counter-yandex-metrica' ); ?>" class="button-secondary" />
            </div>

        </form>
    </div>
</div>

<script>
( function( $ ){
	$('#ymc_oldtracker').click(function() {
		if($(this).is(':checked')) {
			$("#ymc_oldtracker_options").show();
		} else {
			$("#ymc_oldtracker_options").hide();
		}
	});
}( jQuery ) );
</script>