$(function(e) {
	'use strict'
	/*--details-chart--*/
	var options = {
		chart: {
			height: 350,
			type: 'area',
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth'
		},
		series: [{
			name: 'Orders',
			data: [31, 40, 28, 51, 42, 109, 100]
		}, {
			name: 'Sales',
			data: [11, 32, 45, 32, 34, 52, 41]
		}],
		colors: ['#5eba00', '#467fcf'],
		xaxis: {
			type: 'datetime',
			categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
		},
		tooltip: {
			x: {
				format: 'dd/MM/yy HH:mm'
			},
		}
	}
	var chart = new ApexCharts(document.querySelector("#details-chart"), options);
	chart.render();
	/*--details-chart--*/

	/*--details-chart2--*/
	var options = {
		chart: {
			height: 350,
			type: 'area',
			animations: {
				enabled: false
			},
			zoom: {
				enabled: false
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth'
		},
		series: [{
			name: 'sales Monitoring',
			data: [{
					x: 'Dec 23 2017',
					y: null
				},
				{
					x: 'Dec 24 2017',
					y: 44
				},
				{
					x: 'Dec 25 2017',
					y: 31
				},
				{
					x: 'Dec 26 2017',
					y: 38
				},
				{
					x: 'Dec 27 2017',
					y: null
				},
				{
					x: 'Dec 28 2017',
					y: 32
				},
				{
					x: 'Dec 29 2017',
					y: 55
				},
				{
					x: 'Dec 30 2017',
					y: 51
				},
				{
					x: 'Dec 31 2017',
					y: 67
				},
				{
					x: 'Jan 01 2018',
					y: 22
				},
				{
					x: 'Jan 02 2018',
					y: 34
				},
				{
					x: 'Jan 03 2018',
					y: null
				},
				{
					x: 'Jan 04 2018',
					y: null
				},
				{
					x: 'Jan 05 2018',
					y: 11
				},
				{
					x: 'Jan 06 2018',
					y: 4
				},
				{
					x: 'Jan 07 2018',
					y: 15,
				},
				{
					x: 'Jan 08 2018',
					y: 30
				},
				{
					x: 'Jan 09 2018',
					y: 9
				},
				{
					x: 'Jan 10 2018',
					y: 34
				},
				{
					x: 'Jan 11 2018',
					y: 25
				},
				{
					x: 'Jan 12 2018',
					y: 35
				},
				{
					x: 'Jan 13 2018',
					y: 13
				},
				{
					x: 'Jan 14 2018',
					y: null
				}
			],
		}],
		colors: ['#467fcf'],
		fill: {
			opacity: 0.8,
			type: 'pattern',
			pattern: {
				enabled: true,
				style: ['verticalLines', 'horizontalLines'],
				width: 5,
				depth: 6
			},
		},
		markers: {
			size: 5,
			hover: {
				size: 9
			}
		},
		title: {
			text: '',
		},
		tooltip: {
			intersect: true,
			shared: false
		},
		theme: {
			palette: 'palette1'
		},
		xaxis: {
			type: 'datetime',
		},
		yaxis: {
			title: {
				text: 'Bytes Received'
			}
		}
	}

	var chart = new ApexCharts(
		document.querySelector("#details-chart2"),
		options
	);

	chart.render();
	/*--details-chart2--*/

	/*--Echart1--*/
	var chartdata = [{
		name: 'sales',
		type: 'bar',
		data: [10, 15, 9, 18, 10, 15, 12, 18],
		symbolSize: 10,
		itemStyle: {
			normal: {
				barBorderRadius: [100, 100, 0, 0],
				barBorderWidth: ['2']
			}
		},
	}, {
		name: 'profit',
		type: 'line',
		smooth: true,
		data: [8, 5, 25, 10, 10, 14, 18, 13]
	}, {
		name: 'growth',
		type: 'bar',
		data: [10, 14, 10, 15, 9, 25, 22, 26],
		symbolSize: 10,
		itemStyle: {
			normal: {
				barBorderRadius: [100, 100, 0, 0],
				barBorderWidth: ['2']
			}
		},
	}];
	var chart = document.getElementById('echart1');
	var barChart = echarts.init(chart);
	var option = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},
		xAxis: {
			data: ['2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018'],
			axisLine: {
				lineStyle: {
					color: 'rgba(161, 161, 161,0.3)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#a1a1a1'
			}
		},
		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer: {
				label: {
					show: false,
				}
			}
		},
		yAxis: {
			splitLine: {
				lineStyle: {
					color: 'rgba(161, 161, 161,0.3)'
				}
			},
			axisLine: {
				lineStyle: {
					color: 'rgba(161, 161, 161,0.3)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#a1a1a1'
			}
		},
		series: chartdata,
		color: ['#467fcf ', '#fa626b', '#5eba00', ]
	};
	barChart.setOption(option);
	/*--Echart1--*/
});