(function ($) {



    "use strict";
    
    new WOW().init();  
    
    
    /*---background image---*/
	function dataBackgroundImage() {
		$('[data-bgimg]').each(function () {
			var bgImgUrl = $(this).data('bgimg');
			$(this).css({
				'background-image': 'url(' + bgImgUrl + ')', // + meaning concat
			});
		});
    }
    
    
    $(window).on('load', function () {
        dataBackgroundImage();
    });

    /*swiper container activation*/
    var swiper = new Swiper('.slider_swiper', {
        clickable: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });


    // Slick Slider Activation
    var $sliderActvation = $('.slick_slider_activation');
    if($sliderActvation.length > 0){
        $sliderActvation.slick({
          prevArrow:'<button class="prev_arrow"><i class="ion-ios-arrow-left"></i></button>',
          nextArrow:'<button class="next_arrow"><i class="ion-ios-arrow-right"></i></button>',
        });
    };
    

    /*swiper container activation*/
    var swiper = new Swiper('.testimonial_swiper', {
        slidesPerView: 2,
        spaceBetween: 90,
        breakpoints: {
            1200: {
                spaceBetween: 90,
                
            },
            992: {
                spaceBetween: 30,
                
            },
            768: {
              slidesPerView: 2,
              spaceBetween: 30,
              
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 30,
                
            },
        },
        pagination: {
            clickable: true,
            el: '.swiper-pagination',
        },
    });


    //Shopping Cart addClass removeClass
    $('.shopping_cart > a').on('click', function(){
        $('.mini_cart,.body_overlay').addClass('active')
    });
    $('.mini_cart_close a,.body_overlay').on('click', function(){
        $('.mini_cart,.body_overlay').removeClass('active')
    });

   

   //Search Box addClass removeClass
   $('.header_search_btn > a').on('click', function(){
    $('.page_search_box').addClass('active')
    });
    $('.search_close > i').on('click', function(){
        $('.page_search_box').removeClass('active')
    });




    /*--- Magnific Popup Video---*/
    $('.video_popup').magnificPopup({
        type: 'iframe',
        gallery: {
            enabled: true
        }
    });

    $('.img_popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });


    /*--- counterup activation ---*/
    $('.counterup').counterUp({
        delay: 20,
        time: 1000
    });
    
    
    $('.select_option').niceSelect();
 
    
      /*---  ScrollUp Active ---*/
      $.scrollUp({
        scrollText: '<i class="ion-android-arrow-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });
    

    $('#nav-tab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    

    /*---canvas menu activation---*/
    $('.opener').on('click', function(){
        $('.offcanvas_menu_wrapper,.body_overlay').addClass('active')
    });
    
    $('.canvas_close,.body_overlay').on('click', function(){
        $('.offcanvas_menu_wrapper,.body_overlay').removeClass('active')
    });
    /*---Off Canvas Menu---*/
    var $offcanvasNav = $('.offcanvas_main_menu'),
        $offcanvasNavSubMenu = $offcanvasNav.find('.sub-menu');
    $offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="fa fa-angle-down"></i></span>');
    
    $offcanvasNavSubMenu.slideUp();
    
    $offcanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if ( ($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand')) ) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length){
                $this.siblings('ul').slideUp('slow');
            }else {
                $this.closest('li').siblings('li').find('ul:visible').slideUp('slow');
                $this.siblings('ul').slideDown('slow');
            }
        }
        if( $this.is('a') || $this.is('span') || $this.attr('clas').match(/\b(menu-expand)\b/) ){
        	$this.parent().toggleClass('menu-open');
        }else if( $this.is('li') && $this.attr('class').match(/\b('menu-item-has-children')\b/) ){
        	$this.toggleClass('menu-open');
        }
    });

   
   
    /************************************************
     * Price Slider
     ***********************************************/
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 500,
        values: [12, 500],
        slide: function(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });
    $("#amount").val("$" + $("#slider-range").slider("values", 0) +
        " - $" + $("#slider-range").slider("values", 1));
  
    

    //Quantity Counter
    $(".pro-qty").append('<a href="#" class="inc qty-btn">+</a>');
      $(".pro-qty").prepend('<a href="#" class= "dec qty-btn">-</a>');
    
      $(".qty-btn").on("click", function (e) {
        e.preventDefault();
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
          var newVal = parseFloat(oldValue) + 1;
        } else {
          // Don't allow decrementing below zero
          if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
          } else {
            newVal = 1;
          }
        }
        $button.parent().find("input").val(newVal);
    });

    
  
 


// RippleEffect

function addRippleEffect(link, effectClass) {
    link.addEventListener('click', function (e) {
        const rippleEffect = document.createElement('span');
        rippleEffect.className = `ripple-effect ${effectClass}`;

        const diameter = Math.max(link.offsetWidth, link.offsetHeight);
        const rect = link.getBoundingClientRect();
        const offsetX = e.clientX - rect.top;
        const offsetY = e.clientY - rect.top;
        const centerOffsetX = offsetX - (diameter / 2);
        const centerOffsetY = offsetY - (diameter / 2);
        rippleEffect.style.width = `${diameter}px`;
        rippleEffect.style.height = `${diameter}px`;
        rippleEffect.style.top = `${centerOffsetY}px`;
        rippleEffect.style.left = `${centerOffsetX}px`;

        document.body.appendChild(rippleEffect);

        // Sayfa yüklenme işlemi başlamadan önce efektin oynamaya başlamasını sağla
        requestAnimationFrame(function () {
            rippleEffect.style.transform = 'scale(1.5)';
        });

        // Sayfa yüklenme işlemi başladığında efektin kaybolma süresini başlat
        const pageLoadStart = Date.now();

        function updateEffect() {
            const elapsed = Date.now() - pageLoadStart;
            const speedMultiplier = 0.2; // İstediğiniz hız artışı için uygun bir değer

            if (elapsed < 1000) {
                requestAnimationFrame(updateEffect);
            }

            rippleEffect.style.transform = `scale(${1 + speedMultiplier * elapsed / 1000})`;
        }

        // updateEffect fonksiyonunu burada çağır
        updateEffect();

        // Sayfa yüklenme işlemi bitince efektin kaybolma süresini güncelle
        window.addEventListener('load', function () {
            const pageLoadTime = Date.now() - pageLoadStart;
            setTimeout(function () {
                rippleEffect.style.transition = `opacity ${pageLoadTime}ms`;
                rippleEffect.style.opacity = 0;

                setTimeout(function () {
                    document.body.removeChild(rippleEffect);
                    window.location.href = link.href;
                }, pageLoadTime);
            }, 0);
        });
    });
}

const links = [
    {
        element: document.getElementsByClassName('ripple-link')[0],
        effectClass: 'link1'
    },
    {
        element: document.getElementsByClassName('ripple-link12')[0],
        effectClass: 'link12'
    },
    {
        element: document.getElementsByClassName('ripple-link2')[0],
        effectClass: 'link2'
    },
    {
        element: document.getElementsByClassName('ripple-link22')[0],
        effectClass: 'link22'
    }
];

links.forEach(linkInfo => {
    if (linkInfo.element) {
        addRippleEffect(linkInfo.element, linkInfo.effectClass);
    }
});




      





   
 
  
  // Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 300);
	
		});
	}
	
  
 
  



