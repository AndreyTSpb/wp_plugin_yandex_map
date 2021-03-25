<?php
    require_once 'include/select_place.php';
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
        $options_map = Options_Map::get_options_map();
        
        /**
         * zoom   - масштаб карты
         * data_x - центер карты по Х
         * data_y - центер карты по У
         * icon   - своя иконка значка
         * items  - передаем парметры точек на карты
         */
        $items = get_place();
        $yandex_maps_array = array(
            'zoom'      => $options_map['zoom'],
            'data_x'    => $options_map['data_x'],
            'data_y'    => $options_map['data_y'],
            'icon'      => $options_map['icon'],
            'size_icon' => $options_map['size_slug'],
            'items'     => $items  
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

    /**
    * Создаем массив с обьектами для карты
    */
    function get_place(){
        $obj_places = new Select_db();

        $items = array();
        $rows = $obj_places->get_all_rows();
        if(empty($rows)) return false;
        foreach($rows as $item){
            $items[] = [
                'coords' => [$item->coord_x, $item->coord_y], 
                'balloon' =>[
                    'balloonContentHeader' => $item->balloon_content_header,
                    'balloonContentBody'   => $item->balloon_content_body,
                    'balloonContentFooter' => $item->balloon_content_footer,
                    'hintContent'          => $item->hint_content
                ]
            ]; 
        }
        return $items;
    }