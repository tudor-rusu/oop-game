<?php $this->render('app/views/layout/header_minimal', $params); ?>

		<div class="flex-center position-ref full-height">
			<div class="code">
		        <?= $params['code'] ?>
			</div>

			<div class="message">
		        <?= $params['message'] ?>
			</div>
		</div>

<?php $this->render('app/views/layout/footer_minimal', []); ?>
