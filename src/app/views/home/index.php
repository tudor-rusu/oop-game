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
            '<h1 class="card card-block border-0 text-center" id="center-info">' .
            '<span id="turn-side">' .
            ($params['hero']['first_strike'] ? '&#129094;' : '&#129092;') .
            '</span><br /><span id="current-turn"><small>turn<br />1</small></span>' .
            '</h1>' .
            '<a href="javascript:void(0);" id="fight"
			   class="btn btn-danger btn-lg text-center"
			   role="button"
			   aria-pressed="true">Fight</a>' .
            '<a href="javascript:window.location.reload();" id="new-battle"
			   class="btn btn-success btn-lg text-center"
			   role="button"
			   aria-pressed="true">New Battle</a>' .
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
				<div class="col-md-5 border<?= $areas['params']['first_strike'] ? ' border-success' : ' border-danger' ?>"
				     id="<?= $areas['name'] ?>-card">
					<div class="player-luck" id="<?= $areas['name'] ?>-luck">
						<h1>&#9752;</h1>
					</div>
					<div class="player-dead" id="<?= $areas['name'] ?>-dead">
						<h1 class="text-center">&#9760;</h1>
					</div>
					<table class="table" id="<?= $areas['name'] ?>">
						<tbody>
						<tr>
							<td class="name border-bottom border-top-0 text-center">
								<h3><?= $areas['params']['name'] ?></h3>
								<h6 id="<?= $areas['name'] ?>-fight-status"><?= $areas['params']['first_strike'] ? 'attacker' : 'defender' ?></h6>
							</td>
						</tr>
						<tr>
							<td class="border-0">
								<table class="table border-0 table-sm" id="<?= $areas['name'] ?>-attributes"
								       data-action="<?= $areas['params']['first_strike'] ? '1' : '0' ?>"
								       data-player="<?= $areas['params']['name'] ?>">
									<tbody>
									<tr>
										<td class="border-0" colspan="2"><h5>Attributes</h5></td>
									</tr>
                                    <?php foreach ($areas['params']['attributes'] as $name => $value): ?>
										<tr data-name="<?= $name ?>" data-value="<?= $value ?>">
											<td class="border-0"><?= ucfirst($name) ?></td>
											<td class="border-0 text-right attr-value"><?= $value ?><?= $name === 'luck' ? '%' : '' ?></td>
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

	<div class="row justify-content-center" id="battle-stats" data-turn="<?= $params['turn'] ?>"
	     data-maxturns="<?= $params['max-turns'] ?>">
		<div class="col-md-12">
			<table class="table table-striped" id="battle-statistics">
				<thead>
				<tr>
					<th scope="col">Turn</th>
					<th scope="col">Atacker</th>
					<th scope="col">Defender Luck</th>
					<th scope="col">Defender Damage</th>
					<th scope="col">Defender Health</th>
					<th scope="col">Hero Skill</th>
					<th scope="col">Winner</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>

<?php $this->render('app/views/layout/footer', $params['config']); ?>