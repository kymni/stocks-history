<div class="row">
	<div class="col-md-12" id="security-graph"></div>
</div>
<script type="text/javascript">
var data = <?=json_encode($security_data)?>;
$(document).ready(function(){
	Highcharts.setOptions({
	    lang: {
	        thousandsSep: ','
	    }
	});

	var dates=[];
	for (var i=0; i<data['dates'].length; i++) {
		if (data['vwap'][i] > 0) {
			dates.push(data['dates'][i]);
		}
	}
	
	$("#security-graph").highcharts({
	    chart: {
	        zoomType: 'xy'
	    },
	    title: {
	        text: '<?=$name?>'
	    },
	    subtitle: {
	        text: 'Data source: NSE equity pricelist'
	    },
	    xAxis: [{
	        categories: dates,
	        crosshair: true
	    }],
	    yAxis: [{ // Primary yAxis
	        labels: {
	            format: '{value}',
	            style: {
	                color: Highcharts.getOptions().colors[1]
	            }
	        },
	        title: {
	            text: 'Price (Ksh.)',
	            style: {
	                color: Highcharts.getOptions().colors[1]
	            }
	        }
	    }, { // Secondary yAxis
	        title: {
	            text: 'Shares traded',
	            style: {
	                color: Highcharts.getOptions().colors[0]
	            }
	        },
	        labels: {
	            format: '{value}',
	            style: {
	                color: Highcharts.getOptions().colors[0]
	            }
	        },
	        opposite: true
	    }],
	    tooltip: {
	        shared: true
	    }/*,
	    legend: {
	        layout: 'vertical',
	        align: 'left',
	        x: 120,
	        verticalAlign: 'top',
	        y: 100,
	        floating: true,
	        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
	    }*/,
	    series: [{
	        name: 'Volume',
	        type: 'column',
	        yAxis: 1,
	        data: data.vol,
	        tooltip: {
	            valueSuffix: ' shares'
	        }

	    }, {
	        name: 'Price',
	        type: 'spline',
	        data: data.vwap,
	        tooltip: {
	            valuePrefix: 'Ksh.'
	        }
	    }]
	});
});
</script>