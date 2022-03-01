require('./bootstrap');

// coreui.js
require('@coreui/coreui');

// moment
window.moment = require('moment')

// chart.js
require('chart.js/dist/Chart.min.js')

// select2
require('select2/dist/js/select2')

// select2
require('block-ui')

// tempusdominus-bootstrap-4
require('tempusdominus-bootstrap-4')

// jquery-mask-plugin
require('jquery-mask-plugin')

$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
	icons: {
		time: 'mdi mdi-clock',
		date: 'mdi mdi-calendar',
		up: 'mdi mdi-arrow-up',
		down: 'mdi mdi-arrow-down',
		previous: 'mdi mdi-arrow-left',
		next: 'mdi mdi-arrow-right',
		today: 'mdi mdi-calendar-check',
		clear: 'mdi mdi-trash-can',
		close: 'mdi mdi-close'
	},
	locale: 'id',
});

// 
// 
// JS Apps
// 
// 

window.toMoney = function(t,a,e,r){
	a=isNaN(a=Math.abs(a))?2:a,e=void 0==e?".":e,r=void 0==r?",":r;var s=t<0?"-":"",i=String(parseInt(t=Math.abs(Number(t)||0).toFixed(a))),n=(n=i.length)>3?n%3:0;return s+(n?i.substr(0,n)+r:"")+i.substr(n).replace(/(\d{3})(?=\d)/g,"$1"+r)+(a?e+Math.abs(t-i).toFixed(a).slice(2):"")
};
window.toMoneySpeech = function(a){
	return a<12?" "+["","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas"][a]:a<20?toMoneySpeech(a-10)+" Belas":a<100?toMoneySpeech(Math.floor(a/10))+" Puluh"+toMoneySpeech(a%10):a<200?" Seratus"+toMoneySpeech(a-100):a<1e3?toMoneySpeech(Math.floor(a/100))+" Ratus"+toMoneySpeech(a%100):a<2e3?" Seribu"+toMoneySpeech(a-1e3):a<1e6?toMoneySpeech(Math.floor(a/1e3))+" Ribu"+toMoneySpeech(a%1e3):a<1e9?toMoneySpeech(Math.floor(a/1e6))+" Juta"+toMoneySpeech(a%1e6):void 0
};

$(() => {
	$('.form-block').on('submit', () => {
	    $.blockUI({
	        message: '<div class="spinner"> <div class="double-bounce1"></div> <div class="double-bounce2"></div> </div>',
	        css: { 
	            padding:        0, 
	            margin:         0, 
	            width:          '30%', 
	            top:            '30%', 
	            left:           '35%', 
	            textAlign:      'center', 
	            border:         'none', 
	            backgroundColor:'transparent', 
	            cursor:         'wait' 
	        }, 
	        overlayCSS:  { 
	            backgroundColor: '#fff', 
	            opacity:         0.7, 
	            cursor:          'wait' 
	        }, 
	    });
	});
	
	$('.form-confirm').on('submit', function() {
		let x = confirm('Apakah Anda yakin?');
		if(!x) $.unblockUI();
		return x;
	});

	$('.form-select2').select2({
		theme: "bootstrap4",
		minimumInputLength: 3,
		ajax: {
			delay: 1000,
			dataType: 'json',
			processResults: function (data, params) {
				return {
					results: data
				}
			}
		}
	});
});