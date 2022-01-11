$(function(e){
  'use strict'
	/* Conversion */
    var ctx = $('#conversion');
	ctx.height(200);
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"],
			type: 'line',
			datasets: [{
                label: "Users",
                data: [ 15, 25, 38, 55, 35, 15, 40 ],
                backgroundColor: 'rgba(94, 186, 0,0.05)',
                borderColor: 'rgba(94, 186, 0,0.75)',
                borderWidth: 2,
                pointStyle: 'circle',
                pointRadius: 0,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(94, 186, 0,0.75)',
                    }, {
                label: "Leads",
                data: [ 10, 40, 30, 40, 60, 50, 30 ],
                backgroundColor: 'rgba(70, 127, 207,0.05)',
                borderColor: 'rgba(70, 127, 207,0.75)',
                borderWidth: 2,
                pointStyle: 'circle',
                pointRadius: 0,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(70, 127, 207,0.75)',
                    }
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: 'rgba(0,0,0,0.9)',
				bodyFontColor: 'rgba(0,0,0,0.9)',
				backgroundColor: '#fff',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 0,
				intersect: false,
			},
			legend: {
				display: false,
				labels: {
					usePointStyle: true,
					fontFamily: 'Montserrat',
				},
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor:"#a1a1a1",
					},
					display: true,
					gridLines: {
						color: 'rgba(161, 161, 161,0.3)'
					},
					scaleLabel: {
						display: false,
						labelString: '',
						fontColor: '#a1a1a1'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor:"#a1a1a1",
					},
					display: true,
					gridLines: {
						display: false,
						drawBorder: true
					},
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* Conversion end */
	/* Chartjs (#total-customers) */
	var myCanvas = document.getElementById("total-customers");
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 380);
	gradientStroke1.addColorStop(0, '#467fcf');
	gradientStroke1.addColorStop(1, '#467fcf');

	var myChart = new Chart(myCanvas, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun" ,"Aug", "Sep"],
			datasets: [{
				label: 'Revenue',
				data: [16, 14, 12, 14, 16, 15, 12, 14,18,10],
				backgroundColor: gradientStroke1,
				hoverBackgroundColor: gradientStroke1,
				hoverBorderWidth: 2,
				hoverBorderColor: 'gradientStroke1'
			}
		  ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 3,
				intersect: false,
			},
			legend: {
				display: false,
				labels: {
					usePointStyle: true,
				},
			},
			scales: {
				xAxes: [{
					 barPercentage: 0.2,
					ticks: {
						fontColor: "#a1a1a1",

					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: '#a1a1a1'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "transparent",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'sales',
						fontColor: 'transparent'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* Chartjs (#total-customers) closed */
	/* Chartjs (#total-coversations) */
	var ctx = document.getElementById('total-coversations').getContext('2d');
	var gradientStroke = myCanvasContext.createLinearGradient(0, 0, 0, 300);
	gradientStroke.addColorStop(0, '#5eba00');
	gradientStroke.addColorStop(1, '#5eba00');
    var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			datasets: [{
				label: "Total-coversations",
				borderColor: gradientStroke,
				borderWidth: 2,
				backgroundColor: 'transparent',
				data: [0, 50, 0, 100, 50, 130, 100, 140]
			}]
		},
        options: {
			responsive: true,
			maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                cornerRadius: 0,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 2
                },
                point: {
                    radius: 0,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
	/* Chartjs (#total-coversations) closed */
	/* chartjs (#sales-statistics) */
	var myCanvas = document.getElementById("sales-statistics");

	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 360);
	gradientStroke1.addColorStop(0, '#5eba00');
	gradientStroke1.addColorStop(1, '#5eba00');

	var gradientStroke2 = myCanvasContext.createLinearGradient(0, 0, 0, 360);
	gradientStroke2.addColorStop(0, '#467fcf');
	gradientStroke2.addColorStop(1, '#467fcf');

    var myChart = new Chart( myCanvas, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
			datasets: [{
				label: 'Total Sales',
				data: [15, 17, 12, 14, 10, 15, 7, 14],
				backgroundColor: gradientStroke1,
				hoverBackgroundColor: gradientStroke1,
				hoverBorderWidth: 2,
				hoverBorderColor: 'gradientStroke1'
			},{
			label: 'Total Profits',
				data: [18, 14, 15, 15, 12, 13, 15, 18],
				backgroundColor: gradientStroke2,
				hoverBackgroundColor: gradientStroke2,
				hoverBorderWidth: 2,
				hoverBorderColor: 'gradientStroke2'
			}
		  ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 3,
				intersect: false,

			},
			legend: {
				display: false,
				labels: {
					usePointStyle: true,
					fontFamily: 'Montserrat',
				},
			},
			scales: {
				xAxes: [{
					 barPercentage: 0.2,
					ticks: {
						fontColor: "#a1a1a1",

					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: '#a1a1a1'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#a1a1a1",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'sales',
						fontColor: '#a1a1a1'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* chartjs (#sales-statistics) closed */
	
	/* sparkline_bar1 */
    $(".sparkline_bar1").sparkline([2, 4, 3, 4, 5, 4, 7, 8, 4, 6], {
		type: 'bar',
		height: 50,
		width:'100%',
		barWidth: 5,
		barSpacing:10,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#2fd8c6'
	});
	/* sparkline_bar1 end */

	/* donut */
	function getBoxWidth(labelOpts, fontSize) {
	  return labelOpts.usePointStyle ?
		fontSize * Math.SQRT2 :
	  labelOpts.boxWidth;
	};

	Chart.NewLegend = Chart.Legend.extend({
	  afterFit: function() {
		this.height = this.height + 50;
	  },
	});

	function createNewLegendAndAttach(chartInstance, legendOpts) {
	  var legend = new Chart.NewLegend({
		ctx: chartInstance.chart.ctx,
		options: legendOpts,
		chart: chartInstance
	  });
	  
	  if (chartInstance.legend) {
		Chart.layoutService.removeBox(chartInstance, chartInstance.legend);
		delete chartInstance.newLegend;
	  }
	  
	  chartInstance.newLegend = legend;
	  Chart.layoutService.addBox(chartInstance, legend);
	}

	// Register the legend plugin
	Chart.plugins.register({
	  beforeInit: function(chartInstance) {
		var legendOpts = chartInstance.options.legend;

		if (legendOpts) {
		  createNewLegendAndAttach(chartInstance, legendOpts);
		}
	  },
	  beforeUpdate: function(chartInstance) {
		var legendOpts = chartInstance.options.legend;

		if (legendOpts) {
		  legendOpts = Chart.helpers.configMerge(Chart.defaults.global.legend, legendOpts);

		  if (chartInstance.newLegend) {
			chartInstance.newLegend.options = legendOpts;
		  } else {
			createNewLegendAndAttach(chartInstance, legendOpts);
		  }
		} else {
		  Chart.layoutService.removeBox(chartInstance, chartInstance.newLegend);
		  delete chartInstance.newLegend;
		}
	  },
	  afterEvent: function(chartInstance, e) {
		var legend = chartInstance.newLegend;
		if (legend) {
		  legend.handleEvent(e);
		}
	  }
	});
	
	var ctx = document.getElementById( "donut" );
    var myChart = new Chart( ctx, {
        type: 'pie',
        data: {
            datasets: [ {
                data: [ 45, 25, 20, 10 ],
                backgroundColor: [
                                    "#5eba00",
                                    "#467fcf",
                                    "#5b5be9",
                                    "#f5334f"
                                ],
                hoverBackgroundColor: [

                                    "#5eba00",
                                    "#467fcf",
                                    "#5b5be9",
                                    "#f5334f"
                                ]

                            } ],
            labels: [
                            "Server 1",
                            "Server 2",
                            "Server 3",
							"Server 4",
                        ]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
			legend: {
				labels: {
					fontColor:"#a1a1a1", 
					padding: 10
				},
			},
        }
    } );
	/* lineChart1 */
	var ctx = $('#lineChart1');
	ctx.height(250);
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"],
			datasets: [{
				label: "Campaign",
				borderColor: "transparent",
				borderWidth: "0.1",
				backgroundColor: "#467fcf",
				data: [53, 66, 65, 56, 67, 56, 63],

			}]
		},
		options: {
			scales: {
				xAxes: [{
					barPercentage: 0.1,
					ticks: {
						fontColor:"#a1a1a1",
					 },
					display: true,
					gridLines: {
						color: 'rgba(161, 161, 161,0.3)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor:"#a1a1a1",
					 },
					display: true,
					gridLines: {
						color: 'rgba(161, 161, 161,0.3)'
					}
				}]
			},
			legend: {
				display:true,
				labels: {
					fontColor:"#a1a1a1",
				},
			},
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			}
		}
	});
	/* lineChart1 end */

});

