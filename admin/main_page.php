<?php 
/**
 * Добавление меток на карту
 */
    function wpyma_main_menu_func(){
        echo '<div class="wrap">';
        echo "main page";
        echo wpyma_main_html();
        echo '</div>';
    }

    /**
     * Вывод таблицы с списком площадок
     */
    function wpyma_main_html(){
        /**
         * Формируем табличку
         */
        require_once 'view_table.php';
        $Table = new WPYMA_View_Table();
        $Table -> prepare_items();
        return $Table -> display();
    }