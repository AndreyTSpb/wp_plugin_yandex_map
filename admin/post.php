<?php 
/**
 * Обработка POST запросов с форм админки
 */

/**
 * Array ( 
 *      [coord_x] => 
 *      [coord_y] => 
 *      [hintContent] => 
 *      [balloonContentHeader] => 
 *      [balloonContentBody] => 
 *      [balloonContentFooter] => 
 *      [submit] => Сохранить изменения 
 * )
 */
/**
 * Добавление новой записи в БД
 */
// формируем путь 
$url = (!empty($_SERVER['HTTPS'])) ? 
       "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] 
        : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$url = $_SERVER['REQUEST_URI'];
$my_url = explode('wp-content' , $url);
$path = $_SERVER['DOCUMENT_ROOT']."/".$my_url[0];
 
// подключаем
include_once $path . '/wp-config.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';
 
global $wpdb;  // теперь переменная $wpdb доступна
//далее работа с $wpdb

 if(isset($_POST['submit'])){
    $_POST = array_map( 'stripslashes_deep', $_POST ); //отключаем экранирование кавычек
     
    $id_row      = (int)$_POST['id_row'];
    $coord_x     = (float)$_POST['coord_x'];
    $coord_y     = (float)$_POST['coord_y'];
    $hintContent =  $_POST['hintContent'];
    $balloonContentHeader = $_POST['balloonContentHeader'];
    $balloonContentBody   = $_POST['balloonContentBody'];
    $balloonContentFooter = $_POST['balloonContentFooter'];
    if(empty($_POST['id_row'])){
        /**
         * подключаем класс для добавления новой записи в БД
         */
        require_once 'insert_in_db.php';
        $insert = new Wpyma_Insert($coord_x, $coord_y, $hintContent, $balloonContentHeader, $balloonContentBody, $balloonContentFooter);
        $id_row = $insert->rezult;
        header("Location: /wp-admin/admin.php?page=wpyma_add_new&id_row=".$id_row);
        exit;
    }else{
        /**
         * Подключаем клас для обновления записи
         */
        require_once 'update_db.php';
        $update = new Wpyma_Update_Db($id_row, $coord_x, $coord_y, $hintContent, $balloonContentHeader, $balloonContentBody, $balloonContentFooter);
        header("Location: /wp-admin/admin.php?page=wpyma_add_new&id_row=".$id_row);
        exit;
    }
 }else{
     echo "????";
     exit;
 }
