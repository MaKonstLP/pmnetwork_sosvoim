'use strict';
import Swiper from 'swiper';

export default class Slider{
	constructor(){
		self = this;
		this.swiperArr = [];

		//if($(window).width() <= 1650){
		if ($('[data-gallery-main-swiper]').length >0) self.initSwiperItem($('[data-gallery-main-swiper]'), $('[data-gallery-thumb-swiper]'));	
		if ($('[data-other-objects-swiper]').length >0) self.initSwiperSameItem($('[data-other-objects-swiper]'));
		if ($('[data-other-rest-swiper]').length >0) self.initSwiperSameRest($('[data-other-rest-swiper]'));
		if ($('[data-other-blogs-swiper]').length >0) self.initSwiperSameBlogs($('[data-other-blogs-swiper]'));	
		if ($('[data-gallery-blog-swiper]').length >0) self.initSwiperTitleBlog($('[data-gallery-blog-swiper]'));
		if ($('[data-gallery-post-swiper]').length >0) $('[data-gallery-post-swiper]').each(function() { self.initSwiperBlog($(this), $(this).siblings('[data-gallery-post-thumb-swiper]'))});	
		//self.initSwiper1($('[data-gallery-main-swiper] [data-gallery-list]'));
	//}
		$('body').on('click', '[data-gallery-img-view]', function () {
            let slider = $(this).closest('[data-gallery-swiper]');
            let active = $(this).closest('[data-swiper-slide-index]').attr('data-swiper-slide-index');
            let slider_popup = $('[data-gallery-img-swiper]');
            let sliders = slider.find('.swiper-slide').not('.swiper-slide-duplicate').each(function(){
            	slider_popup.find('[data-gallery-list]').append('<div class="object swiper-slide">'+$(this).find('.object_img').html()+'</div');
            });
            slider_popup.find('[data-gallery-img-view]').each(function(){$(this).removeAttr('data-gallery-img-view')});
            slider_popup.find('.swiper-slide').removeClass('swiper-slide-duplicate-active swiper-slide-active');
            slider_popup.find('[data-swiper-slide-index="'+active+'"]').addClass('swiper-slide-active');
            // $('.popup_wrap .popup_form').hide();
            // $('.popup_wrap .popup_form_recall').hide();
            $('.popup_wrap .popup_img').show();
            $('.popup_wrap').not('.popup_phone_wrap').addClass('_active');
            self.initSwiperPopup(slider_popup, active);
        });

		$(window).on('resize', function(){
			//if($(window).width() <= 1650){
				/*if(self.swiperArr.length == 0){
					$('[data-widget-wrapper]').each(function(){
						self.initSwiper($(this).find('[data-listing-wrapper]'));
					});
				}	*/				
			/*}
			else{
				$.each(self.swiperArr, function(){
					this.destroy(true, true);
				});
				self.swiperArr = [];
			}*/
		});
	}

