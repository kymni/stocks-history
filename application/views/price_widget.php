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

	var series=[{name: "High", color: "#2fc67d", data: []},
				{name: "Low", color: "#dd3b3b", data: []},
				{name: "VWAP", color: "#ceb940", data: []}];
	var dates=[];
	for (var i=0; i<data['dates'].length; i++) {
		if (data['vwap'][i] > 0) {
			for (var j=0; j<series.length; j++) {
				switch (series[j].name) {
				case "High":
					series[j]['data'].push(data['high'][i]);
					break;
				case "Low":
					series[j]['data'].push(data['low'][i]);
					break;
				case "VWAP":
					series[j]['data'].push(data['vwap'][i]);
					break;
				}
			}
			dates.push(data['dates'][i]);
		}
	}

	$("#security-graph").highcharts({
		title: {
			text: '<?=$name?>'
		},

		subtitle: {
			text: 'Data source: NSE equity pricelist'
		},

		xAxis: {
			categories: dates
		},

		yAxis: {
			title: {
				text: 'Price (Ksh.)'
			}
		},
		plotOptions: {
			line: {
				marker: {
					enabled: false
				}
			}
		},

		series: series
	});
});
</script>