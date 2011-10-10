/**
 * General JavaScript file
 * @author Daniel15 <daniel at dan.cx>
 */

/**
 * Monthly and daily summary pages
 */
var Summary = 
{
	IP_CELL: 0,
	HOSTNAME_CELL: 1,
	
	pie: null,
	
	/**
	 * Initialise the page
	 */
	init: function()
	{
		var data = [];
		
		// Grab data from table
		$('#summary tbody tr').each(function(index, el)
		{
			data.push([
				$(this.cells[Summary.HOSTNAME_CELL]).text(), 
				+$(this).attr('data-total'),
				$(this.cells[Summary.IP_CELL]).text()
			]);
		});
		
		// Create pie chart
		this.pie = new Highcharts.Chart(
		{
			chart: 
			{
				renderTo: 'pie'
			},
			title: 
			{
				text: ''
			},
			tooltip: 
			{
				enabled: false
			},
			plotOptions: 
			{
				pie: 
				{
					dataLabels: 
					{
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [
			{
				type: 'pie',
				cursor: 'pointer',
				point:
				{
					events:
					{
						/**
						 * Handle clicks on the chart
						 */
						click: function()
						{
							location.href += this.config[2] + '/';
						}
					}
				},
				data: data
			}]
		});
	}
};

/**
 * Scripts specific to monthly stats page
 */
Summary.Month = 
{
	byday: null,
	
	/**
	 * Initialise the page
	 */
	init: function()
	{
		// Grab the by day stats
		$.ajax(
		{
			url: location.href + 'byday.json',
			success: this.createByDayChart
		});
	},
	
	/**
	 * Create the "by day" chart
	 */
	createByDayChart: function(data)
	{
		var series = [];
		
		$.each(data.data, function(index, item)
		{
			var values = [];
			$.each(item, function(index, val)
			{
				values.push(val);
			})
			
			series.push(
			{
				name: index,
				data: values
			})
		});
		
		this.byday = new Highcharts.Chart(
		{
			chart: 
			{
				renderTo: 'byday',
				defaultSeriesType: 'column',
				marginRight: 150
			},
			title: 
			{
				text: ''
			},
			xAxis:
			{
				categories: data.days,
				labels:
				{
					rotation: -90,
					align: 'right'
				}
			},
			yAxis:
			{
				title: 
				{
					text: ''
				}
			},
			legend:
			{
				enabled: true,
				verticalAlign: 'middle',
				align: 'right',
				width: 150
			},
			tooltip: 
			{
				enabled: false
			},
			plotOptions: 
			{
				column: 
				{
					stacking: 'normal',
					dataLabels: 
					{
						enabled: false
					}
				}
			},
			series: series
		});
	}
}

var Host = {};
Host.Day = 
{
	graph: null,
	
	init: function()
	{
		var categories = [];
		var series = [];
		
		// Grab data from table
		$('#host tbody tr').each(function(index, el)
		{
			categories.push($(this.cells[0]).text().split('-')[0]);
			series.push(+$(this).attr('data-total'));
		});
		
		categories = categories.reverse();
		series = series.reverse();
		
		// Create pie chart
		this.graph = new Highcharts.Chart(
		{
			chart: 
			{
				renderTo: 'host_graph',
				defaultSeriesType: 'column'
			},
			title: 
			{
				text: ''
			},
			xAxis:
			{
				categories: categories,
				labels:
				{
					//rotation: -45
				}
			},
			yAxis:
			{
				title:
				{
					text: 'Traffic'
				}
			},
			legend:
			{
				enabled: false
			},
			tooltip: 
			{
				enabled: false
			},
			plotOptions: 
			{
				pie: 
				{
					dataLabels: 
					{
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [
			{
				data: series
			}]
		});
	}
};

// Call correct init based on what page we're on.
switch (document.body.id)
{
	case 'summary-month':
		Summary.init();
		Summary.Month.init();
		break;
	case 'summary-day': 
		Summary.init();
		break;
	case 'host-day':
		Host.Day.init();
		break;
}