	initSwiperItem($container_main, $container_thumb){
		let galleryThumbs = new Swiper($container_thumb, {
	      	spaceBetween: 20,
	      	slidesPerView: 6,
	      	watchSlidesVisibility: false,
     		watchSlidesProgress: false,
	      	centerInsufficientSlides: false,
	      	//centeredSlides: true,
	      	slideToClickedSlide: false,
			breakpoints: {
				720:{
					spaceBetween: 14,
				}
			}
	    });
		

		let galleryTop = new Swiper($container_main, {
	      spaceBetween: 0,
	      slidesPerView: 1,
	      centeredSlides: true,
	      loop: true,
	      init: false,
	      navigation: {
	        nextEl: '.listing_widget_arrow._next',
          	prevEl: '.listing_widget_arrow._prev',
	      },
	      thumbs: {
	        swiper: galleryThumbs
	      },
	    //   pagination: {
		//               el: '.listing_widget_pagination',
		//               type: 'bullets',
		//             },

	      breakpoints: {
			slidesPerView: 1,
	        	1920:{
	        		slidesPerView: 1,
	        	},
	        	600:{
	        		slidesPerView: 1,
	        		// pagination: {
		            //   el: '.listing_widget_pagination',
		            //   type: 'bullets',
		            // },
	        	}
	        }
	    });

	    let setActive = function() {
      		let activeIndex = galleryTop.realIndex+1;
       		let slidesCount = $(galleryTop.el).find('.swiper-slide').not('.swiper-slide-duplicate').length;
			let activeSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child(' + activeIndex + ')');
          	let nextSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex + 1)+')').length > 0 ? $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex + 1)+')') : $('[data-gallery-thumb-swiper] .swiper-slide:nth-child(1)');
          	let prevSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex - 1)+')').length > 0 ? $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex - 1)+')') : $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+slidesCount+')');
          	$('[data-gallery-thumb-swiper] .swiper-slide').each(function(){$(this).removeClass('swiper-slide-virtual-active')});
          	nextSlide.addClass('swiper-slide-virtual-active');
          	prevSlide.addClass('swiper-slide-virtual-active');
      	};

		galleryTop.on('slideChange', function () {
          	setActive();
          	this.thumbs.swiper.slideTo(this.realIndex, false,false);
        });

		galleryTop.on('init', function () {
			setActive();
		});

		galleryTop.init();
	}

	initSwiperBlog($container_main, $container_thumb){
		let galleryThumbs = new Swiper($container_thumb, {
	      	spaceBetween: 4,
	      	slidesPerView: 8,
	      	watchSlidesVisibility: true,
     		watchSlidesProgress: true,
	      	//centerInsufficientSlides: true,
	      	//centeredSlides: true,
	      	slideToClickedSlide: true,
	      	breakpoints: {
	        	768:{
	        		slidesPerView: 6,
	        	}
	        }
	    });
		

		let galleryTop = new Swiper($container_main, {
	      spaceBetween: 0,
	      slidesPerView: 1,
	      centeredSlides: true,
	      loop: true,
	      init: false,
	      /*navigation: {
	        nextEl: '.listing_widget_arrow._next',
          	prevEl: '.listing_widget_arrow._prev',
	      },*/
	      thumbs: {
	        swiper: galleryThumbs
	      },
	      pagination: {
		              el: '.listing_widget_pagination',
		              type: 'bullets',
		            },

	      breakpoints: {
	        	1920:{
	        		pagination: {
		              el: '.listing_widget_pagination',
		              type: 'bullets',
		            },
	        	}
	        }
	    });

	    let setActive = function() {
      		let activeIndex = galleryTop.realIndex+1;
       		let slidesCount = $(galleryTop.el).find('.swiper-slide').not('.swiper-slide-duplicate').length;
			let activeSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child(' + activeIndex + ')');
          	let nextSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex + 1)+')').length > 0 ? $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex + 1)+')') : $('[data-gallery-thumb-swiper] .swiper-slide:nth-child(1)');
          	let prevSlide = $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex - 1)+')').length > 0 ? $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+(activeIndex - 1)+')') : $('[data-gallery-thumb-swiper] .swiper-slide:nth-child('+slidesCount+')');
          	$('[data-gallery-thumb-swiper] .swiper-slide').each(function(){$(this).removeClass('swiper-slide-virtual-active')});
          	nextSlide.addClass('swiper-slide-virtual-active');
          	prevSlide.addClass('swiper-slide-virtual-active');
      	};

		galleryTop.on('slideChange', function () {
          	setActive();
          	this.thumbs.swiper.slideTo(this.realIndex, false,false);
        });

		galleryTop.on('init', function () {
			setActive();
		});

		galleryTop.init();
	}

	initSwiperSameItem($container){

		let swiper = new Swiper($container, {
	        slidesPerView: 3,
	        spaceBetween: 30,
	        loop: false,
	        navigation: {
              nextEl: '.rooms_widget_arrow._next',
              prevEl: '.rooms_widget_arrow._prev',
            },
	        breakpoints: {
	        	1470:{
	        		slidesPerView: 2,
	        		spaceBetween: 30,
	        	},
				720:{
					slidesPerView: 1,
					spaceBetween: 0,
				}
	        }
	    });

	    let swiper_var = $container.swiper;
	}

	initSwiperSameRest($container){
		let swiper = new Swiper($container, {
	        slidesPerView: 3,
	        spaceBetween: 30,
	        loop: false,
	        navigation: {
              nextEl: '.other_widget_arrow._next',
              prevEl: '.other_widget_arrow._prev',
            },
	        breakpoints: {
	        	1470:{
	        		slidesPerView: 2,
	        		spaceBetween: 30,
	        	},
				720:{
					slidesPerView: 1,
	        		spaceBetween: 0,
				},
	        }
	    });

	    let swiper_var = $container.swiper;
	}

	initSwiperSameBlogs($container){
		let swiper = new Swiper($container, {
	        slidesPerView: 3,
	        spaceBetween: 30,
	        loop: false,
	        navigation: {
              nextEl: '.blogs_widget_arrow._next',
              prevEl: '.blogs_widget_arrow._prev',
            },
	        breakpoints: {
				1470:{
					slidesPerView: 3,
				},
	        	600:{
	        		slidesPerView: 2,
	        	},
	        	450:{
	        		slidesPerView: 1.15,
					spaceBetween: 10,
	        	},
	        }
	    });

	    let swiper_var = $container.swiper;
	}

	initSwiperTitleBlog($container){
		let swiper = new Swiper($container, {
	        slidesPerView: 3,
	        spaceBetween: 30,
	        loop: false,
	        navigation: {
              nextEl: '.listing_widget_arrow._next',
              prevEl: '.listing_widget_arrow._prev',
            },
	        breakpoints: {
				1470:{
					slidesPerView: 3,
				},
	        	600:{
	        		slidesPerView: 2,
	        	},
	        	450:{
	        		slidesPerView: 1.15,
					spaceBetween: 10,
	        	},
	        }
	    });
	}

	initSwiperPopup($container, $start){
		let swiper_popup = new Swiper($container, {
	        slidesPerView: 1,
	        spaceBetween: 50,
	        loop: false,
	        initialSlide: $start,
	        autoHeight: true,
	        navigation: {
              nextEl: '.slider_arrow._next',
              prevEl: '.slider_arrow._prev',
            },
            breakpoints: {
	        	768:{
	        		autoHeight: false,
	        	}
	        },
	    });
	}
}