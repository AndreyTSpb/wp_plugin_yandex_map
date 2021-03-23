<?php
?>
<div class="wrap" id="wpcf7-contact-form-list-table">
    <h1 class="wp-heading-inline"><?=(isset($title))?'Редактируем: '.$title: 'Добавить новую метку'?></h1>
    <hr class="wp-header-end">
    <form method="POST" action="<?=$url_post?>">
        <input type="hidden" name="id_row" value = "<?=(isset($id_row)?$id_row:"");?>">
        <fieldset>
            <legend>
                 Внесение данных для меток на карте.</br>
                 Данные можно добавлять c html  тегами, чтобы сформировать свое оформление. 
            </legend>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="coord_x">Координаты по оси Х</label>
                        </th>
                        <td>
                            <input type="text" id="coord_x" name="coord_x" class="code" size="20" value="<?=(isset($coord_x) ? $coord_x : '');?>" >
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="coord_y">Координаты по оси Y</label>
                        </th>
                        <td>
                            <input type="text" id="coord_y" name="coord_y" class="code" size="20" value="<?=(isset($coord_y) ? $coord_y : '');?>">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="hintContent">Хинт метки</label>
                        </th>
                        <td>
                            <input type="text" id="hintContent" name="hintContent" class="code" size="70" value="<?=(isset($title) ? $title : '');?>">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="balloonContentHeader">Загаловок баллуна</label>
                        </th>
                        <td>
                            <?php wp_editor( 
                                    (isset($balloonContentHeader)) ? $balloonContentHeader:'', 
                                    'ballooncontentheader', 
                                    $settings = array(
                                        'wpautop'       => 0,
                                        'media_buttons' => 0,
                                        'textarea_name' => 'balloonContentHeader', //нужно указывать!
                                        'textarea_rows' => 10,
                                        'tabindex'      => null,
                                        'editor_css'    => '',
                                        'editor_class'  => 'code',
                                        'teeny'         => 1,
                                        'dfw'           => 0,
                                        'tinymce'       => 1,
                                        'quicktags'     => 1,
                                        'drag_drop_upload' => false
                                    ) 
                                )
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="balloonContentBody">Тело баллуна</label>
                        </th>
                        <td>
                            <?php wp_editor( 
                                    (isset($balloonContentBody)) ? $balloonContentBody:'', 
                                    'ballooncontentbody', 
                                    $settings = array(
                                        'wpautop'       => 0,
                                        'media_buttons' => 0,
                                        'textarea_name' => 'balloonContentBody', //нужно указывать!
                                        'textarea_rows' => 10,
                                        'tabindex'      => null,
                                        'editor_css'    => '',
                                        'editor_class'  => 'code',
                                        'teeny'         => 0,
                                        'dfw'           => 0,
                                        'tinymce'       => 1,
                                        'quicktags'     => 1,
                                        'drag_drop_upload' => false
                                    ) 
                                )
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="balloonContentFooter">Подвал баллуна</label>
                        </th>
                        <td>
                            <?php wp_editor( 
                                    (isset($balloonContentFooter)) ? $balloonContentFooter:'', 
                                    'ballooncontentfooter', 
                                    $settings = array(
                                        'wpautop'       => 0,
                                        'media_buttons' => 0,
                                        'textarea_name' => 'balloonContentFooter', //нужно указывать!
                                        'textarea_rows' => 10,
                                        'tabindex'      => null,
                                        'editor_css'    => '',
                                        'editor_class'  => 'code',
                                        'teeny'         => 1,
                                        'dfw'           => 0,
                                        'tinymce'       => 1,
                                        'quicktags'     => 1,
                                        'drag_drop_upload' => false
                                    ) 
                                )
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= submit_button();?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</div>