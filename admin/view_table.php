<?php

/*файл с базовым (родительским классом)*/
if(class_exists('WP_List_Table') == FALSE)
{
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class WPYMA_View_Table extends WP_List_Table{
    /**
     * Обязательный метод, и его нужно переопределить. 
     * В противном случае ничего работать не будет. 
     * Он отвечает за получение данных, 
     * создание пагинации, сортировку
     */
    public function prepare_items()
    {
        //Sets
        $per_page = 5;

        /* Получаем данные для формирования таблицы */
        $data = $this -> table_data();

        /* Устанавливаем данные для пагинации */
        $this -> set_pagination_args( array(
            'total_items' => count($data),
            'per_page'    => $per_page
        ));

        /* Делим массив на части для пагинации */
        $data = array_slice(
            $data,
            (($this -> get_pagenum() - 1) * $per_page),
            $per_page
        );

        /* Устанавливаем данные колонок */
        $this -> _column_headers = array(
            $this -> get_columns(), /* Получаем массив названий колокнок */
            $this -> get_hidden_columns(), /* Получаем массив названий колонок которые нужно скрыть */
            $this -> get_sortable_columns() /* Получаем массив названий колонок которые можно сортировать */
        );

        /* Устанавливаем данные таблицы */
        $this -> items = $data;
    }

    /**
     * данный метод возвращает массив названий колонок нашей таблицы
     */
    public function get_columns()
    {
        return array(
            'ex_id'			=> 'ID',
            'ex_title'		=> 'Title',
            'ex_author'		=> 'Author',
            'ex_description'=> 'Description',
            'ex_price'		=> 'Price',
        );
    }

    /**
     * возвращает массив колонок которые нужно скрыть
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * метод, позволяет указать колонки, 
     * к которым будет применена сортировка 
     * (в таблице, возле названий этих заголовков отображается стрелочка, 
     * а сами заголовки выполнены ссылками)
     */
    public function get_sortable_columns()
    {
        return array(
            'ex_id' => array('ex_id', false),
            'ex_title' => array('ex_title', true),
            'ex_author' => array('ex_author', false),
            'ex_price' => array('ex_price', false),
        );
    }

    /**
     * test data
     */
    private function table_data()
    {
        return array(
            array(
                'ex_id'			=> 1,
                'ex_title'		=> 'Уличный кот по имени Боб',
                'ex_author'		=> 'Боуэн Джеймс',
                'ex_description'=> 'Мировой бестселлер!Готовится экранизация! Он был одиноким бездомным музыкантом, но увидел на',
                'ex_price'		=> '61,00',
            ),
            /* ... */
            array(
                'ex_id'			=> 13,
                'ex_title'		=> 'Кульбабове вино',
                'ex_author'		=> 'Брэдбери Рэй',
                'ex_description'=> 'Події повісті Рея Бредбері «Кульбабове вино» розгортаються влітку 1928 року у вигаданому містечку Гр… ',
                'ex_price'		=> '45,90',
            ),
        );
    }

    /**
     * метод отвечающий за обработку значений ячеек колонок
     */
    public function column_default($item, $column_name )
    {
        switch($column_name)
        {
            case 'ex_id':
            case 'ex_title':
            case 'ex_author':
            case 'ex_description':
            case 'ex_price':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }
}
?>