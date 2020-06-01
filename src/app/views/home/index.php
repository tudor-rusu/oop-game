<?php $this->render('app/views/layout/header', $params); ?>

<?php
echo $params['message'];
?>

<?php $this->render('app/views/layout/footer', $params['config']); ?>