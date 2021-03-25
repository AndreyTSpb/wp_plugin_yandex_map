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
defined('ABSPATH') or die('No script kiddies please!');

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

require_once WPYMA_PLUGIN_DIR.'/admin/get_options_map.php'; //получаем данные по опциям карты

//Регистрация функций, выполняемых при активации и деактивации плагина
//register_activation_hook(__FILE__, 'testplugin_install');
//register_deactivation_hook(__FILE__, 'testplugin_uninstall');


if(is_admin()){

    /**
     * Для работы с БД
     */
    require_once WPYMA_PLUGIN_DIR.'/admin/base_for_work_with_db.php';
     
    /**
     * Проверка есть ли в базе данных таблица для площадок
     */
    require_once WPYMA_PLUGIN_DIR.'/admin/create_db.php';
    /**
     * Переход на страницу админки
     */
    require_once WPYMA_PLUGIN_DIR.'/admin/admin.php';
}else{
    require_once 'frontend.php';
}