// "fixed" classını "header" elementine ekleme işlemini ve animasyonu gerçekleştiren fonksiyon
function toggleFixedHeader() {
    const header = $(".header_section");
    const scrollTop = $(window).scrollTop();
    const offset = 500;
    const menuLinks = $(".main_menu nav > ul > li > a");
    const menuimg1 = $(".main_menu nav > ul > li > a > .img1");
    const menuimg2 = $(".main_menu nav > ul > li > a > .img2");
    
 



  // Check if the body tag has the "exclude-script" class
  if ($("body").hasClass("exclude-script")) {
    // If the class is present, do nothing or add any specific behavior for this page
    return;
}


    if (scrollTop > offset && !header.hasClass("fixed")) {
      header.stop().addClass("fixed").hide().fadeIn();
      // Başlık sabitlenince CSS stilini değiştiriyoruz
      menuLinks.css({
       
        "font-weight": "300",
        "font-size": "20px",
        "line-height": "41px",
        "text-transform": "uppercase",
        "color":"white",
        "text-shadow": "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000",
        "opacity": "0.5",
        
      });

      menuimg1.attr("src", "assets/img/animated-icon/white-magnifier.png");

      menuimg2.attr("src", "assets/img/animated-icon/shopping-cartwww.png");

    
    } else if (scrollTop <= offset && header.hasClass("fixed")) {
      header.removeClass("fixed");
      // Başlık sabitlenmesi kaldırılınca eski CSS stilini geri yüklüyoruz
      menuLinks.css({
      
        "font-weight": "600",
        "font-size": "17px",
        "line-height": "41px",
        "text-transform": "uppercase",
        "color":"black",
        "text-shadow": "none",
        "opacity": "1",
        "text-shadow": "2px 2px 0px black" /* Siyah gölge ekler */


      });

      menuimg1.attr("src", "assets/img/animated-icon/white-magnifier.png");

      menuimg2.attr("src", "assets/img/animated-icon/shopping-cartwww.png");


    }
  }
  
  // Sayfa yüklendiğinde başlık konumunu kontrol etmek için fonksiyonu çağırıyoruz
  toggleFixedHeader();
  
  // Sayfa kaydırıldığında "fixed" classını kontrol etmek için olay dinleyicisi ekliyoruz
  if (!$("body").hasClass("exclude-script")) {
  $(window).scroll(toggleFixedHeader);
}
  
  
  // Slick Slider Activation
  var $sliderActvation = $('.slick_slider_activation');
  if($sliderActvation.length > 0){
      $sliderActvation.slick({
        prevArrow:'<button class="prev_arrow"><i class="icon-arrow-left icons"></i></button>',
        nextArrow:'<button class="next_arrow"><i class="icon-arrow-right icons"></i></button>',
      });
  };


    
