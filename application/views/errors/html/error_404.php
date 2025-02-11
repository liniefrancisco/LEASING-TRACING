<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="utf-8">
  	<title>ERROR 404 | AGC-TSMS</title>
  	<link rel="stylesheet" type="text/css" href="/AGC-TSMS/css/font-awesome.min.css"> 
	<link rel="stylesheet" type="text/css" href="/AGC-TSMS/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/AGC-TSMS/css/noty-animate.css">
	<link rel="stylesheet" type="text/css" href="/AGC-TSMS/css/animate.css">
	<style type="text/css">
		a {
			color: #09f;
		}

		body{
		   background-color: #a6a6a6;
		   background: url(/AGC-TSMS/img/tsms2.jpg) no-repeat center center fixed; 
		}

		p {
			font-size: 16px;
		}
		h1{
			font-size: 35px;
			font-weight: bold;
		}

		.cont{
			background: rgba(0, 151, 19, 0.15);
			padding: 40px;
			margin: 20px !important;
			border-radius: 3px;
		}

	</style>
</head>
<body>
  	<div class="cont">
  		<div class="card card-info">
  			<div class="card-header">
  				<h1>
  					<?php echo $heading; ?>
  				</h1>
  			</div>
		  	<div class="card-body">
		   		<?php echo $message; ?>
		  	</div>
		</div>
	</div>
</body>
</html>