
$(document).ready(function() {
    var portfolioShowed = true;
    
    $(".scroll").click(function(event){ // When a link with the .scroll class is clicked
        event.preventDefault(); // Prevent the default action from occurring
        $('html,body').animate({
            scrollTop: ($(this.hash).offset().top - 80) 
        }, 500); 
//        setActiveMenuLink($(this).attr('id'));
    });
    
    startSloganScroll();
    pagesCarouselInit();
    servicesCarouselStart();
    setCircles();
    countdown();
    setInterval(countdown, 1000);
    
    $('body').scrollspy({ target: '.navbar-scrollspy' })
    
    setForms();
    
    $('.tarif-btn').click(function() {
        window.scrollTo(0,2000);
        $('#tarif-form-tarif').val($(this).attr('data-tarif'));
        $('#tarif-form').fadeIn();
        $('#tarif-form').click(function(e){
            if ( e.target.nodeName != 'INPUT' && 
                    e.target.nodeName != 'H2' && 
                    e.target.nodeName != 'P') 
            {
                $(this).fadeOut();
            }       
        });
    });
    
    $('.pages_form_btn').click(function(){
        $(this).fadeOut(function(){
            $(this).siblings('.pages_form').fadeIn();
        });
    });
    
    $('#portfolio').easyab({
        'slot': 1,
        'name': 'portfolio-show',
        'default-value': 'block',
        'alternatives': [{
            'value': 'none',
            'alternative': function($this) {
                $('#portfolio').hide();
                $('#menu-portfolio').parents('li').hide();
                portfolioShowed = false;
            }},
            {'value': 'block',
             'alternative': function($this) {
                 $('#portfolio').show();
                 $('#menu-portfolio').parents('li').show();
                 portfolioShowed = true;
            }}
        ]
    });
    
    $('#brif-req-btn').click(function(){
        $('#brif-btns').fadeOut(function(){
            $('#brif-req-form').fadeIn();
        });
    });
    
    $('#show_portfoilio_form').click(function(){
        $(this).fadeOut(200, function(){
            $('#get_portfoilio_form').fadeIn();
        });
    });
    
    if ( typeof window.addEventListener != "undefined" ) {
        window.addEventListener("load", setMenuPosition, false);
    } else if(typeof window.attachEvent != "undefined"){
        window. attachEvent("onload", setMenuPosition);
    }
                    
});

function setCircles() {
    $('#circles .ux').popover({
        html: true,
        placement: 'top',
        trigger: 'hover',
        content: '<ul class="circle-popup"><li>Прототипирование</li><li>Стратегический контент</li><li>Информационная Архитектура</li></ul>'
    }).show();
    
    $('#circles .design').popover({
        html: true,
        placement: 'top',
        trigger: 'hover',
        content: '<ul class="circle-popup"><li>Веб-дизайн</li><li>Анимация</li></ul>'
    }).show();
    
    $('#circles .seo').popover({
        html: true,
        placement: 'top',
        trigger: 'hover',
        content: '<ul class="circle-popup"><li>ЯндексДирект</li><li>Google AdWords</li><li>Meta Information</li></ul>'
    }).show(); 
    
    $('#circles .smm').popover({
        html: true,
        placement: 'top',
        trigger: 'hover',
        content: '<ul class="circle-popup"><li>Вконтакте/Facebook</li><li>Instagramm</li><li>Odnoklasniki</li></ul>'
    }).show();
    
    $('#circles .tech').popover({
        html: true,
        placement: 'top',
        trigger: 'hover',
        content: '<ul class="circle-popup"><li>HTML/CSS</li><li>PHP, Ruby и Python</li><li>JavaScript и jQuery</li></ul>'
    }).show();
    
}

var pagesTimer = false;
var servicesTimer = false;
var sloganTimer = false;

//// pages carousel

function pagesCarouselInit() {
    $('#landing-long-page .arrow-left, #landing-long-page .arrow-right').click(function(){
        if ( pagesTimer ) { clearInterval(pagesTimer); }
        movePages();
        pagesCarouselStart();
    });
    $('#pages-block-slider').mouseover(function(){clearInterval(pagesTimer);})
                            .mouseout(function(){pagesCarouselStart();});
}

