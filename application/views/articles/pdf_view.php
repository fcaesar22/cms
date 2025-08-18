<!DOCTYPE html>
<html> 
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Dens Life&Style</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<style type="text/css">
	@font-face {
		font-family: 'Montserrat';
		src:  url('/assets/fonts/Montserrat/Montserrat-Regular.ttf')  format('truetype');
	}
	body {
		font-family: 'Montserrat', sans-serif;
	}
	page {
		background: white;
		display: block;
		margin: 0 auto;
	}
	page[size="A4"] {  
		width: 21cm;
		height: 29.7cm; 
	}
	page .main-container {
		width: 90%; 
		margin: 0 auto;
	}
	@media print {
		body, page {
			margin: 0;
			box-shadow: 0;
		}
	}    
	.header {
		display: block;
		margin: 0 auto;
		width: 35%;
	}
	hr {
		border-bottom: 1px solid #ccc;
	}
	#gallery .main {
		float: left; 
		width: 75%
	}
	#gallery .main video, #gallery .main img {
		width: 95%
	}
	#gallery .thumbnails {
		float: left; 
		width: 25%
	}
	#gallery .thumbnails img {
		width: 95%;
	}
	.clearfix {
		clear: both;
	}
	#main {
		width: 100%; 
		float: left;
	}
	#main .container {
		padding-right: 10px; 
		word-wrap: break-word
	}
	#twocolumn .left {
		float: left;
		width: 50%;
	}
	#twocolumn .left h4 {
		text-align: center;
	}
	#twocolumn .left div {
		padding-right: 20px;
	}   
	#twocolumn .left ul {        
		margin: 0;
		padding: 0;
		list-style: none;
	}
	#twocolumn .left ul li {
		text-align: left;
		padding: 10px 0;
		border-bottom: 1px solid #ccc;
		font-size: 14px;
	}
	#twocolumn .left ul li:last-child {
		border: none;
	}
	#twocolumn .right {
		float: left;
		width: 50%;
	}
	#twocolumn .right div {
		padding-left: 20px;
	}   
	#twocolumn .right h4 {
		text-align: center;
	}        
	#twocolumn .right ol {        
		margin: 0;
		padding: 0;
	}
	#twocolumn .right ol li {            
		text-align: justify;
		padding: 10px 0;
		border-bottom: 1px solid #ccc;     
		font-size: 14px;       
	}
	#twocolumn .right ol li:last-child { 
		border: none;
	}
	#sidebar {
		width: 30%; 
		float: left;
	}
	#sidebar .container {
		word-wrap: break-word;
		margin-top: -9px;
		padding-left: 10px;
	}
	.advertising {
		border: 1px solid #ccc;
		padding: 15px;
		margin: 10px 5px 20px 5px;
	}
	.advertising .logo {
		width: 75%;
		display: block;
		margin: 0 auto;
	}
	.advertising .product-image img {
		width: 100%;
	}
	.advertising .product-price {
		color: #141518;
		text-align: center;
		font-size: 18px;
	}
	.advertising .product-title {        
		font-size: 14px;
		margin: 0;
		padding: 0;
		text-align: center;
	}
</style>

<body>
	<page size="A4">
		<div class="main-container">
			<!-- content -->
			<div id="main">
				<div class="container">
					<table>
						<tbody>
							<tr>
					  			<td rowspan="5" valign="top">
					  				<img style="width:480px;height:280px;" src="<?php echo $poster_url ?>">
					  			</td>
							</tr>
							<tr style="height:90px;">
					  			<td>
					  				<img style="width:180px; height:90px;" src="<?php echo $poster_url ?>">
					  			</td>
							</tr>
							<?php 
								$default = base_url() . "assets/img/transparent.png";
								$gambar = $default;
								$jumlah = count($poster); 
								foreach ($poster as $key => $value) {
							?>
							<tr style="height:90px;">
					  			<td>
						  			<?php if ($value['poster_url']) {
						  				$gambar = $value['poster_url'];
						  			} ?>
						  			<img style="width:180px; height:90px;" src="<?php echo $gambar ?>">
					  			</td>
							</tr>
							<?php 
							}
							if ($jumlah == 1) {
								echo "<tr style=\"height:90px;\"> <td><img style=\"width:180px; height:90px;\" src=".$default."></td> </tr>";	
							}
							if ($jumlah == 0) {
								echo "<tr style=\"height:90px;\"> <td><img style=\"width:180px; height:90px;\" src=".$default."></td> </tr><tr style=\"height:90px;\"> <td><img style=\"width:180px; height:90px;\" src=".$default."></td> </tr>";
							}
							?>
						</tbody>
					</table>
					
					<div class="clearfix"></div>

					<h3><?php echo $article_title ?></h3>
					<h4>By: <?php echo $article_by ?></h4>

					<div id="twocolumn">
						<div class="left">
							<div>
								<?php echo $article_content_1 ?>
							</div>
						</div>
						<div class="right">
							<div>
								<?php echo $article_content_2 ?>
							</div>
						</div>
					</div>                    
				</div>
			</div>
		</div>
	</page>
</body>
</html>