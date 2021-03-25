window.addEventListener("DOMContentLoaded", function(){
    /**
     * Функция для создания карты
     */
    function init_yandex_map(){

        // Создание карты.
        let myMap = new ymaps.Map(id_div, {
            center: [+mapObj.data_x, +mapObj.data_y],
            zoom: +mapObj.zoom
        }),
        yellowCollection = new ymaps.GeoObjectCollection(null, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: mapObj.icon,
            // Размеры метки.
            //iconImageSize: mapObj.size_icon,
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageSize: [45, 45],
            iconImageOffset: [-3, -42],
        });
    
    // Данные для карты
        let items = mapObj.items;
        for (var i = 0, l = items.length; i < l; i++) {
            let data = items[i];
            console.log(data);
            yellowCollection.add(new ymaps.Placemark(data['coords'], data['balloon']));
        }
        myMap.geoObjects.add(yellowCollection);
    }


    /**
     * Карта отображаемая на сайте
     */
    let yandex_map = document.querySelector('#yandex-map');

    if(yandex_map != null){
        // Функция ymaps.ready() будет вызвана, когда
        // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
        var id_div = yandex_map.getAttribute('id'); // идентификатор блока для карты
        console.log(id_div);
        ymaps.ready(init_yandex_map);
    }


    /**
     * карта отображаемая в админке, при редактировании площаки
     */
    let yandex_map_preview = document.querySelector('#yandex-map-preview');
    if(yandex_map_preview != null){
        var id_div = yandex_map_preview.getAttribute('id'); // идентификатор блока для карты
        ymaps.ready(init_yandex_map);
    }
});