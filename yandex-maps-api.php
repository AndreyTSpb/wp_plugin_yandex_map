<?php 
/**
 * Plugin Name: Yandex Maps Api
 * Description: View google_maps: [yandex_maps x='50.447312' y='30.526511' zoom='5' ]Yandex Maps[/yandex_maps]
 * Plugin URI: https://elementor.com/?utm_source=wp-plugins&utm_campaign=plugin-uri&utm_medium=wp-dash
 * Author: tynyany.ru
 * Version: 1.0.1
 * Author URI: http://tynyany.ru
 *
 * Text Domain: Yandex Maps Api
 *
 * @package Yandex Maps Api
 */
$yandex_maps_array = array($atts);
add_shortcode('yandex_maps','yandex_maps_api');

function yandex_maps_api($atts, $content){
    global $yandex_maps_array;
    $atts = shortcode_atts(
        array(
            'width'  => (!empty($atts['width'])) ? $atts['width'] : '100%',
            'height' => (!empty($atts['height'])) ? $atts['height'] : '400px',
            'data_x' => (!empty($atts['x'])) ? $atts['x'] : 59.876146,
            'data_y' => (!empty($atts['y'])) ? $atts['y'] : 30.292760,
            'zoom'   => (!empty($atts['zoom'])) ? $atts['zoom'] : 8

        ), $atts
    );
    extract($atts);
    /**
     * zoom   - масштаб карты
     * data_x - центер карты по Х
     * data_y - центер карты по У
     * icon   - своя иконка значка
     * items  - передаем парметры точек на карты
     */
	$yandex_maps_array = array(
		'zoom'   => $zoom,
		'data_x' => $data_x,
		'data_y' => $data_y,
        'icon'   => plugins_url('assets/img/map-marker-red.png', __FILE__),
        'items'  => [
            [
                'coords' => [59.830249, 30.378764], 
                'balloon' =>[
                    'balloonContentHeader' => '<span> Буквоед <a class="blue-link float-right" href="/place_maps#location_40"><i class="fa fa-map-marker" aria-hidden="true"></i> Как нас найти</a></span>',
                    'balloonContentBody' => '<a href=" /groupsale/selectgroups?l=40 ">М. Купчино, Балканская пл., д.5, центр «Буквоед. Детям и Родителям.», 2этаж.</a><br><ul><li><a href=" /groupsale/selectgroups?l=40&amp;s=1 ">Математика</a><ul><li><a href=" /groupsale/selectgroups?l=40&s=1&t=2 ">Малая группа</a></li></ul></li></ul>',
                ],
            ],
            [
                'coords' => [59.926679, 30.41762], 
                'balloon' =>[
                    'balloonContentHeader' => '<span> ГБОУ № 533 (ЮМШ) <a class="blue-link float-right ml-3" href="/place_maps#location_16"><i class="fa fa-map-marker" aria-hidden="true"></i> Как нас найти</a></span>',
                    'balloonContentBody' => '<a href=" /groupsale/selectgroups?l=16 ">СПб, ул. Таллинская, д. 26, корп. 2</a> <br><ul> <li><a href=" /groupsale/selectgroups?l=16&amp;s=1 ">Математика</a> <ul> <li><a class="green-link" href=" /groupsale/selectgroups?l=16&s=1&t=1 ">Олимпиадная группа</a></li></ul> </li></ul>',
                ],
            ],
            [
                'coords' => [60.011401, 30.265796], 
                'balloon' =>[
                    'balloonContentHeader' => '<span> ГБОУ №45 <a class="blue-link float-right" href="/place_maps#location_17"><i class="fa fa-map-marker" aria-hidden="true"></i> Как нас найти</a></span>',
                    'balloonContentBody' => '<a href=" /groupsale/selectgroups?l=17 ">Спб, ул. Маршала Новикова, д.8, корп.2 лит А</a> <br><ul> <li><a href=" /groupsale/selectgroups?l=17&amp;s=1 ">Математика</a> <ul> <li><a class="green-link" href=" /groupsale/selectgroups?l=17&s=1&t=1 ">Олимпиадная группа</a></li></ul> </li></ul>',
                ]
            ]
        ]  
	);

    add_action('wp_footer', 'yandexMapScripts');
    return '<div id="yandex-map" style="width: '.$atts['width'].'; height: '.$atts['height'].';"></div>';
}

 /**
  * Подключение скриптов
  */
function yandexMapScripts(){
    global $yandex_maps_array;
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
    wp_localize_script( 'yandexMapScript', 'mapObj', $yandex_maps_array );
}