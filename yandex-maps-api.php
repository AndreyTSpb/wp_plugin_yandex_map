<?php 
/**
 * Plugin Name: Yandex Maps Api
 * Description: View google_maps: [yandex_maps x='50.447312' y='30.526511' zoom='5' ]Yandex Maps[/yandex_maps]
 * Plugin URI: https://github.com/AndreyTSpb/wp_plugin_yandex_map
 * Author: tynyany.ru
 * Version: 1.0.1
 * Author URI: http://tynyany.ru
 *
 * Text Domain: Yandex Maps Api
 *
 * @package Yandex Maps Api
 */
define( 'WPYMA_VERSION', '1.0.1' );

define( 'WPYMA_REQUIRED_WP_VERSION', '5.5' );

define( 'WPYMA_TEXT_DOMAIN', 'yandex_maps_api' );

define( 'WPYMA_PLUGIN', __FILE__ );

define( 'WPYMA_PLUGIN_BASENAME', plugin_basename( WPYMA_PLUGIN ) );

define( 'WPYMA_PLUGIN_NAME', trim( dirname( WPYMA_PLUGIN_BASENAME ), '/' ) );

define( 'WPYMA_PLUGIN_DIR', untrailingslashit( dirname( WPYMA_PLUGIN ) ) );

define( 'WPYMA_PLUGIN_URL',
	untrailingslashit( plugins_url( '', WPYMA_PLUGIN ) )
);


if(is_admin()){
    /**
     * Для работы с БД
     */
    require_once WPYMA_PLUGIN_DIR.'/admin/base_for_work_with_db.php';
     
    /**
     * Проверка есть ли в базе данных таблица для площадок
     */
    require_once WPYMA_PLUGIN_DIR.'/admin/create_db.php';
    require_once WPYMA_PLUGIN_DIR.'/admin/admin.php';
    //echo WPYMA_PLUGIN_DIR.'/admin/admin.php';
}else{
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
        $options_map = get_options_map();
        print_r($options_map);
        
        /**
         * zoom   - масштаб карты
         * data_x - центер карты по Х
         * data_y - центер карты по У
         * icon   - своя иконка значка
         * items  - передаем парметры точек на карты
         */
        $yandex_maps_array = array(
            'zoom'      => $options_map['zoom'],
            'data_x'    => $options_map['data_x'],
            'data_y'    => $options_map['data_y'],
            'icon'      => $options_map['icon'],
            'size_icon' => $options_map['size_slug'],
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
     * Получаем опции для карты из БД
     */
    function get_options_map(){
        $options = get_option('wpyma_options'); //опции заданые через админку
        /**
         * Array ( 
         *  [wpyma_apikey] => evefefevhr 
         *  [wpyma_slug_size] => 55,50 
         *  [wpyma_coords_center] => 59.830249,30.378764 
         *  [wpyma_zoom] => 5 
         *  [file] => http://math123-wordpress.local/wp-content/uploads/2021/03/map-marker-red-2.png 
         * )
         */
        //print_r($options);
        $coords   = explode(',', $options['wpyma_coords_center']);
        $arr_size = explode(',', $options['wpyma_slug_size']);
        return array(
            'zoom' => $options['wpyma_zoom'],
            'data_x' => (isset($coords[0])) ? $coords[0]:'',
            'data_y' => (isset($coords[1])) ? $coords[1]:'',
            'size_slug' => $arr_size,
            'icon'   => (isset($options['file'])) ? $options['file'] :plugins_url('assets/img/map-marker-red.png', __FILE__)
         );
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
}