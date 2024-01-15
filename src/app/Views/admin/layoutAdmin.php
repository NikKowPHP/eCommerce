<?php use App\Utils\Auth; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bike Shop Admin</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
	<header class="bg-body-tertiary">
		<div class="container">
			<nav class="navbar navbar-expand-md navbar-expand-lg ">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-around">

					<li class="nav-item "><a class="
					nav-link 
					<?= \App\Helpers\NavigationHelper::isLinkActive('/admin/products', $uri) ?>
					" href="/admin/products">Products</a></li>

					<li class="nav-item "><a class="
					nav-link 
					<?= \App\Helpers\NavigationHelper::isLinkActive('/admin/users', $uri) ?>
					" href="/admin/users">Users</a></li>

					<li class="nav-item "><a class="
					nav-link 
					<?= \App\Helpers\NavigationHelper::isLinkActive('/', $uri) ?>
					" href="/">home</a></li>



					<li class="nav-item">
						<form action="/logout" class="nav-link" method="post"><input type="submit" value="logout"></form>
					</li>

				</ul>
			</nav>

		</div>
	</header>

	<main>
		<?= $bodyContent ?>
	</main>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>