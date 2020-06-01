<?php foreach ($params as $menuItem) { ?>
	<li class="nav-item<?= $menuItem['active'] ? ' active' : '' ?>">
		<a class="nav-link" href="<?= $menuItem['route'] ?>"><?= $menuItem['name'] ?></a>
	</li>
<?php } ?>