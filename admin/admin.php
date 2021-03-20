<?php 

    /**
     * регистрируем ссылку в главном меню админки
     */
    function wpyma_main_menu(){
        add_menu_page( 
            __( 'WP Yandex Map', 'textdomain' ),
            'WPYandexMap',
            'manage_options',
            'wpyma_main_menu',
            'wpyma_main_menu_func',
            'dashicons-location-alt',
            3
        );
    }

    add_action( 'admin_menu', 'wpyma_main_menu' );

    function wpyma_submenu1() {	
        add_submenu_page(
            'wpyma_main_menu',					//родительское меню настроек        
            __( 'WP Yandex Map', 'textdomain' ),		//название (title)
            'Настройки',						//название пункта меню
            'manage_options',					//уровень доступа
            'wpyma_options',					//уникальное название этого меню (slug) или имя файла с функциями вывода содержимого меню
            'wpyma_options_page'				//функция для вывода контента страницы с опциями
        );
    }
    add_action('admin_menu', 'wpyma_submenu1');

 
    /* Вывод страницы настроек плагина */
    function wpyma_options_page() {
        echo '<nodiv class="wrap">';
        screen_icon();                                    
        echo '<form id="wpyma_options" action="options.php" method="post" enctype="multipart/form-data">'; 
        do_settings_sections('wpyma_options');		//вывод блоков с полями формы для page (page из add_settings_section)               
        settings_fields('wpyma_options');	//выводит на экран скрытые поля input (группа опций из register_setting)                 
        submit_button();                                  
        echo '</form>';
        echo '</nodiv>';
    }

    /* регистрация настроек в системе */
    function wpyma_settings_init() {

        register_setting(
            'wpyma_options',			//группа опций (уникальное имя) используется в атрибуте name поля поля в форме ввода данных.
            'wpyma_options',			//под каким названием группа опций хранится в БД
            'wpyma_options_sanitize',	//функция проверки введенных данных данных
            'wpyma_options'				//page
        );
    
        add_settings_section(
            'wpyma_options',				//section id
            'Основные настройки яндекс.карт.',		//title
            'wpyma_options_desc',		//function
            'wpyma_options'				//page
        );
        /**
         * Ключ для подключения карт
         */
        add_settings_field(
            'wpyma_apikey_template', 		//id (равен id поля в форме ввода данных)
            'API KEY для яндекс карт',		//title
            'wpyma_apikey_field',			//функция вывода поля формы
            'wpyma_options',				//page
            'wpyma_options'					//section id в которую добавляем поле
        );
        /**
         * Загрузка своего ярлыка для значка
         */
        add_settings_field(
            'wpyma_slug_template',
            'Собственная картинка: ',		
            'wpyma_slug_field',
            'wpyma_options',
            'wpyma_options'
        );
        /**
         * размеры иконки в пикселях
         */
        add_settings_field(
            'wpyma_slug_size_template',
            'Размеры значка (в пикселях), через запятую:',		
            'wpyma_slug_size_field',
            'wpyma_options',
            'wpyma_options'
        );

        /**
         * Центер карты
         */
        add_settings_field(
            'wpyma_coords_center_template',
            'Укажите координаты центра карты, через запятую:',		
            'wpyma_coords_center_field',
            'wpyma_options',
            'wpyma_options'
        );
        /**
         * Масштаб карты
         */
        add_settings_field(
            'wpyma_zoom_template',
            'Масштаб карты:',		
            'wpyma_zoom_field',
            'wpyma_options',
            'wpyma_options'
        );
    }
    
    add_action('admin_init', 'wpyma_settings_init');

    /* описание */
    function wpyma_options_desc() {
        echo "<p>На данной странице перечислены основные настройки для яндекс.карт, а также настройки темы оформления.</p>";
        $options = get_option( 'wpyma_options' );
        //print_r($options);
        if( !empty($options['file']) ){
            $str_size = $options['wpyma_slug_size'];
            $arr_size = explode(',', $str_size);
            $width  = (!empty($arr_size[0])) ? $arr_size[0] : '45px';
            $heigth = (!empty($arr_size[1])) ? $arr_size[1] : '40px';
            echo "<p><img src='{$options['file']}' alt='' width='".$width."' height = '".$heigth."'></p>";
        }
    }

