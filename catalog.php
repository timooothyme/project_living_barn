<?php
require "./assets/src/script.php";

$users = read_data("SELECT user_id FROM users");
foreach ($users as $user) $users_id[] = $user["user_id"];

if (isset($_COOKIE["SESSID"])) {
	$users_id;
	$encrypt_user_id = $_COOKIE["SESSID"];

	foreach ($users_id as $user_id) {
		if (password_verify($user_id, $encrypt_user_id)) break;
	}

	$_SESSION["SESSID"] = $user_id;
	$user = read_data("SELECT nickname FROM users WHERE user_id = $user_id");
} else if (isset($_SESSION["SESSID"])) {
	$user_id = $_SESSION["SESSID"];
	$user = read_data("SELECT nickname FROM users WHERE user_id = $user_id");
}

if (isset($_POST["search_submit"])) {
	$search_input = $_POST["search_input"];
	$catalog_items = read_data("SELECT * FROM products WHERE name LIKE '%$search_input%'");
} else {
	$catalog_items = read_data("SELECT * FROM products");
}


// --------------------

if (!isset($_SESSION["cart"])) $_SESSION['cart'] = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["add_to_cart"])) {
		$product_id = $_POST["add_to_cart"];
		add_to_cart($product_id);

		header("Refresh: 0");
	}

	if (isset($_POST["remove_from_cart"])) {
		$product_id = $_POST["remove_from_cart"];
		remove_from_cart($product_id);

		header("Refresh: 0");
	}
}

function get_product_data($product_id)
{
	global $catalog_items;

	foreach ($catalog_items as $catalog_item) {
		if ($catalog_item["product_id"] == $product_id) return $catalog_item;
	}
}

$items = isset($_COOKIE["YOUR_CART_DATA"]) ? unserialize($_COOKIE["YOUR_CART_DATA"]) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title>Catalog - Living Barn Indonesia</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./assets/src/style.css">
	<link rel="stylesheet" type="text/css" href="./assets/src/additional-style.css">
	<link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico">
</head>

