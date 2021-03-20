let yandex_map = document.querySelector('#yandex-map');

if(yandex_map != null){
// Функция ymaps.ready() будет вызвана, когда
// загрузятся все компоненты API, а также когда будет готово DOM-дерево.
ymaps.ready(init_yandex_map);
    function init_yandex_map(){
          // Создание карты.
          let myMap = new ymaps.Map("yandex-map", {
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
              iconImageSize: mapObj.size_icon,
              // Смещение левого верхнего угла иконки относительно
              // её "ножки" (точки привязки).
              iconImageOffset: [-5, -38]
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
}