<?php
    require_once WPYMA_PLUGIN_DIR.'/admin/base_for_work_with_db.php';
    class Select_db extends BaseForWorkWithDB{
        public  $rezult;

        public function __construct(){
            parent::__construct();
        }

        public function get_all_rows(){
            $rows = $this->db_connect->get_results(
                "SELECT * FROM ".$this->table_name
            );
            return $rows;
        }
    }