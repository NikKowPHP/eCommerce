<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bike Shop</title>

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
					<?= \App\Helpers\NavigationHelper::isLinkActive('/', $uri) ?>
					" href="/">home</a></li>
					<li class="nav-item"> <a class="
					nav-link
					<?= \App\Helpers\NavigationHelper::isLinkActive('/products', $uri) ?>
					" href="/products">products</a></li>
					<li class="nav-item"> <a class="
					nav-link
					<?= \App\Helpers\NavigationHelper::isLinkActive('/contact', $uri) ?>
					" href="/contact">contact</a></li>
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