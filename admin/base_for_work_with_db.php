<?php

class BaseForWorkWithDB{
    protected $table_name; //имя таблицы с префиксом wp
    protected $db_connect; //подключение к бд

    public function  __construct(){
        global $wpdb;
        $this->db_connect = $wpdb;
        $this->wpyma_get_wpdb_prefix();
    }

    /**
     * Получение префикса wp
     */
    private function wpyma_get_wpdb_prefix () {
        $this->table_name = $this->db_connect->prefix . "wpyma_list_locations";
    }
} 