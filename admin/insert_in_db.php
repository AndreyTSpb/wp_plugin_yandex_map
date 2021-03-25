<?php
require_once 'base_for_work_with_db.php';

class Wpyma_Insert extends BaseForWorkWithDB{
    private $coord_x;
    private $coord_y;
    private $hintContent;
    private $balloonContentHeader;
    private $balloonContentBody;
    private $balloonContentFooter;

    public  $rezult;

    public function  __construct($coord_x, $coord_y, $hintContent, $balloonContentHeader, $balloonContentBody, $balloonContentFooter){
        parent::__construct();
        $this->coord_x     = $coord_x;
        $this->coord_y     = $coord_y;
        $this->hintContent = $hintContent;
        $this->balloonContentBody   = $balloonContentBody;
        $this->balloonContentHeader = $balloonContentHeader;
        $this->balloonContentFooter = $balloonContentFooter;
        $this->rezult = $this->wpyma_insert_item();
    }

    /**
     * добавление строки в бд
     */
    private function wpyma_insert_item() {
        // подготавливаем данные   
        $coord_x = esc_sql($this->coord_x);
        $coord_y = esc_sql($this->coord_y);
        $hintContent = esc_sql($this->hintContent);
        $balloonContentBody   = $this->balloonContentBody;
        $balloonContentHeader = $this->balloonContentHeader;
        $balloonContentFooter = $this->balloonContentFooter;
        // вставляем строку в таблицу
        $rez = $this->db_connect->insert(
                $this->table_name, array(
                    'coord_x' => $coord_x,
                    'coord_y' => $coord_y,
                    'hint_content' => $hintContent,
                    'balloon_content_header' => $balloonContentHeader,
                    'balloon_content_body'   => $balloonContentBody,
                    'balloon_content_footer' => $balloonContentFooter
                ), array('%f', '%f', '%s', '%s', '%s', '%s')
        );
        return $this->db_connect->insert_id;
    }
}
?>