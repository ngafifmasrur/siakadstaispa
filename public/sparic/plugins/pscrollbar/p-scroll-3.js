(function($) {
	"use strict";
	const ps12 = new PerfectScrollbar('.vscroll', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	
	const ps13 = new PerfectScrollbar('.scroll-1', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});

	const ps14 = new PerfectScrollbar('.imagescroll', {
	  useBothWheelAxes:true,
	});
})(jQuery);