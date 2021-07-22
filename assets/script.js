window.addEventListener("DOMContentLoaded", function(){
    jQuery(function($) {
        /**
         * zoom: "5",
         * data_x: null,
         * data_y: null,
         * text: "Yandex Maps",
         * code: "45035"
         */
        console.log(mapObj);

        ymaps.ready(WPYML_init);

        function WPYML_init () {
            var myMap = new ymaps.Map("yandex-map-"+mapObj.code, {
                    center: [54.83, 37.11],
                    zoom: 5
                }),
                myPlacemark = new ymaps.Placemark([+mapObj.data_x, +mapObj.data_y], {
                    // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
                    balloonContentHeader: mapObj.header,
                    balloonContentBody: mapObj.body,
                    balloonContentFooter: mapObj.footer,
                    hintContent: mapObj.hint
                });

            myMap.geoObjects.add(myPlacemark);
        }
    });
});