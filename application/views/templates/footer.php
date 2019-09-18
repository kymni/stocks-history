</div>
<script type="text/javascript">
var securities = <?=json_encode($securities)?>;
$("#<?=$type?>_link").addClass('active');

$(document).ready(function(){
	Highcharts.setOptions({
	    lang: {
	        thousandsSep: ','
	    }
	});

	//insert industries
	for (industry in securities) {
		$("#industries").append('<option value="'+industry+'">'+industry+'</option>');
	}
	<?php //if a company is set, select it
	if (isset($industry)):?>
	$("#industries").val("<?=$industry?>");
	for (security in securities["<?=$industry?>"]) {
		$("#securities").append('<option value="'+security+'">'+securities['<?=$industry?>'][security]+'</option>');
	}
	<?php if (isset($company)):?>
	$("#securities").val("<?=$company?>");
	<?php endif;?>
	<?php endif;?>
	$('.selectpicker').selectpicker('refresh');

	//if a date filter exists, initialize datepicker library
	$('.input-daterange').datepicker({
		format: "yyyy-mm-dd"
	});

	/*$('.date-picker').change(function(){
		//getData();
	});*/
});

$("#industries").change(function(){
	$("#securities").html('<option value="">--Company--</option>');
	$("#security-graph").html("");
	var industry = $(this).val();
	if (industry !== "") {
		for (security in securities[industry]) {
			$("#securities").append('<option value="'+security+'">'+securities[industry][security]+'</option>');
		}
	}
	$('.selectpicker').selectpicker('refresh');
});

$("#securities").change(function(){
	//var security = $(this).val();
	$("#security-graph").html("");

	if ($(this).val() != "" && $("#start").val() != "" && $("#end").val() != "") {
		window.location = "<?=base_url()?>index.php/<?=$type?>/"+$("#securities").val()+"/"+$("#start").val()+"/"+$("#end").val();
	}

	/*if (security != ""){
		window.location = "<?=base_url()?>index.php/stock-price/"+security;
	} else {
		window.location = "<?=base_url()?>index.php";
	}
	security = $( "#securities option:selected" ).text();*/
	//getData();
});

$("#search").click(function(){
	if ($("#securities").val() != "" && $("#start").val() != "" && $("#end").val() != "") {
		window.location = "<?=base_url()?>index.php/<?=$type?>/"+$("#securities").val()+"/"+$("#start").val()+"/"+$("#end").val();
	} else {
		alert("Company, start, and end date need to be selected");
	}
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.5.4/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js" integrity="sha384-vSdYrU7lSLRoeJP8+brQ26ad7tTrch3Rbp7wOYQ9U+9+SpJO5le1+vWHKzK1w58d" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.1.3/highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.1.3/modules/exporting.js"></script>