<?php $this->render('app/views/layout/header', $params); ?>

<?php
$htmlPlayers = [
    [
        'type'   => 'player',
        'name'   => 'hero',
        'params' => $params['hero']
    ],
    [
        'type' => 'aux',
        'html' => '<div class="col-md-2 align-self-center">' .
            '<h1 class="card card-block border-0 text-center">' .
            ($params['hero']['first_strike'] ? '&#129094;' : '&#129092;') .
            '</h1>' .
            '</div>',
    ],
    [
        'type'   => 'player',
        'name'   => 'beast',
        'params' => $params['beast']
    ]
];
?>

	<div class="row justify-content-center row-eq-height" id="players-stats">
        <?php foreach ($htmlPlayers as $areas): ?>
            <?php if ($areas['type'] === 'player') : ?>
				<div class="col-md-5 border<?= $areas['params']['first_strike'] ? ' border-success' : ' border-danger' ?>">
					<table class="table" id="<?= $areas['name'] ?>>">
						<tbody>
						<tr>
							<td class="name border-bottom border-top-0 text-center">
								<h3><?= $areas['params']['name'] ?></h3>
								<h6><?= $areas['params']['first_strike'] ? 'attacker' : 'defender' ?></h6>
							</td>
						</tr>
						<tr>
							<td class="border-0">
								<table class="table border-0 table-sm" id="<?= $areas['name'] ?>-attributes"
								       data-action="<?= $areas['params']['first_strike'] ? '1' : '0' ?>">
									<tbody>
									<tr>
										<td class="border-0" colspan="2"><h5>Attributes</h5></td>
									</tr>
                                    <?php foreach ($areas['params']['attributes'] as $name => $value): ?>
										<tr data-name="<?= $name ?>" data-value="<?= $value ?>">
											<td class="border-0"><?= ucfirst($name) ?></td>
											<td class="border-0 attr-value"><?= $value ?><?= $name === 'luck' ? '%' : '' ?></td>
										</tr>
                                        <?php
                                        if ($name === 'health'):
                                            switch ($value):
                                                case $value > 75:
                                                    $classProgress = ' bg-success';
                                                    break;
                                                case $value > 50 && $value < 74:
                                                    $classProgress = ' bg-info';
                                                    break;
                                                case $value > 25 && $value < 49:
                                                    $classProgress = ' bg-warning';
                                                    break;
                                                case $value > 0 && $value < 24:
                                                    $classProgress = ' bg-danger';
                                                    break;
                                            endswitch;
                                            ?>
											<tr>
												<td class="border-0" colspan="2">
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated<?= $classProgress ?>"
														     role="progressbar" style="width: <?= $value ?>%;"
														     aria-valuenow="<?= $value ?>" aria-valuemin="0"
														     aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
            <?php else: ?>
                <?= $areas['html'] ?>
            <?php endif; ?>
        <?php endforeach; ?>
	</div>

	<div class="row justify-content-center" id="battle-stats" data-round="<?= $params['round'] ?>">
		<div class="col-md-12">

		</div>
	</div>

	<div class="row justify-content-center" id="actions">
		<div class="col-md-12 text-center">
			<a href="javascript:void(0);" id="fight"
			   class="btn btn-danger btn-lg btn-top"
			   role="button"
			   aria-pressed="true">Fight</a>
		</div>
	</div>

<?php $this->render('app/views/layout/footer', $params['config']); ?>