<body class="text-neutral-800 font-lato bg-neutral-50">
	<!-- HEADER -->
	<header class="fixed-header fixed w-full bg-neutral-50 z-10">
		<div class="h-full px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 pb-3 sm:pb-0 xl:mx-auto xl:max-w-1366px">
			<div class="h-24 flex justify-between items-center">
				<!-- LOGO -->
				<section>
					<a href="./index.php" title="Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="flex items-center space-x-5">
						<img src="./assets/img/logo.png" alt="Logo Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="w-12 h-12">
						<span class="text-xl font-bold font-mont">Living Barn</span>
					</a>
				</section>

				<!-- NAV. -->
				<nav class="flex items-center">
					<!-- SEARCHING -->
					<form action="" method="POST" id="search-form" class="hidden sm:block mr-6">
						<div class="flex items-center px-3 pb-1.5 w-60 border-b-2 border-green-600 ">
							<input type="search" name="search_input" placeholder="Searching..." class="p-1 text-neutral-800 placeholder:text-neutral-400 bg-transparent">
							<button type="submit" name="search_submit" class="ml-4">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
									<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
								</svg>
							</button>
						</div>
					</form>

					<div class="flex items-center">
						<!-- CART -->
						<div class="mr-3">
							<button id="cart-toggle" class="p-2.5 ring-2 ring-green-600 ring-inset rounded-lg">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-cart" viewBox="0 0 16 16">
									<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
								</svg>
							</button>
						</div>

						<?php if (isset($_SESSION['SESSID'])) : ?>
							<!-- PROFILE -->
							<div>
								<button id="profile-toggle" class="p-2.5 bg-green-600 rounded-lg">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FAFAFA" stroke="#FAFAFA" stroke-width=".5" class="bi bi-person" viewBox="0 0 16 16">
										<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
									</svg>
								</button>
							</div>
						<?php endif ?>
					</div>
				</nav>
			</div>

			<!-- SEARCHING MOBILE ONLY -->
			<div class="sm:hidden flex items-center px-3 pb-1.5 border-b-2 border-green-600 ">
				<input type="search" name="search_input" placeholder="Searching..." class="p-1 grow text-neutral-800 placeholder:text-neutral-400 bg-transparent">
				<button type="submit" name="search_submit" class="ml-4">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
					</svg>
				</button>
			</div>
		</div>
	</header>

	<!-- MAIN -->
	<main class="px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px">
		<section class="pt-136px sm:pt-24">
			<section class="pt-10">
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">Catalog</h1>
				<div class="mt-5">
					<p>Our Categories</p>
					<form action="" method="POST">
						<div class="scrolling-container w-full mt-2.5 overflow-x-scroll whitespace-nowrap inline-block space-x-2.5">
							<button type="submit" name="all" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								All
							</button>
							<button type="submit" name="bakery" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Bakery
							</button>
							<button type="submit" name="gelato_beverages" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Gelato & Beverages
							</button>
							<button type="submit" name="broth_sauces" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Broth & Sauces
							</button>
							<button type="submit" name="frozen_food" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Frozen Food
							</button>
							<button type="submit" name="catering_menu" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Catering Menu
							</button>
							<button type="submit" name="holymee" class="px-4 py-2 text-neutral-50 bg-green-600 lg:text-neutral-800 lg:bg-transparent hover:text-neutral-50 hover:bg-green-600 rounded-lg">
								Holymee
							</button>
						</div>
					</form>
				</div>
			</section>

			<!-- CATALOG ITEMS -->
			<section class="pt-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
				<?php foreach ($catalog_items as $catalog_item) : ?>
					<section class="bg-white rounded-2xl">
						<div class="h-28 sm:h-32 lg:h-44 bg-neutral-200 rounded-t-2xl">
							<img src="./assets/database/img/<?= $catalog_item["picture"] ?>" alt="" class="w-full h-full object-cover object-center rounded-t-2xl">
						</div>
						<div class="px-4 pt-8 pb-4 sm:px-5 sm:pt-7 sm:pb-5 md:px-6 md:pb-6 lg:p-8 text-center">
							<h4 class="font-bold">
								<a href="./product.php?product=<?= $catalog_item["product_id"] ?>"><?= $catalog_item["name"] ?></a>
							</h4>
							<p class="pt-2">Rp. <?= $catalog_item["price"] ?></p>
							<p class="pt-6 sm:pt-7">
								<span>⭐⭐⭐⭐⭐</span><br class="lg:hidden">
								<span class="text-xs"><?= $catalog_item["review"] ?> Reviews</span>
							</p>
							<form action="" method="POST">
								<div class="pt-4 w-full">
									<button type="submit" name="add_to_cart" value="<?= $catalog_item["product_id"] ?>" <?= in_array($catalog_item["product_id"], $items) ? 'disabled' : '' ?> class="w-full py-2.5 ring-2 ring-green-600 ring-inset rounded-lg" style="display: flex; justify-content: center; align-items: center">
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="sm:mr-3 bi bi-cart" viewBox="0 0 16 16">
											<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
										</svg>
										<span class="hidden sm:block text-green-600 font-bold">Add to Cart</span>
									</button>
								</div>
							</form>
						</div>
					</section>
				<?php endforeach ?>
			</section>
		</section>
	</main>

	<!-- FOOTER -->
	<footer class="mt-20 text-neutral-200 bg-neutral-800">
		<div class="pt-14 sm:pt-12 md:pt-14 lg:pt-20 px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px sm:grid sm:grid-cols-6 sm:gap-x-5 lg:gap-x-8">
			<section class="sm:col-span-2">
				<a href="./index.php" title="Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="flex items-center space-x-3">
					<img src="./assets/img/logo.png" alt="Logo Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="w-10 h-10">
					<span class="text-neutral-200 text-base font-bold font-mont">Living Barn</span>
				</a>
				<div class="mt-5 sm:mt-6 lg:mt-10 space-x-4 lg:space-x-5 flex items-center">
					<a href="https://instagram.com/livingbarn?igshid=YmMyMTA2M2Y" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" fill="#E5E5E5" class="w-5 h-5 lg:w-6 lg:h-6 bi bi-instagram" viewBox="0 0 16 16">
							<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
						</svg>
					</a>
					<a href="https://wa.me/+6281339224800?text=Halo,%20Living%20Barn!" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" fill="#E5E5E5" class="w-5 h-5 lg:w-6 lg:h-6 bi bi-whatsapp" viewBox="0 0 16 16">
							<path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
						</svg>
					</a>
				</div>
			</section>
			<section class="sm:mt-3 sm:col-span-4 sm:grid sm:grid-cols-2 sm:gap-x-5 lg:gap-x-8">
				<div class="mt-14 sm:mt-0">
					<p class="font-bold">Contact</p>
					<ul class="mt-5 space-y-2">
						<li>livingbarn.id@gmail.com</li>
						<li>PASIFICA 2, Jl. Danau Batur Raya No. 51, Jimbaran, South Kuta, Badung, Bali 80361</li>
						<li>+62 813 3922 4800</li>
					</ul>
				</div>
				<div class="mt-8 sm:mt-0">
					<p class="font-bold">Subscribe</p>
					<p class="mt-5">
						Stay in the loop with our latest updates and exclusive offers by subscribing to our email newsletter.
					</p>
					<form action="" method="POST" class="mt-5 px-6 py-2.5 w-full flex items-center bg-neutral-700 space-x-3 rounded-lg">
						<input type="text" name="email" placeholder="Email" class="grow bg-transparent placeholder:text-neutral-200">
						<button type="submit" name="email_submit" class="p-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#E5E5E5" class="bi bi-send" viewBox="0 0 16 16">
								<path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
							</svg>
						</button>
					</form>
				</div>
			</section>
		</div>
		<section class="mt-12 sm:mt-14 py-8 lg:py-10 text-center border-t-2 border-neutral-700">
			<p>&copy; 2023 Living Barn Indonesia. <br class="sm:hidden">Powered by Timo Studio.</p>
		</section>
	</footer>

	<!-- -------------------- -->

	<!-- CART POPUP -->
	<div id="cart-popup" class="hidden fixed top-32 left-0 w-full h-full z-20">
		<div class="sm:absolute sm:right-52px mx-5 sm:mx-10 md:mx-12 lg:mx-16 xl:mx-24 px-5 sm:w-96 bg-neutral-50 rounded-2xl">
			<div class="pt-5">
				<p class="font-bold font-mont">Your Shopping Cart</p>
			</div>
			<?php if (!empty($items)) : ?>
				<div class="pt-5 space-y-2.5">
					<?php
					$counter = 0;
					$limiter = 3;
					foreach ($items as $item) :
						if ($counter >= $limiter) break;
						$product = get_product_data($item);
					?>
						<div class="relative h-full flex items-center space-x-5">
							<div class="h-12 w-12 bg-red-200 rounded-lg">
								<img src="./assets/database/img/<?= $product["picture"] ?>" alt="" class="w-full h-full object-cover object-center rounded-lg">
							</div>
							<a href="./product.php?product=<?= $product["product_id"] ?>" class="font-bold">
								<?= $product["name"] ?>
							</a>
							<form action="" method="POST" class="absolute right-0">
								<button type="submit" name="remove_from_cart" value="<?= $product["product_id"] ?>" class="p-2.5">
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-x" viewBox="0 0 16 16">
										<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
									</svg>
								</button>
							</form>
						</div>
						<?php $counter++ ?>
					<?php endforeach ?>
					<?php if (count($items) > $limiter) : ?>
						<div class="mt-2.5">
							<a href="./checkout.php" class="text-neutral-600 text-sm text-center hover:font-bold float-right" style="width: 95.44px">See more items</a>
						</div>
					<?php endif ?>
				</div>
				<div class="clear-right py-8">
					<a href="./checkout.php" class="block py-2.5 text-green-600 text-center font-bold ring-2 ring-green-600 ring-inset rounded-lg hover:text-neutral-50 hover:bg-green-600">Checkout</a>
				</div>
			<?php else : ?>
				<div class="py-10 text-center">
					<p>Empty cart!</p>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- PROFILE POPUP -->
	<div id="profile-popup" class="hidden fixed top-32 left-0 w-full h-full z-20">
		<div class="absolute right-0 mx-5 sm:mx-10 md:mx-12 lg:mx-16 xl:mx-24 px-5 pb-5 w-52 bg-neutral-50 rounded-2xl">
			<div class="py-5">
				<p class="font-bold font-mont"><?= $user[0]["nickname"] ?></p>
			</div>
			<div>
				<ul class="space-y-.5">
					<li>
						<a href="profile-settings.php" class="block text-center hover:font-bold" style="width: 109.45px">Profile Settings</a>
					</li>
					<!-- <li>
    				<a href="shopping-history.php" class="block text-center hover:font-bold" style="width: 123.47px">Shopping History</a>
    			</li> -->
				</ul>
			</div>
			<div class="mt-8">
				<a href="./logout.php" class="block py-2.5 text-green-600 text-center ring-2 ring-green-600 ring-inset hover:text-neutral-50 hover:bg-green-600 rounded-lg">Logout</a>
			</div>
		</div>
	</div>

	<!-- OVERLAY BACKGROUND -->
	<div id="overlay" class="fixed top-0 w-full h-full hidden bg-neutral-800 opacity-50 z-10"></div>

	<script>
		// HEADER SHADOW EFFECT
		window.addEventListener("scroll", function() {
			let header = document.querySelector(".fixed-header")
			let scrolled = window.scrollY > 0

			header.classList.toggle("scrolled", scrolled)
		})

		// CART POPUP

		let cartToggle = document.getElementById("cart-toggle")
		let cartPopup = document.getElementById("cart-popup")

		let overlay = document.getElementById("overlay")

		cartToggle.addEventListener("click", function() {
			cartPopup.classList.remove("hidden")
			overlay.classList.remove("hidden")
		})

		overlay.addEventListener("click", function() {
			cartPopup.classList.add("hidden")
		})

		// PROFILE POPUP
		let profileToggle = document.getElementById("profile-toggle")
		let profilePopup = document.getElementById("profile-popup")

		profileToggle.addEventListener("click", function() {
			profilePopup.classList.remove("hidden")
			overlay.classList.remove("hidden")
		})

		overlay.addEventListener("click", function() {
			profilePopup.classList.add("hidden")
		})


		overlay.addEventListener("click", function() {
			overlay.classList.add("hidden")
		})
	</script>
</body>

</html>