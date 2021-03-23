<?php
require_once 'base_for_work_with_db.php';
class Wpyma_Update_Db extends BaseForWorkWithDB{
    private $id;
    private $coord_x;
    private $coord_y;
    private $hintContent;
    private $balloonContentHeader;
    private $balloonContentBody;
    private $balloonContentFooter;

    public  $rezult;

    public function  __construct($id_row, $coord_x, $coord_y, $hintContent, $balloonContentHeader, $balloonContentBody, $balloonContentFooter){
        parent::__construct();
        $this->id          = (int)$id_row;
        $this->coord_x     = $coord_x;
        $this->coord_y     = $coord_y;
        $this->hintContent = $hintContent;
        $this->balloonContentBody   = $balloonContentBody;
        $this->balloonContentHeader = $balloonContentHeader;
        $this->balloonContentFooter = $balloonContentFooter;
        $this->rezult = $this->wpyma_update_item();
    }

    private function wpyma_update_item() {
        // подготавливаем данные к запросу
        // подготавливаем данные   
        $coord_x = esc_sql($this->coord_x);
        $coord_y = esc_sql($this->coord_y);
        $hintContent = esc_sql($this->hintContent);
        $balloonContentBody   = $this->balloonContentBody;
        $balloonContentHeader = $this->balloonContentHeader;
        $balloonContentFooter = $this->balloonContentFooter;
 
         // вставляем строку в таблицу
         $rez = $this->db_connect->update($this->table_name,
             array( // значения которые заменяем
                'coord_x' => $coord_x,
                'coord_y' => $coord_y,
                'hint_content' => $hintContent,
                'balloon_content_header' => $balloonContentHeader,
                'balloon_content_body'   => $balloonContentBody,
                'balloon_content_footer' => $balloonContentFooter
             ),
             array( // значения по которым ищем нужную строку
                 'id' => $this->id
             ),
             array('%f', '%f', '%s', '%s', '%s','%s'), // тип значений данных которые добавляем
             array('%d') // тип значений данных по которым ищем строку
         );
         return $rez;
     }
}