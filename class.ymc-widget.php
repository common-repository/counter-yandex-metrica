<?php

/**
 * class.ymc-widget.php
 *
 * @author     Alexander Semikashev
 * @version    1.2
 */

class YMC_Widget extends WP_Widget {

    function __construct() {

        global $pagenow;

        load_plugin_textdomain( 'counter-yandex-metrica', false, basename( dirname( __FILE__ ) ) . '/languages' );

        parent::__construct(
            'yametrika-counter-informer',
            __('Informer Yandex.Metric', 'counter-yandex-metrica'),
            array( 'description' => __('Allows you to view widget of Yandex metrics in the sidebar and other places.', 'counter-yandex-metrica') )
        );


        if( $pagenow == 'widgets.php' ){
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }

        add_action( 'admin_footer-widgets.php', array( $this, 'scripts' ), 9999 );

    }

    public function widget( $args, $instance ){

		if(YMC::$options['ymc_number_counter']){

			if($instance['ymc_sizes'] == '3'){ $width = '88px'; $height = '31px'; } elseif($instance['ymc_sizes'] == '2'){ $width = '80px'; $height = '31px'; } elseif($instance['ymc_sizes'] == '1'){ $width = '80px'; $height = '15px'; }
			if( get_user_locale() == 'ru_RU' ){ $langcode = 'ru'; } elseif( get_user_locale() == 'tr_TR' ) { $langcode = 'tr'; } elseif( get_user_locale() == 'uk' ) { $langcode = 'ua'; } else { $langcode = 'en'; }

			echo '<div class="ymc_widget_inforemer">';
			echo '<!-- Yandex.Metrika informer -->';
			echo '<a href="https://metrika.yandex.ru/stat/?id=' . YMC::$options['ymc_number_counter'] . '&amp;from=informer" target="_blank" rel="nofollow"><img src="' . $this->img_link_generator($instance) . '" style="width:' . $width . '; height:' . $height . '; border:0;" alt="' . __('Yandex.Metrica', 'counter-yandex-metrica') . '" title="' . __('Yandex.Metrica: data for today (page views, visits and unique users)', 'counter-yandex-metrica') . '" ' . (($instance['ymc_type'] == 'advanced') ? 'class="ym-advanced-informer" data-cid="' . YMC::$options['ymc_number_counter'] . '" data-lang="'.$langcode.'"' : '' ) . ' /></a>';
			echo '<!-- /Yandex.Metrika informer -->';
			echo '</div>';

		}
    }

