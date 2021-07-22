<?php
/**
 * Plugin Name: Yandex Map Lite
 * Description: Просто добавить шорд код с параметрами: [yandex_map_lite x='50.447312' y='30.526511' zoom='5' hint='' header='' footer='']Yandex Maps[/yandex_map_lite]
 * Plugin URI: https://github.com/AndreyTSpb/wp_plugin_yandex_map
 * Author: tynyany.ru
 * Version: 1.0.1
 * Author URI: http://tynyany.ru
 *
 * Text Domain: Yandex Map Lite
 *
 * @package Yandex Map Lite
 */
defined('ABSPATH') or die('No script kiddies please!');

define( 'WPYML_VERSION', '1.0.1' );

define( 'WPYML_REQUIRED_WP_VERSION', '5.5' );

define( 'WPYML_TEXT_DOMAIN', 'yandex_maps_api' );

define( 'WPYML_PLUGIN', __FILE__ );

define( 'WPYML_PLUGIN_BASENAME', plugin_basename( WPYML_PLUGIN ) );

define( 'WPYML_PLUGIN_NAME', trim( dirname( WPYML_PLUGIN_BASENAME ), '/' ) );

define( 'WPYML_PLUGIN_DIR', untrailingslashit( dirname( WPYML_PLUGIN ) ) );

define( 'WPYML_PLUGIN_URL',
    untrailingslashit( plugins_url( '', WPYML_PLUGIN ) )
);

$WPYML_yandex_maps_array = array();

add_shortcode('yandex_map_lite','yandex_map_lite');

/**
 * @param $atts - тут переменные X,Y с координатами, zoom - масштаб карты
 * @param $content - текст для балуна
 */
function yandex_map_lite($atts, $content){
    $atts = shortcode_atts(
        array(
            'width'  => (!empty($atts['width'])) ? $atts['width'] : '100%',
            'height' => (!empty($atts['height'])) ? $atts['height'] : '400px',
            'x'      => (!empty($atts['x'])) ? $atts['x'] : 59.876146,
            'y'      => (!empty($atts['y'])) ? $atts['y'] : 30.292760,
            'zoom'   => (!empty($atts['zoom'])) ? $atts['zoom'] : 8,
            'hint'   => (!empty($atts['hint'])) ? $atts['hint'] : 'Наш офис',
            'header'   => (!empty($atts['header'])) ? $atts['header'] : '',
            'footer'   => (!empty($atts['footer'])) ? $atts['footer'] : ''

        ), $atts
    );
    $code   = rand(10000,99999);

    global $WPYML_yandex_maps_array;

    $WPYML_yandex_maps_array = array(
        'zoom'      => $atts['zoom'],
        'data_x'    => $atts['x'],
        'data_y'    => $atts['y'],
        'body'      => (!empty($content)) ? $content : '',
        'code'      => $code,
        'hint'      => $atts['hint'],
        'header'    => $atts['header'],
        'footer'    => $atts['footer']
    );

    add_action('wp_footer', 'WPYML_yandexMapScripts');

    return '<div id="yandex-map-'.$code.'" style="width: '.$atts['width'].'; height: '.$atts['height'].';"></div>';
}

/**
 * Подключение скриптов
 */
function WPYML_yandexMapScripts(){
    global $WPYML_yandex_maps_array;
    /**
     * зарезервировать и подключить стили
     */

    //code

    $api_key = 'AIzaSyBt7qY8x8hGdLNwPUfYcL3LLG1Wh1smbfs';
    /**
     * регистрация скриптов
     */
    //wp_register_script( 'yandexMapApi', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU' );
    wp_register_script('yandexMapScript', plugins_url( 'assets/script.js', __FILE__ ));


    /**
     * подключение скриптов
     */
    wp_enqueue_script('yandexMapScript');
    wp_enqueue_script('yandexMapApi');


    /**
     * Параматры для скрипта
     */
    wp_localize_script( 'yandexMapScript', 'mapObj', $WPYML_yandex_maps_array );
}