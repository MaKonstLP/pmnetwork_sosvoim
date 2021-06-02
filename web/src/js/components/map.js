'use strict';

export default class YaMap{
	constructor(){
        if (typeof ymaps == 'undefined') {
            $(document).ready(() => {
                setTimeout(()=>{
                   $.getScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU').done(() => {
                    this.mapInit();
                  }); 
                }, 1500);
            });
        } else {
            this.mapInit();
        }
		
	}

    mapInit(){
        ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
            center: [
                $('.map #map').data('mapdotx'),
                $('.map #map').data('mapdoty'),
            ],
            zoom: 13.5,
            behaviors: ["drag", "dblClickZoom", "rightMouseButtonMagnifier", "multiTouch"]
        }),

        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            // hintContent:    '\
            //                 <div class="ballon_content_text">\
            //                 <p class="ballon_content_address" href="#">'+ $('.map_rest_name').html() +'</p>\
            //                 <p class="ballon_content_address">'+ $('.map_rest_address').html() +'</p>\
            //             </div>\
            // ',
            // balloonContent: '\
            //                 <div class="balloon_content_wrap">\
            //                     <div class="balloon_content_img">\
            //                         <img src="'+ $('.map_img').attr('src') +'">\
            //                     </div>\
            //                     <div class="ballon_content_text">\
            //                         <div class="ballon_content_name">'+ $('.map_rest_name').html() +'</div>\
            //                         <p class="ballon_content_address">'+ $('.map_rest_address').html() +'</p>\
            //                     </div>\
            //                 </div>\
            // ',
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/img/iconMap.svg',
            iconImageSize: [65, 87],
            iconImageOffset: [-32, -87],
            // preset: 'islands#darkGreenIcon',
            // hideIconOnBalloonOpen: false,
            // balloonOffset: [0,-37],
        });

        myMap.geoObjects.add(myPlacemark); 
        
        // if($(window).width() > 600){
        //     myPlacemark.balloon.open();
        // }
        });
    }
}