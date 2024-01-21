<?php use App\Utils\Auth; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bike Shop</title>


	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						clifford: '#da373d',
					}
				}
			}
		}
	</script>

</head>

<body>
	<header class="bg-gray-100">
		<div class="mx-auto">
			<nav class="flex justify-around ">
				<ul class="flex items-center space-x-4">
					<li class="nav-item p-4"><a class="
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
					<li class="nav-item"> <a class="
					nav-link
					<?= \App\Helpers\NavigationHelper::isLinkActive('/cart', $uri) ?>
					" href="/cart">cart</a></li>

				</ul>


				<ul class="flex justify-around items-center space-x-4">


					<?php if (!Auth::isLoggedIn()): ?>
						<li class="nav-item"> <a class="
					nav-link
					<?= \App\Helpers\NavigationHelper::isLinkActive('/signup', $uri) ?>
					" href="/signup">signup</a></li>

						<li class="nav-item"> <a class="
					nav-link
					<?= \App\Helpers\NavigationHelper::isLinkActive('/login', $uri) ?>
					" href="/login">login</a></li>

					<?php else: ?>




						<li class="nav-item"> <a class="nav-link <?= \App\Helpers\NavigationHelper::isLinkActive('/admin', $uri) ?>
									" href="/admin">admin</a></li>

						<li class="nav-item">
							<form action="/logout" class="nav-link" method="post"><input type="submit" value="logout"></form>
						</li>
					<?php endif; ?>

				</ul>
			</nav>

		</div>
	</header>

	<main class="container mx-auto my-8">
		<?= $bodyContent ?>
	</main>


</body>

</html>