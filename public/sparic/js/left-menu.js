(function($) {
	"use strict";
	
	// ______________Active Class
	$(".app-sidebar li a").each(function() {
	  var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) { 
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	//Active Class
	$(".app-sidebar li a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().addClass("resp-tab-content-active"); // add active to li of the current link
			$(this).parent().parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	$(".submenu-list li a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().parent().parent().parent().parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().parent().parent().parent().addClass("resp-tab-content-active"); // add active to li of the current link
			$(this).parent().parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	
	$(document).ready(function(){	
	
		if ($('.home-sparic.active').hasClass('active'))
        $('li.home-sparic').addClass('active');
	
		if ($('.apps-sparic.active').hasClass('active'))
        $('li.apps-sparic').addClass('active');
	
		if ($('.widget-sparic.active').hasClass('active'))
        $('li.widget-sparic').addClass('active');
	
		if ($('.charts-sparic.active').hasClass('active'))
        $('li.charts-sparic').addClass('active');
	
		if ($('.elements-sparic.active').hasClass('active'))
        $('li.elements-sparic').addClass('active');
		
		if ($('.ui-sparic.active').hasClass('active'))
        $('li.ui-sparic').addClass('active');
	
		if ($('.forms-sparic.active').hasClass('active'))
        $('li.forms-sparic').addClass('active');
	
		if ($('.icons-sparic.active').hasClass('active'))
        $('li.icons-sparic').addClass('active');
	
		if ($('.calender-sparic.active').hasClass('active'))
        $('li.calender-sparic').addClass('active');
	
		if ($('.tables-sparic.active').hasClass('active'))
        $('li.tables-sparic').addClass('active');
	
		if ($('.pages-sparic.active').hasClass('active'))
        $('li.pages-sparic').addClass('active');
	
		if ($('.ecommerce-sparic.active').hasClass('active'))
        $('li.ecommerce-sparic').addClass('active');
	
		if ($('.custom-sparic.active').hasClass('active'))
        $('li.custom-sparic').addClass('active');
	
		if ($('.errors-sparic.active').hasClass('active'))
        $('li.errors-sparic').addClass('active');
	
		if ($('.submenu-sparic.active').hasClass('active'))
        $('li.submenu-sparic').addClass('active');
	
	
	});

	// VerticalTab
	$('#parentVerticalTab').easyResponsiveTabs({
		type: 'vertical',
		width: 'auto', 
		fit: true, 
		closed: 'accordion',
		tabidentify: 'hor_1',
		activate: function(event) {
			var $tab = $(this);
			var $info = $('#nested-tabInfo2');
			var $name = $('span', $info);
			$name.text($tab.text());
			$info.show();
		}
	});
	
	
				
})(jQuery);