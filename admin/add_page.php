<?php
/**
* Подменю добавить площадку
*/
function wpyma_submenu_add_new(){
    add_submenu_page(
        'wpyma_main_menu',					//родительское меню настроек        
        __( 'WP Yandex Map', 'textdomain' ),//название (title)
        'Добавить',						    //название пункта меню
        'manage_options',					//уровень доступа
        'wpyma_add_new',					//уникальное название этого меню (slug) или имя файла с функциями вывода содержимого меню
        'wpyma_add_new_page'				//функция для вывода контента страницы с опциями
    );
}
add_action( 'admin_menu', 'wpyma_submenu_add_new' );

/**
 * Если попали на страницу 
 */
if($_GET['page'] == 'wpyma_add_new'){
    $yandex_maps_array = array();
    /**
     * Регистрация скрипта для админки
     */
    function enqueue_my_scripts() {

        global $yandex_maps_array;
        /**
         * зарезервировать и подключить стили
         */

        //code

        $api_key = 'AIzaSyBt7qY8x8hGdLNwPUfYcL3LLG1Wh1smbfs';
        /**
         * регистрация скриптов
         */
        wp_register_script( 'yandexMapApi', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU' );
        wp_register_script('yandexMapScriptAdmin', WPYMA_PLUGIN_URL.'/assets/script.js');

        
        /**
         * подключение скриптов
         */
        wp_enqueue_script('yandexMapScriptAdmin');
        wp_enqueue_script('yandexMapApi');
        
        /**
         * Параматры для скрипта
         */
        wp_localize_script( 'yandexMapScriptAdmin', 'mapObj', $yandex_maps_array );

    }

    /**
     * Страница с меткой
     */
    function wpyma_add_new_page(){
        $url_post = WPYMA_PLUGIN_URL.'/admin/post.php';
        $id_row = (int)$_GET['id_row'];

        if(isset($id_row) AND !empty($id_row)){
            /**
             * если есть айди значит это редактирование 
             * 1) надо получить данные по идентификатору из таблицы
             * 2) наполнить данными шаблон 
             */
            include 'select_db.php';
            $rez = new Select_db();
            $data_map = $rez->get_one_row($id_row);
            global $yandex_maps_array;
            /**
             * Добавление в глобальную переменную данных о метки
             *
             * zoom   - масштаб карты
             * data_x - центер карты по Х
             * data_y - центер карты по У
             * icon   - своя иконка значка
             * items  - передаем парметры точек на карты
             */
            $options_map = Options_Map::get_options_map(); //получение опцый карты
            $yandex_maps_array = array(
                'zoom'      => 10,
                'data_x'    => $data_map['coord_x'],
                'data_y'    => $data_map['coord_y'],
                'icon'      => $options_map['icon'],
                'size_icon' => $options_map['size_slug'],
                'items'  => [
                    [
                        'coords' => [$data_map['coord_x'], $data_map['coord_y']], 
                        'balloon' =>[
                            'balloonContentHeader' => $data_map['balloonContentHeader'],
                            'balloonContentBody'   => $data_map['balloonContentBody'],
                            'balloonContentFooter' => $data_map['balloonContentFooter'],
                            'hintContent'          => $data_map['title']
                        ],
                    ]
                ]  
            );
            /**
             * Регистрация скриптов для карты
             */
            add_action( 'admin_enqueue_scripts', enqueue_my_scripts() );
            extract($data_map);           
        }
        /**
         * подгрузка шаблона
         */
        ob_start();
        include WPYMA_PLUGIN_DIR.'/admin/contents/form.php';
        echo ob_get_clean();
    }
}