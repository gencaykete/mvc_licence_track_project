<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo lang("Warning.title"); ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<style type="text/css">
		* {margin:0;padding:0;}
		body {
			font-family: 'Montserrat', sans-serif;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #D32F2F;
			color: #FFFFFF;
		}
		h1 {
			margin-bottom: 1.75rem;
		}
		.content {
			width: 80%;
			display: flex;
			align-items: center;
		}
		.content > div {
			flex:1;
			display: flex;
			align-items: center;
		}
		svg {
			fill: #FFFFFF;
			width: 150px;
			height: 150px;
		}
	</style>
	<?php echo warning_extra_header; ?>
</head>
<body>
	<div class="content">
		<div>
			<div>
			<h1><?php echo lang("Warning.title"); ?></h1>
			<p><?php echo lang("Warning.message"); ?></p>
			</div>
		</div>
		<svg version="1.1" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
		<path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M359.54,329.374
			c4.167,4.165,4.167,10.919,0,15.085L344.46,359.54c-4.167,4.165-10.919,4.165-15.086,0L256,286.167l-73.374,73.374
			c-4.167,4.165-10.919,4.165-15.086,0l-15.081-15.082c-4.167-4.165-4.167-10.919,0-15.085l73.374-73.375l-73.374-73.374
			c-4.167-4.165-4.167-10.919,0-15.085l15.081-15.082c4.167-4.165,10.919-4.165,15.086,0L256,225.832l73.374-73.374
			c4.167-4.165,10.919-4.165,15.086,0l15.081,15.082c4.167,4.165,4.167,10.919,0,15.085l-73.374,73.374L359.54,329.374z"/>
	</svg>
	</div>
<?php echo warning_extra_footer; ?>
</body>
</html>