/* вывод полей */

/**
 * поле для ввода API KEY яндекс
 */
    function wpyma_apikey_field(){
        $options = get_option('wpyma_options');
        $showApiKey = (isset($options['wpyma_apikey'])) ? 'value='.$options['wpyma_apikey'] : "placeholder = 'УКАЖИТЕ СВОЙ КЛЮЧ...'";
        echo '<input type="text" id="wpyma_apikey_template" name="wpyma_options[wpyma_apikey]"'.$showApiKey.'>';
    }
/**
 * Поле для ввода координат центра карты
 */
    function wpyma_coords_center_field(){
        $options = get_option('wpyma_options');
        $showCoords = (isset($options['wpyma_coords_center'])) ? 'value='.$options['wpyma_coords_center'] : "placeholder = 'Укажите координаты центра каты'";
        echo '<input type="text" id="wpyma_coords_center_template" name="wpyma_options[wpyma_coords_center]"'.$showCoords.'>';
    }

/**
 * Поле для ввода размера ярлычка 
 */
    function wpyma_slug_size_field(){
        $options = get_option('wpyma_options');
        $showSlugSize = (isset($options['wpyma_slug_size'])) ? 'value='.$options['wpyma_slug_size'] : "placeholder = 'Укажите размер ярлычка на карте'";
        echo '<input type="text" id="wpyma_slug_size_template" name="wpyma_options[wpyma_slug_size]"'.$showSlugSize.'>';
    }

/**
 * Поле для ввода размера ярлычка 
 */
function wpyma_zoom_field(){
    $options = get_option('wpyma_options');
    $showZoom = (isset($options['wpyma_zoom'])) ? 'value='.$options['wpyma_zoom'] : "placeholder = ''";
    echo '<input type="text" id="wpyma_zoom_template" name="wpyma_options[wpyma_zoom]"'.$showZoom.'>';
}


/**
 * Поле для загрузки картинки
 */
    function wpyma_slug_field(){
        $options  = get_option('wpyma_options');
        $showSlug = (isset($options['wpyma_slug'])) ?  'value='.$options['wpyma_slug'] : "placeholder = 'Укажите картинку'";
        echo '<input type="file" id="wpyma_slug_template" name="wpyma_slug" '.$showSlug.'>';
    }

/**
 * Валидация введенных данных
 */
    function wpyma_options_sanitize($options){
        /*
        Array ( 
            [wpyma_apikey] => evefefevhr 
            [wpyma_slug_size] => 40,40 
            [wpyma_coords_center] => 30.4545,54.5555 
            ) 
        $_POST    
        Array ( 
            [wpyma_options] => Array ( 
                [wpyma_apikey] => evefefevhr 
                [wpyma_slug_size] => 40,40 
                [wpyma_coords_center] => 30.4545,54.5555 
                ) 
            [option_page] => wpyma_options 
            [action] => update 
            [_wpnonce] => 4424296da6 
            [_wp_http_referer] => /wp-admin/admin.php?page=wpyma_options 
            [submit] => Сохранить изменения 
            )
        $_FILES 
        Array (
            [wpyma_slug] => Array
                    (
                        [name] => map-marker-red.png
                        [type] => image/png
                        [tmp_name] => /Applications/MAMP/tmp/php/php7IGVU8
                        [error] => 0
                        [size] => 24922
                    )
            )
        // */
        // echo "<pre>";
        // print_r($options);
        // print_r($_FILES);
        // print_r($_POST);
        // echo "</pre>";
        // exit;
        if( !empty($_FILES['wpyma_slug']['tmp_name']) ){
            $overrides = array('test_form' => false);
            $file = wp_handle_upload( $_FILES['wpyma_slug'], $overrides );
            $options['file'] = $file['url'];
        }else{
            $old_oprions = get_option( 'wpyma_options' );
            $options['file'] = $old_oprions['file'];
        }
    
        $clean_options = array();
        foreach($options as $k => $v){
            $clean_options[$k] = strip_tags($v);
        }
        return $clean_options;
    }