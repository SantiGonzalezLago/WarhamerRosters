<?php
// WarhammerRosters
// Copyright (C) 2022 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<!DOCTYPE html>
<head>
	<title><?= (isset($title) ? $title . ' - ' : '') ?>Warhammer Rosters</title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/png" href="<?= base_url('/favicon.ico') ?>"/>

	<script>
		const LANG = JSON.parse('<?= json_encode(lang('Script.js')) ?>');
		const BASE_URL = "<?= base_url() ?>";
	</script>

	<script type="text/javascript" src="<?= base_url('/assets/js/jquery-3.6.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/assets/js/jquery-ui.min.js') ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/bootstrap.min.css') ?>">
	<script type="text/javascript" src="<?= base_url('/assets/js/bootstrap.bundle.min.js') ?>"></script>

	<script type="text/javascript" src="<?= base_url('/assets/js/bootstrap-select.min.js') ?>"></script>
	<link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap-select.min.css') ?>" />

	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/datatables.min.css') ?>"/>
	<script type="text/javascript" src="<?= base_url('/assets/js/datatables.min.js') ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/purecookie.css') ?>"/>
	<script type="text/javascript" src="<?= base_url('/assets/js/purecookie.js') ?>"></script>

	<script type="text/javascript" src="<?= base_url('/assets/js/main.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/main.css') ?>">
</head>

<body>

	<header class="p-0">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
			<div class="container-fluid">
				<a class="navbar-brand" href="<?= base_url() ?>"><span class="title">Warhammer Rosters</span> <small class="text-muted">(βeta)</small></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbar-content">
					<!-- MENU PARTE DERECHA -->
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item"><a class="nav-link" href="https://github.com/SantiGonzalezLago/WarhammerRosters/issues" target="_blank"><?= lang('Head.feedback') ?></a></li>
					</ul>
					<!-- MENU PARTE IZQUIERDA -->
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<?php if($userdata) : ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="user-dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?= $userdata['display_name'] ?>
								</a>
								<ul class="dropdown-menu dropdown-menu-end" id="user-dropdown" aria-labelledby="user-dropdown-toggle">
									<li><a class="dropdown-item" href="<?= base_url('upload') ?>"><?= lang('Upload.upload_roster') ?></a></li>
									<li><hr class="dropdown-divider"></li>
									<li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><?= lang('Auth.logout') ?></a></li>
								</ul>
							</li>
						<?php else : ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="login-dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?= lang('Auth.login') ?>
								</a>
								<div class="dropdown-menu dropdown-menu-end" id="login-dropdown" aria-labelledby="login-dropdown-toggle">
									<form id="login-form" method="post" accept-charset="UTF-8">
										<div id="login-error" class="alert alert-warning" style="display:none;">error</div>
										<input type="email" id="login-email" class="form-control" required placeholder="<?= lang('Auth.email') ?>.."/><br>
										<input type="password" id="login-password" class="form-control" required placeholder="<?= lang('Auth.pwd') ?>.."/><br>
										<button type="submit" class="btn btn-primary form-control"><?= lang('Auth.login') ?></button>
									</form>
								</div>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
	</header>

	<main class="container py-3">
		<?= view($view, $data ?? []) ?>
	</main>

	<footer class="container">
		<div class="d-flex flex-wrap justify-content-between align-items-center py-2 mt-3 border-top">
			<p class="col-md-4 mb-0 text-muted">© 2022 Santiago González Lago</p>

			<a href="<?= base_url() ?>" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
				<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
			</a>

			<ul class="nav col-md-4 justify-content-end">
				<li class="nav-item"><a href="<?= base_url() ?>" class="nav-link px-2 text-muted"><?= lang('Footer.home') ?></a></li>
				<li class="nav-item"><a href="<?= base_url('privacy') ?>" class="nav-link px-2 text-muted"><?= lang('Footer.privacy') ?></a></li>
			</ul>
		</div>
	</footer>
</body>