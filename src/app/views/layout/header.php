<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?= $params['config']['PROJECT_DESCRIPTION'] ?>">
		<meta name="author" content="<?= $params['config']['PROJECT_AUTHOR'] ?>">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="<?= $params['token'] ?>">

		<link rel="icon" href="/app/assets/img/favicon.ico">
		<link rel="apple-touch-icon" sizes="180x180" href="/app/assets/img/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/app/assets/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/app/assets/img/favicon-16x16.png">

		<title><?= ucwords($params['config']['PROJECT_NAME']) ?><?= ($params['title']) ? ' - ' . ucwords($params['title']) : '' ?></title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
		      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

		<!-- Custom project styles -->
		<link href="/app/assets/css/project.css" rel="stylesheet">
	</head>

	<body>
		<header>
			<!-- Fixed navbar -->
			<nav class="navbar navbar-expand-md fixed-top navbar-dark site-header">
				<div class="container">
					<a class="navbar-brand" href="/">
						<img alt="--><? //=ucwords($params['PROJECT_NAME'])?><!--" class="top-brand"
						     src="/app/assets/img/emagia.svg">
		                <?= ucwords($params['config']['PROJECT_NAME']) ?>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
					        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarCollapse">
						<ul class="navbar-nav mr-auto">
		                    <?php $this->render('app/views/layout/top_menu', $params['menu']); ?>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<!-- Begin page content -->
		<main role="main" class="container">
        <?php if ($params['messages']) : ?>
        <?php foreach ($params['messages'] as $type => $messageSet) : ?>
            <?php foreach ($messageSet as $message) : ?>
			<div class="alert alert-<?=$type?> alert-dismissible fade show" role="alert">
                <?=$message['message']?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <?php endif; ?>
