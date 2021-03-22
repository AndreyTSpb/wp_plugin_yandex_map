
<?php
class Wpyma_Create_Db extends BaseForWorkWithDB{
    
    public function  __construct(){
        parent::__construct();
        if($this->wpyma_test_isset_table()){
            $this->wpyma_create_table();
        }
    }

    /**
     * Проверка на существование таблицы в БД
     */
    private function wpyma_test_isset_table(){
        if($this->db_connect->get_var("SHOW TABLES LIKE '".$this->table_name."'") != $this->table_name) {
            return true;
        }
        return false;
    }

    /**
     * Создание новой таблицы 
     */
    private function wpyma_create_table(){
        $sql = "CREATE TABLE " . $this->table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time bigint(11) DEFAULT '0' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            url VARCHAR(55) NOT NULL,
            UNIQUE KEY id (id)
          );";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }
}
$obj = new Wpyma_Create_Db();