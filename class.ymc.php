<?php

/**
 * class.ymc.php
 *
 * @author     Alexander Semikashev
 * @version    1.1
 */

class YMC {

    public static $options;

    const OPTION = 'yametrika-counter';

    public static function init() {

        load_plugin_textdomain( 'counter-yandex-metrica', false, basename( dirname( __FILE__ ) ) . '/languages' );

        self::$options  = self::options();

		self::tracker();
    }

    public static function options() {
        $default = array(
			'ymc_oldtracker'       => false,

            'ymc_number_counter'    => "",
            'ymc_webvisor'          => true,
			'ymc_option_clickmap'   => true,
            'ymc_option_trackLinks' => true,
            'ymc_option_async'      => true,
            'ymc_option_hash'       => false,
			'ymc_option_noindex'    => false,

            'ymc_option_cdn'        => 'none',
            'ymc_option_cdnuser'    => '',

            'ymc_position'          => 'footer',
            'ymc_track_login'       => true,

            'ymc_role' => array( "administrator" ),
        );

        return wp_parse_args( get_option( self::OPTION ), $default );
    }

	public static function tracker() {

		$view = false;

		if( is_numeric( self::$options['ymc_number_counter'] ) ){

			if( 
				self::$options['ymc_track_login'] === true &&( is_user_logged_in() && ! self::access( self::$options['ymc_role'] ) ) || !is_user_logged_in()
			) {
				$view = true;
			} elseif ( self::$options['ymc_track_login'] === false && !is_user_logged_in() ) {
				$view = true;
			}

		}

		if($view === true){
			if( self::$options['ymc_position'] == 'header' ){
				if( self::$options['ymc_oldtracker'] == false ){
					add_action( 'wp_head', array('YMC', 'tracker_template'), 9999 );
				} else {
					add_action( 'wp_head', array('YMC', 'old_tracker_template'), 9999 );
				}
			} elseif( self::$options['ymc_position'] == 'footer' ){
				if( self::$options['ymc_oldtracker'] == false ){
					add_action( 'wp_footer', array('YMC', 'tracker_template'), 9999 );
				} else {
					add_action( 'wp_footer', array('YMC', 'old_tracker_template'), 9999 );
				}
			}
		}
	}

	public static function tracker_template() {
		$options = self::$options;

		$yandexcdn = 'https://mc.yandex.ru/metrika/tag.js';

		if( $options['ymc_option_cdn'] == 'default' ) {
			$yandexcdn = 'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js';
		} elseif( $options['ymc_option_cdn'] == 'user' AND $options['ymc_option_cdnuser'] != '' ){
			$yandexcdn = $options['ymc_option_cdnuser'];
		}

		$tracker = '';

		$tracker .= '<!-- Yandex.Metrika counter --> ';
		$tracker .= '<script type="text/javascript" >';
		$tracker .= ' (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; ';
		$tracker .= 'm[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) ';
		$tracker .= '(window, document, "script", "' . $yandexcdn . '", "ym");';

		$tracker .= ' ym(' . $options['ymc_number_counter'] . ', "init", { ';
				$tracker .= ' id:' . $options['ymc_number_counter'] . ',';

				if( $options['ymc_option_clickmap'] === true ) { $tracker .= ' clickmap:true,'; }
				if( $options['ymc_option_trackLinks'] === true ) { $tracker .= ' trackLinks:true,'; }
				if( $options['ymc_option_hash'] === true ) { $tracker .= ' trackHash:true,'; }
				if( $options['ymc_option_noindex'] === true ) { $tracker .= ' ut:"noindex",'; }
				if( $options['ymc_webvisor'] == true ) { $tracker .= ' webvisor:true,'; }

				$tracker .= ' accurateTrackBounce:true';
		$tracker .= ' });';
		$tracker .= ' </script>';

		$tracker .= ' <noscript><div><img src="https://mc.yandex.ru/watch/' . $options['ymc_number_counter'] . '" style="position:absolute; left:-9999px;" alt="" /></div></noscript>';
		$tracker .= ' <!-- /Yandex.Metrika counter -->';

		echo $tracker;
	}

	public static function old_tracker_template() {
		$options = self::$options;

		$yandexcdn = 'https://mc.yandex.ru/metrika/watch.js';

		if( $options['ymc_option_cdn'] == 'default' ) {
			$yandexcdn = 'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/watch.js';
		} elseif( $options['ymc_option_cdn'] == 'user' AND $options['ymc_option_cdnuser'] != '' ){
			$yandexcdn = $options['ymc_option_cdnuser'];
		}

		$tracker = '';
		$tracker .= '<!-- Yandex.Metrika counter --> ';
		if( $options['ymc_option_async'] === false ) { $tracker .= '<script src="' . $yandexcdn . '" type="text/javascript"></script>';} 
		$tracker .= '<script type="text/javascript" >';
		if( $options['ymc_option_async'] === true ) { $tracker .= ' (function (d, w, c) { (w[c] = w[c] || []).push(function() {'; }

		$tracker .= ' try {';

		if( $options['ymc_option_async'] === true ) {
			$tracker .= ' w.yaCounter' . $options['ymc_number_counter'] . ' = new Ya.Metrika({';
		} else {
			$tracker .= ' var yaCounter' . $options['ymc_number_counter'] . ' = new Ya.Metrika({';
		}

		$tracker .= 'id:' . $options['ymc_number_counter'] . ',';

		if( $options['ymc_option_clickmap'] === true ) { $tracker .= ' clickmap:true,'; }
		if( $options['ymc_option_trackLinks'] === true ) { $tracker .= ' trackLinks:true,'; }
		if( $options['ymc_option_hash'] === true ) { $tracker .= ' trackHash:true,'; }
		if( $options['ymc_option_noindex'] === true ) { $tracker .= ' ut:"noindex",'; }
		if( $options['ymc_webvisor'] == true ) { $tracker .= ' webvisor:true,'; }

		$tracker .= ' accurateTrackBounce:true';

		$tracker .= ' }); } catch(e) { }';

		if( $options['ymc_option_async'] === true ) {
			$tracker .= ' });';
			$tracker .= ' var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); };';
			$tracker .= ' s.type = "text/javascript"; ';
			$tracker .= 's.async = true; ';
			$tracker .= 's.src = "' . $yandexcdn . '"; ';
			$tracker .= 'if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }';

			$tracker .= ' })(document, window, "yandex_metrika_callbacks");';
		}
		$tracker .= ' </script>';
		$tracker .= ' <noscript><div><img src="https://mc.yandex.ru/watch/' . $options['ymc_number_counter'] . '" style="position:absolute; left:-9999px;" alt="" /></div></noscript>';
		$tracker .= ' <!-- /Yandex.Metrika counter -->';

		echo $tracker;
	}

	public static function access( $arr ) {
		global $current_user;

		$roles = $current_user->roles;
		$role = array_shift( $roles );

		if ( is_array( $arr ) && in_array( $role, $arr ) ) {
			return true;
		}

		return false;
	}

}