function pagesCarouselStart() {
    pagesTimer = setInterval(function(){
        movePages();
    }, 9500);
}
function movePages(){
    if ( !$('#pages-block-wrapper').css('margin-left') || $('#pages-block-wrapper').css('margin-left') == '0px' ) {
        $('#pages-block-wrapper').css('margin-left', '-880px');
    } else {
        $('#pages-block-wrapper').css('margin-left', '0');
    }
}

/// slogan carousel
function startSloganScroll() {
    sloganTimer = setInterval(function(){
        var wrapper = $('#slogan-text #slogan-text-wrapper');
        if ( !wrapper.css('margin-left') || wrapper.css('margin-left') == '0px' ) {
            wrapper.css('margin-left', '-6000px');
        } else if ( wrapper.css('margin-left') == '-6000px' ) {
            wrapper.css('margin-left', '-12000px');
        } else {
            wrapper.css('margin-left', '0px');
        }
    }, 4500);
}


//// servises carousel

function servicesCarouselStart() {
    $('#services-slider #titles a').click(function(){
        moveServices($(this).attr('data-slide'));
        $('#services-slider #titles a.active').removeClass('active');
        $(this).addClass('active');
    });
    
    $('#services-slider .arrow-left').click(function(){
        moveServicesArrow(false);
    });
    $('#services-slider .arrow-right').click(function(){
        moveServicesArrow(true);
    });
    servicesTimer = setInterval(function() {
        var active = $('#services-slider #titles a.active').attr('data-slide');
        var pos = (active == '0') 
                ? '815' 
                : ( (active == '815') 
                    ? '1630' 
                    : ( (active == '1630') ? '0' : '0' ) 
                );
        moveServices(pos);
    }, 8500);
}

function moveServicesArrow(right) {
    var active = $('#services-slider #titles a.active').attr('data-slide');
    if ( right ) {
        pos = (active == '0') 
                    ? '815' 
                    : ( (active == '815') 
                        ? '1630' 
                        : ( (active == '1630') ? '0' : '0' ) 
                    );
    } else {
        pos = (active == '0') 
                    ? '1630' 
                    : ( (active == '1630') 
                        ? '815' 
                        : ( (active == '815') ? '0' : '0' ) 
                    );
    }
    moveServices(pos);
}

function moveServices(marginLeft) {
    $('#services-slider #titles a').removeClass('active');
    if ( jQuery.inArray(marginLeft, ['0', '815', '1630']) < 0 ) 
        marginLeft = 0;
    $('#services-slider #titles a[data-slide="'+marginLeft+'"]').addClass('active');
    $('#services-slider #services-text-wrapper').css('margin-left', '-'+marginLeft+'px');
}

/// scroll
function getScrollTop() {
    var scrOfY = 0;
    if( typeof( window.pageYOffset ) == "number" ) {
            //Netscape compliant
            scrOfY = window.pageYOffset;
    } else if( document.body 
    && ( document.body.scrollLeft 
    || document.body.scrollTop ) ) {
            //DOM compliant
            scrOfY = document.body.scrollTop;
    } else if( document.documentElement
    && ( document.documentElement.scrollLeft
     || document.documentElement.scrollTop ) ) {
            //IE6 Strict
            scrOfY = document.documentElement.scrollTop;
    }
           return scrOfY;
}
 
function marginMenuTop() {
    var top  = getScrollTop();
    if ( top > 70 ) {
        $('#header-menu').addClass('fixed');
    } else if ( top < 100 ) {
        $('#header-menu').removeClass('fixed');
    }
}
 
function setMenuPosition() {
    if(typeof window.addEventListener != "undefined"){
        window.addEventListener("scroll", marginMenuTop, false);
    } else if(typeof window.attachEvent != "undefined"){
        window. attachEvent("onscroll", marginMenuTop);
    }
  
}