    public function form( $instance ) {

        $instance['ymc_sizes'] = ( !empty( $instance['ymc_sizes'] ) OR ( $instance['ymc_sizes'] == '3' OR $instance['ymc_sizes'] == '2' OR $instance['ymc_sizes'] == '1' ) ) ? $instance['ymc_sizes'] : '3';
        $instance['ymc_type_content'] = ( !empty( $instance['ymc_type_content'] ) OR ( $instance['ymc_type_content'] == 'pageviews' OR $instance['ymc_type_content'] == 'visits' OR $instance['ymc_type_content'] == 'uniques' ) ) ? $instance['ymc_type_content'] : 'pageviews';
        $instance['ymc_color'] = ( !empty( $instance['ymc_color'] ) ) ? $instance['ymc_color'] : '#EFEFEF';
        $instance['ymc_gradient'] = empty( $instance['ymc_gradient'] ) ? false : true;
        $instance['ymc_colortext'] = ( !empty( $instance['ymc_colortext'] ) OR ( $instance['ymc_colortext'] == '0' OR $instance['ymc_colortext'] == '1' ) ) ? $instance['ymc_colortext'] : '0';
        $instance['ymc_colorarrow'] = ( !empty( $instance['ymc_colorarrow'] ) OR ( $instance['ymc_colorarrow'] == '1' OR $instance['ymc_colorarrow'] == '0' ) ) ? $instance['ymc_colorarrow'] : '1';
        $instance['ymc_type'] = ( !empty( $instance['ymc_type'] ) OR ( $instance['ymc_type'] == 'simple' OR $instance['ymc_type'] == 'advanced' ) ) ? $instance['ymc_type'] : 'simple';

        ?>
        <style>
            .ymc_colorarrow_red, .ymc_colorarrow_black {
                display: inline-block;
                width: 12px;
                height: 16px;
                background: url('https://yastatic.net/metrika/1.141.1/blocks/common/counter-informer/counter-informer.png') 0 0 no-repeat #fff;
                vertical-align: text-bottom;
            }

            .ymc_colorarrow_black {
                background-position: -12px 0;
            }
        </style>
        <div class="ymc-widget-informer">
            <p style="font-size: 12px;">
                <?php _e('Attention! In order for the widget to be displayed correctly, you must enable it in the counter setting on the Yandex page.', 'counter-yandex-metrica'); ?>
            </p>
            <p>
                <select class="ymc_sizes" name="<?php echo $this->get_field_name( 'ymc_sizes' ); ?>" id="<?php echo $this->get_field_id( 'ymc_sizes' ); ?>">
                    <option value="3" <?php echo ($instance['ymc_sizes'] == '3') ? 'selected' : ''; ?>>88x31</option>
                    <option value="2" <?php echo ($instance['ymc_sizes'] == '2') ? 'selected' : ''; ?>>80x31</option>
                    <option value="1" <?php echo ($instance['ymc_sizes'] == '1') ? 'selected' : ''; ?>>80x15</option>
                </select>
            </p>
            <p>
                <input class="ymc_type_content" name="<?php echo $this->get_field_name( 'ymc_type_content' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_views' ); ?>" value="pageviews" <?php echo ($instance['ymc_type_content'] == 'pageviews') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_views' ); ?>"><?php _e('Page views', 'counter-yandex-metrica'); ?> </label>
                <input class="ymc_type_content" name="<?php echo $this->get_field_name( 'ymc_type_content' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_visits' ); ?>" value="visits" <?php echo ($instance['ymc_type_content'] == 'visits') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_visits' ); ?>"><?php _e('Visits', 'counter-yandex-metrica'); ?> </label>
                <input class="ymc_type_content" name="<?php echo $this->get_field_name( 'ymc_type_content' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_users' ); ?>" value="uniques" <?php echo ($instance['ymc_type_content'] == 'uniques') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_users' ); ?>"><?php _e('Users', 'counter-yandex-metrica'); ?> </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'ymc_color' ); ?>" style="float: left; margin-right: 10px;"><?php _e('Informer color', 'counter-yandex-metrica'); ?>:</label>
                <input type="text" class="ymc-color-picker" name="<?php echo $this->get_field_name( 'ymc_color' ); ?>" value="<?php echo $instance['ymc_color']; ?>">
            </p>
            <p>
                <label style="margin-right: 10px;" for="<?php echo $this->get_field_id( 'ymc_gradient' ); ?>"><?php _e('Gradient', 'counter-yandex-metrica'); ?>:</label>
                <input class="ymc_gradient" type="checkbox" name="<?php echo $this->get_field_name( 'ymc_gradient' ); ?>" value="1" id="<?php echo $this->get_field_id( 'ymc_gradient' ); ?>" <?php checked( $instance['ymc_gradient'] ); ?>>
            </p>
            <p>
                <label style="margin-right: 10px;"><?php _e('Text color', 'counter-yandex-metrica'); ?>:</label>
                <input class="ymc_colortext" name="<?php echo $this->get_field_name( 'ymc_colortext' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_colortext_black' ); ?>" value="0" <?php echo ($instance['ymc_colortext'] == '0') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_colortext_black' ); ?>"><?php _e('Black', 'counter-yandex-metrica'); ?> </label>
                <input class="ymc_colortext" name="<?php echo $this->get_field_name( 'ymc_colortext' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_colortext_white' ); ?>" value="1" <?php echo ($instance['ymc_colortext'] == '1') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_colortext_white' ); ?>"><?php _e('White', 'counter-yandex-metrica'); ?> </label>
            </p>
            <p>
                <label style="margin-right: 10px;"><?php _e('Arrow color', 'counter-yandex-metrica'); ?>:</label>
                <input class="ymc_colorarrow" name="<?php echo $this->get_field_name( 'ymc_colorarrow' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_colorarrow_red' ); ?>" value="1" <?php echo ($instance['ymc_colorarrow'] == '1') ? 'checked="checked"' : ''; ?>> <label class="ymc_colorarrow_red" for="<?php echo $this->get_field_id( 'ymc_colorarrow_red' ); ?>"> </label>
                <input class="ymc_colorarrow" name="<?php echo $this->get_field_name( 'ymc_colorarrow' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_colorarrow_black' ); ?>" value="0" <?php echo ($instance['ymc_colorarrow'] == '0') ? 'checked="checked"' : ''; ?>> <label class="ymc_colorarrow_black" for="<?php echo $this->get_field_id( 'ymc_colorarrow_black' ); ?>"> </label>
            </p>
            <p>
                <label style="margin-right: 10px;"><?php _e('Informer type', 'counter-yandex-metrica'); ?>:</label>
                <input class="ymc_type" name="<?php echo $this->get_field_name( 'ymc_type' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_type_simple' ); ?>" value="simple" <?php echo ($instance['ymc_type'] == 'simple') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_type_simple' ); ?>"> <?php _e('Simple', 'counter-yandex-metrica'); ?> </label>
                <input class="ymc_type" name="<?php echo $this->get_field_name( 'ymc_type' ); ?>" type="radio" id="<?php echo $this->get_field_id( 'ymc_type_advanced' ); ?>" value="advanced" <?php echo ($instance['ymc_type'] == 'advanced') ? 'checked="checked"' : ''; ?>> <label for="<?php echo $this->get_field_id( 'ymc_type_advanced' ); ?>"> <?php _e('Advanced', 'counter-yandex-metrica'); ?> </label>
            </p>

            <?php if( YMC::$options['ymc_number_counter'] != '' ){ ?>
                <p>
                    <span><?php _e('Preview informer', 'counter-yandex-metrica'); ?>:</span>
                <div id="ymc_preview_informer" style="text-align: center;"><img src="<?php echo $this->img_link_generator($instance); ?>" alt=""></div>
                </p>
            <?php } ?>
        </div>

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance['ymc_sizes'] = ( !empty( $new_instance['ymc_sizes'] ) OR ( $new_instance['ymc_sizes'] == '3' OR $new_instance['ymc_sizes'] == '2' OR $new_instance['ymc_sizes'] == '1' ) ) ? $new_instance['ymc_sizes'] : '3';
        $instance['ymc_type_content'] = ( !empty( $new_instance['ymc_type_content'] ) OR ( $new_instance['ymc_type_content'] == 'pageviews' OR $new_instance['ymc_type_content'] == 'visits' OR $new_instance['ymc_type_content'] == 'uniques' ) ) ? $new_instance['ymc_type_content'] : 'pageviews';
        $instance['ymc_color'] = ( !empty( $new_instance['ymc_color'] ) ) ? $new_instance['ymc_color'] : '#EFEFEF';
        $instance['ymc_gradient'] = empty( $new_instance['ymc_gradient'] ) ? false : true;
        $instance['ymc_colortext'] = ( !empty( $new_instance['ymc_colortext'] ) OR ( $new_instance['ymc_colortext'] == '0' OR $new_instance['ymc_colortext'] == '1' ) ) ? $new_instance['ymc_colortext'] : '0';
        $instance['ymc_colorarrow'] = ( !empty( $new_instance['ymc_colorarrow'] ) OR ( $new_instance['ymc_colorarrow'] == '1' OR $new_instance['ymc_colorarrow'] == '0' ) ) ? $new_instance['ymc_colorarrow'] : '1';
        $instance['ymc_type'] = ( !empty( $new_instance['ymc_type'] ) OR ( $new_instance['ymc_type'] == 'simple' OR $new_instance['ymc_type'] == 'advanced' ) ) ? $new_instance['ymc_type'] : 'simple';

        return $instance;

    }

