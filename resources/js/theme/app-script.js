
$(function() {
    "use strict";
     
	 
    //sidebar menu js
    $.sidebarMenu($('.sidebar-menu'));

    // === toggle-menu js

    $(".toggle-menu").on("click", function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	
	   
    // === sidebar menu activation js

    var currentLink = '',
        activeNavItem = false;
    $(".sidebar-menu a").each(function() {
        if((window.location.origin + window.location.pathname).indexOf($(this).attr('href')) !== -1) {
            if(currentLink.length < $(this).attr('href').length) {
                currentLink = $(this).attr('href');
                activeNavItem = $(this);
            }
        }
    });
    if(activeNavItem) {
        activeNavItem.addClass("active").parent().addClass("active").parent().parent().addClass("active");
    } else {
        $(".sidebar-menu a").first().addClass("active").parent().addClass("active").parent().parent().addClass("active");
    }
	   
    /* Back To Top */
    $(document).ready(function(){ 
        $(window).on("scroll", function(){ 
            if ($(this).scrollTop() > 300) { 
                $('.back-to-top').fadeIn(); 
            } else { 
                $('.back-to-top').fadeOut(); 
            } 
        }); 
        $('.back-to-top').on("click", function(){ 
            $("html, body").animate({ scrollTop: 0 }, 600); 
            return false; 
        }); 
    });
	   
    $(function () {
        $('[data-toggle="popover"]').popover()
    });


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('#form-vertical').steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        stepsOrientation: "vertical",
        enableAllSteps: true,
        enableFinishButton: false,
        enablePagination: false,
        onInit: function() {
            $(this).find('.steps li').addClass('done').first().removeClass('done');
        },
        onStepChanged: function(event, index, oldIndex) {
            $(this).find('section.body').css('display', '');
        },
    });

    $('select').select2();
});
