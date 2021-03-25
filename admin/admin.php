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

    /**
     * Отображение списка площадок
     */
    require_once 'main_page.php';

    add_action( 'admin_menu', 'wpyma_main_menu' );

    /**
     * Добавление площадок
     */
    require_once 'add_page.php';
    

    /**
     * Подключение страницы с настройками
     */
    require_once 'option_page.php';