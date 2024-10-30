<?php

/**
 * class.ymc-admin.php
 *
 * @author     Alexander Semikashev
 * @version    1.1
 */

class YMC_Admin {

    private static $initiated = false;

    public static function init() {

        if ( ! self::$initiated ) {
            self::init_hooks();
        }

    }

    public static function init_hooks() {

        self::$initiated = true;

        add_action( 'admin_menu', array( 'YMC_Admin', 'admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( 'YMC_Admin', 'load_resources' ) );

        add_action( 'plugin_action_links_' . YMC__BASENAME, array( 'YMC_Admin', 'plugin_links' ) );

    }

    public static function admin_menu() {
        global $page_hook_suffix;

        $page_hook_suffix = add_options_page( __('Yandex Metrica', 'counter-yandex-metrica'), __('Yandex Metrica', 'counter-yandex-metrica'), 'manage_options', 'counter-yandex-metrica', array( 'YMC_Admin', 'configuration_page' ) );
    }

    public static function load_resources($hook){
        global $page_hook_suffix;

        if ( $hook == $page_hook_suffix ){
            wp_register_style( 'ymc.css', plugin_dir_url( __FILE__ ) . '_inc/ymc.css', array(), YMC__VERSION );
            wp_enqueue_style( 'ymc.css');
        }

    }

    public static function configuration_page() {
        global $wp_roles;

        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'counter-yandex-metrica' ) );
        }

        if ( isset( $_POST['ymc-save'] )  && ( !current_user_can( 'manage_options' ) || empty( $_REQUEST['ymc_settings_nonce'] )  || ! wp_verify_nonce( $_REQUEST['ymc_settings_nonce'], 'ymc_update_settings' ) ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'counter-yandex-metrica' ) );
        }

        if ( isset( $_POST['ymc-save'] ) ) {
			YMC::$options['ymc_oldtracker'] = empty( $_POST['ymc_oldtracker'] ) ? false : true;

            YMC::$options['ymc_number_counter'] = trim($_POST['ymc_number_counter']);
            YMC::$options['ymc_webvisor'] = empty( $_POST['ymc_webvisor'] ) ? false : true;
			YMC::$options['ymc_option_clickmap'] = empty( $_POST['ymc_option_clickmap'] ) ? false : true;
            YMC::$options['ymc_option_trackLinks'] = empty( $_POST['ymc_option_trackLinks'] ) ? false : true;
            YMC::$options['ymc_option_async'] = empty( $_POST['ymc_option_async'] ) ? false : true;
            YMC::$options['ymc_option_hash'] = empty( $_POST['ymc_option_hash'] ) ? false : true;
			YMC::$options['ymc_option_noindex'] = empty( $_POST['ymc_option_noindex'] ) ? false : true;

            YMC::$options['ymc_option_cdn'] = $_POST['ymc_option_cdn'];
            YMC::$options['ymc_option_cdnuser'] = trim($_POST['ymc_option_cdnuser']);

            YMC::$options['ymc_position'] = $_POST['ymc_position'];
            YMC::$options['ymc_track_login'] = $_POST['ymc_track_login'] == 1 ? true : false;

            YMC::$options['ymc_role'] = ! empty( $_POST['ymc_role'] ) ? array_map( 'esc_attr', $_POST['ymc_role'] ) : '';

            if ( is_numeric( YMC::$options['ymc_number_counter'] ) ) {
                $message = '<div class="ymc-updated">' . __( 'Options saved!', 'counter-yandex-metrica' ) . '</div>';
            }
            else {
                $message = '<div class="ymc-error">' . __( "Please enter a valid counter code!", "counter-yandex-metrica" ) . '</div>';
                YMC::$options['ymc_number_counter'] = '';
            }

            self::update_options( YMC::$options );
        }

        if ( isset( $_POST["reset"] ) ) {
            self::update_options( null );
            YMC::$options = YMC::options();

            $message = ' <div class="ymc-updated">' . __( 'All options cleared!', 'counter-yandex-metrica' ) . '</div>';
        }

        include( YMC__PLUGIN_DIR . '_tpl/config.php' );
    }

    public static function update_options( $options ) {
        update_option( YMC::OPTION, $options );
    }

    public static function plugin_links( $links ){
		$settings_link = '<a href="options-general.php?page=counter-yandex-metrica">' . __('Settings') . '</a>';
		array_unshift($links, $settings_link);

		return $links;
    }

    public static function get_page_url( $page = 'config' ) {

        $args = array( 'page' => 'counter-yandex-metrica' );

        $url = add_query_arg( $args, admin_url( 'options-general.php' ) );

        return $url;
    }

}