<title>NSE Securities Performance</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css" integrity="sha384-Tfj13fqQQqqzQFuaZ81WDzmmOU610WeS08VMuHmElK5oI2f7NwojuL6VupYXR/jK" crossorigin="anonymous">
<link rel="stylesheet" href="<?=base_url()?>resources/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.5.4/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js" integrity="sha384-UM1JrZIpBwVf5jj9dTKVvGiiZPZTLVoq4sfdvIe9SBumsvCuv6AHDNtEiIb5h1kU" crossorigin="anonymous"></script>
<div class="container-fluid" style="padding-top: 10px; min-height: 500px">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>"><?=$title?></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown" id="price_link">
						<a href="<?=base_url()?>index.php/price<?=(isset($company) ? "/$company/$start/$end": "")?>">Prices</a>
					</li>
					<li class="dropdown" id="volume_link">
						<a href="<?=base_url()?>index.php/volume<?=(isset($company) ? "/$company/$start/$end": "")?>">Volumes</a>
					</li>
				</ul>
				<p class="navbar-text navbar-right" style="margin-top: 10px; margin-bottom: 10px">
					<a href="https://www.github.com/kymni" target="_blank" class="navbar-link" style="float: right">
						<img alt="dev" src="<?=base_url()?>resources/images/kymni-transparent.png" style="height: 30px">
					</a>
				</p>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div class="row">
		<div class="col-md-4">
			<select class="form-control input-md selectpicker form-elements" id="industries">
				<option value="">--Industry--</option>
			</select>
		</div>
		<div class="col-md-4">
			<select class="form-control input-md selectpicker form-elements" id="securities">
				<option value="">--Company--</option>
			</select>
		</div>
		<div class="col-md-4">
			<div class="input-daterange input-group">
				<input type="text" class="input-sm form-control date-picker form-elements" id="start" value="<?=$start?>"/>
				<span class="input-group-addon">to</span>
				<input type="text" class="input-sm form-control date-picker form-elements" id="end" value="<?=$end?>"/>
				<span class="input-group-btn">
					<button id="search" type="submit" class="btn btn-default">Search</button>
				</span>
			</div>
		</div>
	</div>