// Slick Slider Activation
    $('.zoom_tab_img').slick({
      centerMode: true,
      centerPadding: '0',
      slidesToShow: 4,
      arrows:false,
      vertical: true,
      focusOnSelect: true,
      asNavFor: '.product_zoom_main_img',
      responsive:[
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 3,
               vertical: false,  
                arrows: false,
            }
          },
          {
            breakpoint: 768,
            settings: {
                slidesToShow: 4,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
            }
          },
      ]

  });



  // Slick Slider Activation
  $('.product_zoom_main_img').slick({
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 1,
    arrows:false,
    vertical: true,
    asNavFor: '.zoom_tab_img',
    responsive:[
        {
          breakpoint: 576,
          settings: {
             vertical: false,  
          }
        },
    ]
});



document.querySelectorAll('.button').forEach(button => {
    let getVar = variable => getComputedStyle(button).getPropertyValue(variable);
  
    function animateButton(e) {
      e.stopPropagation();
  
      if (!button.classList.contains('active')) {
        button.classList.add('active');
  
        gsap.to(button, {
          keyframes: [{
            '--left-wing-first-x': 50,
            '--left-wing-first-y': 100,
            '--right-wing-second-x': 50,
            '--right-wing-second-y': 100,
            duration: .2,
            onComplete() {
              gsap.set(button, {
                '--left-wing-first-y': 0,
                '--left-wing-second-x': 40,
                '--left-wing-second-y': 100,
                '--left-wing-third-x': 0,
                '--left-wing-third-y': 100,
                '--left-body-third-x': 40,
                '--right-wing-first-x': 50,
                '--right-wing-first-y': 0,
                '--right-wing-second-x': 60,
                '--right-wing-second-y': 100,
                '--right-wing-third-x': 100,
                '--right-wing-third-y': 100,
                '--right-body-third-x': 60
              })
            }
          }, {
            '--left-wing-third-x': 20,
            '--left-wing-third-y': 90,
            '--left-wing-second-y': 90,
            '--left-body-third-y': 90,
            '--right-wing-third-x': 80,
            '--right-wing-third-y': 90,
            '--right-body-third-y': 90,
            '--right-wing-second-y': 90,
            duration: .2
          }, {
            '--rotate': 50,
            '--left-wing-third-y': 95,
            '--left-wing-third-x': 27,
            '--right-body-third-x': 45,
            '--right-wing-second-x': 45,
            '--right-wing-third-x': 60,
            '--right-wing-third-y': 83,
            duration: .25
          }, {
            '--rotate': 55,
            '--plane-x': -8,
            '--plane-y': 24,
            duration: .2
          }, {
            '--rotate': 40,
            '--plane-x': 45,
            '--plane-y': -180,
            '--plane-opacity': 0,
            duration: .3,
            onComplete() {
              setTimeout(() => {
                button.removeAttribute('style');
                gsap.fromTo(button, {
                  opacity: 0,
                  y: -8
                }, {
                  opacity: 1,
                  y: 0,
                  clearProps: true,
                  duration: .3,
                  onComplete() {
                    button.classList.remove('active');
                  }
                })
              }, 2000)
            }
          }]
        })
  
        gsap.to(button, {
          keyframes: [{
            '--text-opacity': 0,
            '--border-radius': 0,
            '--left-wing-background': getVar('--primary-darkest'),
            '--right-wing-background': getVar('--primary-darkest'),
            duration: .1
          }, {
            '--left-wing-background': getVar('--primary'),
            '--right-wing-background': getVar('--primary'),
            duration: .1
          }, {
            '--left-body-background': getVar('--primary-dark'),
            '--right-body-background': getVar('--primary-darkest'),
            duration: .4
          }, {
            '--success-opacity': 1,
            '--success-scale': 1,
            duration: .25,
            delay: .25
          }]
        })
      }
    }
  
    button.addEventListener('click', animateButton);
    button.addEventListener('touchend', animateButton);
  });




// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();



  /*-------------------------------------
        Product details big image slider
    ---------------------------------------*/
    $('.pro-dec-big-img-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        draggable: false,
        fade: false,
        asNavFor: '.product-dec-slider-small , .product-dec-slider-small-2',
    });
    
    /*---------------------------------------
        Product details small image slider
    -----------------------------------------*/
    $('.product-dec-slider-small').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.pro-dec-big-img-slider',
        dots: false,
        focusOnSelect: true,
        fade: false,
        prevArrow: '<span class="pro-dec-prev"><img class="injectable" src="./assets/icon-img/arrow-left-5.svg" alt=""></span>',
        nextArrow: '<span class="pro-dec-next"><img class="injectable" src="./assets/icon-img/arrow-right-5.svg" alt=""></span>',
        responsive: [{
                breakpoint: 767,
                settings: {
                    
                }
            },
            {
                breakpoint: 575,
                settings: {
                    autoplay: true,
                    slidesToShow: 4,
                }
            }
        ]
    });













})(jQuery);	


// 2. RESME GEÇİŞ EFEKTİ//

function showSecondImage(element) {
    var secondImage = element.querySelector('.second_image');
    if (secondImage) {
        secondImage.style.opacity = '1';
        element.querySelector('img:first-child').style.opacity = '0';
    }
}

function hideSecondImage(element) {
    var secondImage = element.querySelector('.second_image');
    if (secondImage) {
        secondImage.style.opacity = '0';
        element.querySelector('img:first-child').style.opacity = '1';
    }
}