////timers 
function countdown() {   
    var today = new Date().getTime(); /* определим сколько милисекунд прошло с 1970 года до данного момента */
    var end = new Date(2014, 0, 31).getTime(); /* (31 января 2014) */
    var dateX = new Date(end - today); /* узнаем разницу в милисекундах и запишем в переменную dateX */
    var perDays = 60 * 60 * 1000 * 24; /* произведем расчет милисекунд в сутки и запишем в переменную perDays */
    
    $('.timer .days').text( Math.round(dateX/perDays) < 10 ? '0'+ Math.round(dateX/perDays) : Math.round(dateX/perDays));
    $('.timer .hours').text( dateX.getUTCHours() < 10 ? '0'+dateX.getUTCHours().toString() : dateX.getUTCHours().toString() );
    $('.timer .minutes').text( dateX.getMinutes() < 10 ? '0'+dateX.getMinutes().toString() : dateX.getMinutes().toString() );
    $('.timer .seconds').text( dateX.getSeconds() < 10 ? '0'+dateX.getSeconds().toString() : dateX.getSeconds().toString() );
}

function setForms() {
    var options = { 
        beforeSubmit:   showRequest, 
        success:        showResponse,
        clearForm:      true,
        dataType:       'json'
    }; 
        
//    var forms = '#header-call-form-form, ';
//    forms += '#pages-block-wrapper form, ';
//    forms += '#tarif-form form, ';
//    forms += '#after-tarif-call-form form, ';
//    forms += '#form_brief, ';
//    forms += '#footer-form form, ';
//    forms += '#get_portfoilio_form';
    
    $('form').ajaxForm(options); 
    
}

function showRequest(formData, jqForm, options) { 
//    console.log(formData);
    var err = false;
    for (var i=0; i < formData.length; i++) { 
        if (!formData[i].value && formData[i].required) { 
            $('#form_brief [name="'+formData[i].name+'"]')
                    parents('form-group').addClass('has-error');
            err = true;
        } 
    } 
    if ( err ) {
        return false;
    }
    if ( jqForm.hasClass('form_brief') ) {
        $('#form_brief').fadeOut(function(){
            $('.success-brif').show();
        });
    }
    
    if ( jqForm.hasClass('call_form') ) {
        $('.call_form').fadeOut(function(){
            $('.call-form-thanks').fadeIn();
        });
    } else if ( jqForm.hasClass('tarif_form') ) {
        $('#tarif-form').fadeOut();
    } else if ( jqForm.hasClass('portfolio_form') ) {
        $('#get_portfoilio_form').fadeOut(function(){
            $('.portfolio-form-thanks').fadeIn();
        });
    } else if ( jqForm.hasClass('pages_form') )  {
        $('.page form').fadeOut(function(){
            $('.pages-form-thanks').fadeIn();
        });
    } else if ( jqForm.hasClass('brif_req_form') ) {
        $('#get_brif_form').fadeOut(function(){
            $('.brif-form-thanks').fadeIn();
        });
    }
    
    if ( portfolioShowed )  {
        _gaq.push(['_trackEvent', 'Отправка формы при показаном портфолио', portfolioShowed]);
    } else {
        _gaq.push(['_trackEvent', 'Отправка формы при скрытом портфолио', portfolioShowed]);
    }

    return true; 
} 
 
function showResponse(responseText, statusText, xhr, $form)  { 
//    console.log(xhr);
//    console.log('status: ' + statusText + '\n\nresponseText: \n' ); 
//    console.log(responseText);
    
    if ( $form.hasClass('call_form') ) {
        $('.call_form').fadeOut(function(){
            $('.call-form-thanks').fadeIn();
        });
    } else if ( $form.hasClass('tarif_form') ) {
        $('#tarif-form').fadeOut();
    } else if ( $form.hasClass('portfolio_form') ) {
        $('#get_portfoilio_form').fadeOut(function(){
            $('.portfolio-form-thanks').fadeIn();
        });
    } else if ( $form.hasClass('pages_form') )  {
        $('.page form').fadeOut(function(){
            $('.pages-form-thanks').fadeIn();
        });
    } else if ( $form.hasClass('brif_req_form') ) {
        $('#get_brif_form').fadeOut(function(){
            $('.brif-form-thanks').fadeIn();
        });
    } else if ( $form.hasClass('form_brief') ) {
        $('#brief_modal').modal('hide');
    }
} 
