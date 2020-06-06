<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= ucwords($params['config']['PROJECT_NAME']) ?><?= ($params['title']) ? ' - ' . ucwords($params['title']) : '' ?></title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<style>
		html, body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Nunito', sans-serif;
			font-weight: 100;
			height: 100vh;
			margin: 0;
		}

		.full-height {
			height: 100vh;
		}

		.flex-center {
			align-items: center;
			display: flex;
			justify-content: center;
		}

		.position-ref {
			position: relative;
		}

		.code {
			border-right: 0.2rem solid;
			font-size: 5rem;
			padding: 0 2rem 0 2rem;
			text-align: center;
		}

		.message {
			font-size: 3rem;
			text-align: center;
			padding: 2rem;
		}
	</style>
</head>
<body>
