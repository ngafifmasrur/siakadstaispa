( function ( $ ) {
    "use strict";

    //Team chart
    var ctx = document.getElementById( "chartjs1" );
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ "2010", "2011", "2012", "2013", "2014", "2015", "2016" ],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                data: [ 0, 7, 3, 5, 2, 10, 7 ],
                label: "Expense",
                backgroundColor: 'rgba(94, 186, 0,.6)',
                borderColor: 'rgba(94, 186, 0,0.6)',
                borderWidth: 3.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(94, 186, 0,0.9)',
                    }, ]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#7886a0',
                bodyFontColor: '#7886a0',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                display: false,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [ {
					ticks: {
						fontColor: "#bbc1ca",
					},
                    display: true,
                    gridLines: {
                        display: true,
						color:'rgba(187, 193, 202,0.2)',
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month',
						fontColor: "#bbc1ca",
                    }
                        } ],
                yAxes: [ {
					ticks: {
						fontColor: "#bbc1ca",
					},
                    display: true,
                    gridLines: {
                        display: true,
						color:'rgba(187, 193, 202,0.2)',
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value',
						fontColor: "#bbc1ca",
                    }
                        } ]
            },
            title: {
                display: false,
            }
        }
    } );


    //Sales chart
    var ctx = document.getElementById( "chartjs2" );
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ "2010", "2011", "2012", "2013", "2014", "2015", "2016" ],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                label: "Foods",
                data: [ 0, 30, 10, 120, 50, 63, 10 ],
                backgroundColor: 'transparent',
                borderColor: 'rgba(70, 127, 207,0.75)',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(70, 127, 207,0.75)',
                    }, {
                label: "Electronics",
                data: [ 0, 50, 40, 80, 40, 79, 120 ],
                backgroundColor: 'transparent',
                borderColor: 'rgba(94, 186, 0,0.75)',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(94, 186, 0,0.75)',
                    } ]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#7886a0',
                bodyFontColor: '#7886a0',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
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
                xAxes: [ {
					ticks: {
						fontColor: "#bbc1ca",
					},
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Month',
						fontColor: "#bbc1ca",
                    }
                        } ],
                yAxes: [ {
					ticks: {
						fontColor: "#bbc1ca",
					},
                    display: true,
                    gridLines: {
                        display: true,
						color:'rgba(187, 193, 202,0.2)',
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value',
						fontColor: "#bbc1ca",
                    }
                        } ]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    } );


    //line chart
    var ctx = document.getElementById( "chartjs3" );
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ "January", "February", "March", "April", "May", "June", "July" ],
            datasets: [
                {
                    label: "My First dataset",
                    borderColor: "rgba(70, 127, 207,.9)",
                    borderWidth: "1",
                    backgroundColor: "rgba(70, 127, 207,.7)",
                    data: [ 22, 44, 67, 43, 76, 45, 12 ]
                            },
                {
                    label: "My Second dataset",
                    borderColor: "rgba(94, 186, 0, 0.9)",
                    borderWidth: "1",
                    backgroundColor: "rgba(94, 186, 0, 0.7)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [ 16, 32, 18, 26, 42, 33, 44 ]
                            }
                        ]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
			legend: {
				display:true,
				labels: {
                    fontColor: "#bbc1ca",
                }
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: "#bbc1ca",
					},
					gridLines: {
						color:'rgba(187, 193, 202,0.2)',
					}
				}],

				xAxes: [{
					ticks: {
						display: true,
						fontColor: "#bbc1ca",
					},
					gridLines: {
						display: false,
						color:'rgba(187, 193, 202,0.2)',
					}
				}]
			},

        }
    } );


    //bar chart
    var ctx = document.getElementById( "chartjs4" );
    var myChart = new Chart( ctx, {
        type: 'bar',
        data: {
            labels: [ "January", "February", "March", "April", "May", "June", "July" ],
            datasets: [
                {
                    label: "My First dataset",
                    data: [ 65, 59, 80, 81, 56, 55, 40 ],
                    borderColor: "rgba(94, 186, 0, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(94, 186, 0, 0.7)"
                            },
                {
                    label: "My Second dataset",
                    data: [ 28, 48, 40, 19, 86, 27, 90 ],
                    borderColor: "rgba(70, 127, 207,0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(70, 127, 207,0.7)"
                            }
                        ]
        },
        options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				display:true,
				labels: {
                    fontColor: "#bbc1ca",
                }
			},
            scales: {
                yAxes: [ {
                    ticks: {
                        beginAtZero: true,
						fontColor: "#bbc1ca",
                    },
					gridLines: {
						color:'rgba(187, 193, 202,0.2)',
					}
                } ],
				xAxes: [{
					ticks: {
						display: true,
						fontColor: "#bbc1ca",
					},
					gridLines: {
						display: false,
						color:'rgba(187, 193, 202,0.2)',
					}
				}]
            }
        }
    } );

    //radar chart
    var ctx = document.getElementById( "chartjs5" );
    var myChart = new Chart( ctx, {
        type: 'radar',
        data: {
            labels: [ [ "Eating", "Dinner" ], [ "Drinking", "Water" ], "Sleeping", [ "Designing", "Graphics" ], "Coding", "Cycling", "Running" ],
            datasets: [
                {
                    label: "My First dataset",
                    data: [ 65, 59, 66, 45, 56, 55, 40 ],
                    borderColor: "rgba(94, 186, 0, 0.6)",
                    borderWidth: "1",
                    backgroundColor: "rgba(94, 186, 0, 0.4)"
                            },
                {
                    label: "My Second dataset",
                    data: [ 28, 12, 40, 19, 63, 27, 87 ],
                    borderColor: "rgba(70, 127, 207, 0.7",
                    borderWidth: "1",
                    backgroundColor: "rgba(70, 127, 207, 0.8)"
                            }
                        ]
        },
        options: {
			responsive: true,
			maintainAspectRatio: false,
            legend: {
                position: 'top',
				labels: {
                    fontColor: "#bbc1ca",
                }
            },
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    } );


    //pie chart
    var ctx = document.getElementById( "chartjs6" );
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
                position: 'top',
				labels: {
                    fontColor: "#bbc1ca",
                }
            },
        }
    } );

    //doughut chart
    var ctx = document.getElementById( "chartjs7" );
    var myChart = new Chart( ctx, {
        type: 'doughnut',
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
                position: 'top',
				labels: {
                    fontColor: "#bbc1ca",
                }
            },
        }
    } );

    //polar chart
    var ctx = document.getElementById( "chartjs8" );
    var myChart = new Chart( ctx, {
        type: 'polarArea',
        data: {
            datasets: [ {
                data: [ 15, 18, 9, 6, 19 ],
                backgroundColor: [
                                    "#5eba00",
                                    "#467fcf",
                                    "#5b5be9",
                                    "#f5334f",
									"#ffb229"
                                ]

                            } ],
            labels: [
                            "Data1",
                            "Data2",
                            "Data3",
                            "Data4",
                            "Data5"
                        ]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
			legend: {
                position: 'top',
				labels: {
                    fontColor: "#bbc1ca",
                }
            },
        }
    } );

    // single bar chart
    var ctx = document.getElementById( "chartjs9" );
    var myChart = new Chart( ctx, {
        type: 'bar',
        data: {
            labels: [ "Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat" ],
            datasets: [
                {
                    label: "My First dataset",
                    data: [ 40, 55, 75, 81, 56, 55, 40 ],
                    borderColor: "rgba(94, 186, 0, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(94, 186, 0, 0.8)"
                            }
                        ]
        },
        options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
                position: 'top',
				labels: {
                    fontColor: "#bbc1ca",
                }
            },
            scales: {
                yAxes: [ {
                    ticks: {
                        beginAtZero: true,
						fontColor: "#bbc1ca",
                    },
					gridLines: {
						
						color:'rgba(187, 193, 202,0.2)',
					}
                } ],
				xAxes: [{
					ticks: {
						display: true,
						fontColor: "#bbc1ca",
					},
					gridLines: {
						display: true,
						color:'rgba(187, 193, 202,0.2)',
					}
				}]
            }
        }
    } );

	/* chartjs (#sales-statistics) */
	var myCanvas = document.getElementById("chartjs10");
	myCanvas.height="300";

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
				data: [15, 13, 12, 14, 10, 15, 7, 14],
				backgroundColor: gradientStroke1,
				hoverBackgroundColor: gradientStroke1,
				hoverBorderWidth: 2,
				hoverBorderColor: 'gradientStroke1'
			},{
			label: 'Total Profits',
				data: [10, 14, 10, 15, 9, 13, 15, 18],
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
						fontColor: "#bbc1ca",

					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'rgba(0,0,0,0.81)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'sales',
						fontColor: 'rgba(0,0,0,0.81)'
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

	/* chartjs (#sales) */
	var myCanvas = document.getElementById("chartjs11");
	myCanvas.height="300";

	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke = myCanvasContext.createLinearGradient(0, 0, 0, 380);
	gradientStroke.addColorStop(0, '#5eba00');
	gradientStroke.addColorStop(1, '#5eba00');
    var myChart = new Chart( myCanvas, {
		type: 'line',
		data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            type: 'line',
            datasets: [ {
				label: 'Return-On-Assets',
				data: [0, 50, 10, 100, 20, 130, 100, 140, 50],
				backgroundColor: gradientStroke,
				borderColor: '#5eba00',
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:gradientStroke,
				pointBorderColor :'#5eba00',
				pointHoverBorderColor :gradientStroke,
				pointBorderWidth :2,
				pointRadius :6,
				pointHoverRadius :2,
				borderWidth: 2
            }, ]
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
					usePointStyle: false,
				},
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'transparent'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
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
	/* chartjs (#sales) closed */

	/* Chartjs (#total-customers) */
	var myCanvas = document.getElementById("chartjs12");
	myCanvas.height="233";

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
						fontColor: "#bbc1ca",

					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: '#bbc1ca'
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
	var ctx = document.getElementById('chartjs13').getContext('2d');
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
	/* Chart-js (#site-executive) */
	var myCanvas = document.getElementById("chartjs14");
	myCanvas.height = "290";
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 200);
	gradientStroke1.addColorStop(0, 'transparent');
	gradientStroke1.addColorStop(1, 'transparent');
	var gradientStroke2 = myCanvasContext.createLinearGradient(0, 0, 0, 190);
	gradientStroke2.addColorStop(0, 'transparent');
	gradientStroke2.addColorStop(1, 'transparent');
	var myChart = new Chart(myCanvas, {
		type: 'line',
		data: {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
			type: 'line',
			datasets: [{
				label: "Users",
				data: [2, 7, 3, 9, 4, 5, 2, 8, 4, 6, 5, 2, 8, 4, 7, 2, 4, 6, 4, 8, 4, ],
				backgroundColor: gradientStroke1,
				borderColor: '#5eba00',
				pointBackgroundColor: '#fff',
				pointHoverBackgroundColor: gradientStroke1,
				pointBorderColor: '#5eba00',
				pointHoverBorderColor: gradientStroke1,
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverRadius: 4,
				labelColor: gradientStroke1,
				borderWidth: 2,
			}, {
				label: "Page-views",
				data: [5, 3, 9, 6, 5, 9, 7, 3, 5, 2, 5, 3, 9, 6, 5, 9, 7, 3, 5, 2, 7, 10],
				backgroundColor: gradientStroke2,
				borderColor: '#467fcf',
				pointBackgroundColor: '#fff',
				pointHoverBackgroundColor: gradientStroke2,
				pointBorderColor: '#467fcf',
				pointHoverBorderColor: gradientStroke2,
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverRadius: 4,
				borderWidth: 2,
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				display: true,
				labels: {
					fontColor: "#bbc1ca",
                },
			},
			tooltips: {
				show: true,
				showContent: true,
				alwaysShowContent: true,
				triggerOn: 'mousemove',
				trigger: 'axis',
				axisPointer: {
					label: {
						show: false,
					},
				}
			},
			scales: {
				xAxes: [{
					gridLines: {
						color:'rgba(187, 193, 202,0.2)',
						zeroLineColor: '#000'
					},
					ticks: {
						fontSize: 12,
						fontColor: '#bbc1ca',
						beginAtZero: true,
						padding: 0
					}
				}],
				yAxes: [{
					gridLines: {
						color: 'transparent',
						zeroLineColor: '#000'
					},
					ticks: {
						fontSize: 12,
						fontColor: '#bbc1ca',
						beginAtZero: false,
						padding: 0
					}
				}]
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
	})
	var myCanvas = document.getElementById("chartjs15");
	myCanvas.height = "343";
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 240);
	gradientStroke1.addColorStop(0, '#5eba00');
	gradientStroke1.addColorStop(1, '#5eba00');
	var gradientStroke2 = myCanvasContext.createLinearGradient(0, 0, 0, 280);
	gradientStroke2.addColorStop(0, '#467fcf');
	gradientStroke2.addColorStop(1, '#467fcf');
	var myChart = new Chart(myCanvas, {
		type: 'line',
		data: {
			labels: ["Jan", "feb", "Mar", "Apr", "May", "Jun", "Jul"],
			type: 'line',
			datasets: [{
				label: 'Social',
				data: [0, 70, 75, 120, 94, 141, 162],
				backgroundColor: 'transparent',
				borderColor: gradientStroke1,
				pointBackgroundColor: '#fff',
				pointHoverBackgroundColor: gradientStroke1,
				pointBorderColor: gradientStroke1,
				pointHoverBorderColor: gradientStroke1,
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverRadius: 2,
				borderWidth: 2
			}, {
				label: "Paid Ads",
				data: [0, 50, 40, 80, 40, 79, 120],
				backgroundColor: 'transparent',
				borderColor: gradientStroke2,
				pointBackgroundColor: '#fff',
				pointHoverBackgroundColor: gradientStroke2,
				pointBorderColor: gradientStroke2,
				pointHoverBorderColor: gradientStroke2,
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverRadius: 2,
				borderWidth: 2
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: 'rgba(0,0,0,0.5)',
				bodyFontColor: 'rgba(0,0,0,0.5)',
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
					ticks: {
						fontColor: "#bbc1ca",
					},
					display: true,
					gridLines: {
						color:'rgba(187, 193, 202,0.2)',
					},
					scaleLabel: {
						display: true,
						labelString: 'Month',
						fontColor: '#bbc1ca'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					},
					display: true,
					gridLines: {
						display: false,
						drawBorder: true
					},
					scaleLabel: {
						display: true,
						labelString: 'Revenue by channel',
						fontColor: '#bbc1ca'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* Chartjs (#total-income) */
	var myCanvas = document.getElementById("chartjs16");
	myCanvas.height="300";

	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 280);
	gradientStroke1.addColorStop(0, '#5eba00');
	gradientStroke1.addColorStop(1, '#5eba00');

    var myChart = new Chart( myCanvas, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            type: 'line',
            datasets: [ {
				label: 'Total-incomeincome',
				data: [24, 18, 28, 21, 32, 28,30,30,10,40,20],
				backgroundColor: 'rgb(94, 186, 0, 0.2)',
				borderColor: gradientStroke1,
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:gradientStroke1,
				pointBorderColor :gradientStroke1,
				pointHoverBorderColor :gradientStroke1,
				pointBorderWidth :2,
				pointRadius :2,
				pointHoverRadius :2,
				borderWidth: 2
            }, ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#6b6f80',
                bodyFontColor: '#6b6f80',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
					barPercentage: 0.1,
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: true,
						color: 'rgba(187, 193, 202,0.2)',
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'transparent'
					}
				}],
                yAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: true,
						color: 'rgba(187, 193, 202,0.2)',
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
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
} )( jQuery );