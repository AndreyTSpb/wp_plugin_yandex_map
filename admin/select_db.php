<?php
require_once 'base_for_work_with_db.php';
class Select_db extends BaseForWorkWithDB{
    public  $rezult;

    public function __construct(){
        parent::__construct();
    }

    public function get_one_row($id){
        $post = $this->db_connect->get_row(
            "SELECT * FROM ".$this->table_name." WHERE id = ".(int)$id
        );
        $title = $post->hint_content;
        $coord_x = $post->coord_x;
        $coord_y = $post->coord_y;
        $balloonContentHeader = $post->balloon_content_header;
        $balloonContentBody = $post->balloon_content_body;
        $balloonContentFooter = $post->balloon_content_footer;
        return(compact('title', 'coord_x', 'coord_y', 'balloonContentHeader', 'balloonContentBody', 'balloonContentFooter'));
    }
}
?>