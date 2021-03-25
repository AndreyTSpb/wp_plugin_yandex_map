<?php
     /**
      * Получение данных о настройках карт из опций
      */
class Options_Map{
        /**
         * Получаем опции для карты из БД
         */
        static function get_options_map(){
            $options = get_option('wpyma_options'); //опции заданые через админку
            /** 
             * Array ( 
             *  [wpyma_apikey] => evefefevhr 
             *  [wpyma_slug_size] => 55,50 
             *  [wpyma_coords_center] => 59.830249,30.378764 
             *  [wpyma_zoom] => 5 
             *  [file] => http://math123-wordpress.local/wp-content/uploads/2021/03/map-marker-red-2.png 
             * )
             */
            //print_r($options);
            $coords   = explode(',', $options['wpyma_coords_center']);
            $arr_size = explode(',', $options['wpyma_slug_size']);
            return array(
                'zoom' => $options['wpyma_zoom'],
                'data_x' => (isset($coords[0])) ? $coords[0]:'',
                'data_y' => (isset($coords[1])) ? $coords[1]:'',
                'size_slug' => $arr_size,
                'icon'   => (isset($options['file'])) ? $options['file'] :plugins_url('assets/img/map-marker-red.png', __FILE__)
            );
        }
}
?>