    public function img_link_generator( $instance ) {

        $link = 'https://informer.yandex.ru/informer/' . YMC::$options['ymc_number_counter'] . '/';
        $link .= $instance['ymc_sizes'] . '_';
        $link .= $instance['ymc_colorarrow'] . '_';
        if( $instance['ymc_gradient'] === true ){
            $colourstr = str_replace('#','', $instance['ymc_color']);

            $rhex = substr($colourstr,0,2);
            $ghex = substr($colourstr,2,2);
            $bhex = substr($colourstr,4,2);

            $r = hexdec($rhex);
            $g = hexdec($ghex);
            $b = hexdec($bhex);

            $r = max(0,min(255,$r + 32));
            $g = max(0,min(255,$g + 32));
            $b = max(0,min(255,$b + 32));

            $link .= dechex($r).dechex($g).dechex($b) . 'FF_';
        } else {
            $link .= trim(strtoupper($instance['ymc_color']), '#') . 'FF_';
        }
        $link .= trim(strtoupper($instance['ymc_color']), '#') . 'FF_';
        $link .= $instance['ymc_colortext'] . '_';
        $link .= $instance['ymc_type_content'];

        return $link;
    }

    public function scripts() {
        ?>
        <script>
            ( function( $ ){
                function initColorPicker( widget ) {
                    widget.find( '.ymc-color-picker' ).wpColorPicker( {
                        change: _.throttle( function() {
                            $(this).trigger( 'change' );
                        }, 500 )
                    });
                }

                function onFormUpdate( event, widget ) {
                    initColorPicker( widget );
                }

                $( document ).on( 'widget-added widget-updated', onFormUpdate );

                $( document ).ready( function() {
                    $( '#widgets-right .widget:has(.ymc-color-picker)' ).each( function () {
                        initColorPicker( $( this ) );
                    } );
                } );

                $(document).on('change', '.ymc-widget-informer input, .ymc-widget-informer select', function(){
                    previewInformer( $( this).closest( ".ymc-widget-informer" ) );
                });

                function previewInformer( element ){
                    var $link = 'https://informer.yandex.ru/informer/<?php echo YMC::$options['ymc_number_counter']; ?>/';
                    $link += $( element ).find(".ymc_sizes").val() + '_';
                    $link += $( element ).find(".ymc_colorarrow:checked").val() + '_';
                    if( $( element ).find(".ymc_gradient").is(":checked") ){

                        var $colourstr = $( element ).find(".ymc-color-picker").val().substr(1);

                        var $rhex = $colourstr.substr(0,2);
                        var $ghex = $colourstr.substr(2,2);
                        var $bhex = $colourstr.substr(4,2);

                        var $r = parseInt($rhex, 16);
                        var $g = parseInt($ghex, 16);
                        var $b = parseInt($bhex, 16);

                        $r = Math.max(0, Math.min(255, $r + 32));
                        $g = Math.max(0, Math.min(255, $g + 32));
                        $b = Math.max(0, Math.min(255, $b + 32));

                        $link += $r.toString(16) + $g.toString(16) + $b.toString(16) + 'FF_';
                    } else {
                        $link += $( element ).find(".ymc-color-picker").val().substr(1) + 'FF_';
                    }
                    $link += $( element ).find(".ymc-color-picker").val().substr(1) + 'FF_';
                    $link += $( element ).find(".ymc_colortext:checked").val() + '_';
                    $link += $( element ).find(".ymc_type_content:checked").val();

                    $( element ).find("#ymc_preview_informer img").attr("src", $link);
                }

            }( jQuery ) );
        </script>
        <?php
    }

}

function ymc_register_widgets() {
    register_widget( 'YMC_Widget' );
}

add_action( 'widgets_init', 'ymc_register_widgets' );