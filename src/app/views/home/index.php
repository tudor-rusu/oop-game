<?php $this->render('app/views/layout/header', $params); ?>

	<div class="row justify-content-center">
		<div class="col-md-6">
			hero
			<a href="javascript:void(0);" id="fight"
			   class="btn btn-danger btn-sm btn-top"
			   role="button"
			   aria-pressed="true">
				FIGHT
			</a>
		</div>
		<div class="col-md-6">
			beast
		</div>
	</div>

<?php $this->render('app/views/layout/footer', $params['config']); ?>