<?php
	require "../assets/src/script.php";

	if (!isset($_SESSION["OSESSID"])) header("Location: ./login.php");

	if (isset($_POST["user_submit"])) {
		$user_input = $_POST["user_input"];
		$users = read_data("SELECT * FROM users WHERE fullname LIKE '%$user_input%' OR nickname LIKE '%$user_input%' OR email LIKE '%$user_input%' OR phone LIKE '%$user_input%'");
	} else {
		$users = read_data("SELECT * FROM users");
	}

	if (isset($_POST["product_submit"])) {
		$product_input = $_POST["product_input"];
		$products = read_data("SELECT * FROM products WHERE name LIKE '%$product_input%'");
	} else {
		$products = read_data("SELECT * FROM products");
	}

	if (isset($_POST["category_submit"])) {
		$category_input = $_POST["category_input"];
		$categories = read_data("SELECT * FROM categories WHERE name LIKE '%$category_input%'");
	} else {
		$categories = read_data("SELECT * FROM categories");
	}

	if (isset($_POST["order_submit"])) {
		$order_input = $_POST["order_input"];
		$orders = read_data("SELECT * FROM orders WHERE order_id LIKE '%$order_input%'");
	} else {
		$orders = read_data("SELECT * FROM orders");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
	<title>Admin Dashboard - Living Barn Indonesia</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../assets/src/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/src/additional-style.css">
	<link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>
<body class="text-neutral-800 font-lato bg-neutral-50">
	<!-- HEADER -->
	<header class="fixed-header fixed w-full h-24 bg-neutral-50 z-10">
		<div class="h-full px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px flex justify-between items-center">
			<!-- LOGO -->
			<section>
				<a href="./" class="text-xl font-bold font-mont">
					Admin Dashboard
				</a>
			</section>

			<!-- NAV. -->
			<nav>
				<div class="flex items-center">
					<!-- TOGGLE -->
					<div class="mr-6 flex items-center lg:hidden">
						<button id="nav-toggle">
							<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
							  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
							</svg>
						</button>
					</div>

					<!-- LINKS -->
					<ul class="hidden lg:inline-flex mr-6 space-x-5">
						<li>
							<a href="./#user" class="inline-block text-center hover:font-bold" style="width: 33.73px">User</a>
						</li>
						<li>
							<a href="./#product" class="inline-block text-center hover:font-bold" style="width: 57.69px">Product</a>
						</li>
						<li>
							<a href="./#category" class="inline-block text-center hover:font-bold" style="width: 43.55px">Order</a>
						</li>
						<li>
							<a href="./#order" class="inline-block text-center hover:font-bold" style="width: 43.55px">Order</a>
						</li>
					</ul>

					<!-- PROFILE -->
					<div>
						<button id="profile-toggle" class="p-2.5 bg-green-600 rounded-lg">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FAFAFA" stroke="#FAFAFA" stroke-width=".5" class="bi bi-person" viewBox="0 0 16 16">
							  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
							</svg>
						</button>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<main class="px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px">
		<!-- USER -->
		<section class="relative pt-136px sm:pt-24">
			<div id="user" class="absolute -top-24 -mt-10 sm:-mt-12 md:-mt-14 lg:-mt-20"></div>
			<div class="pt-10">
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">User</h1>

				<!-- SEARCHING -->
				<form action="" method="POST" id="search-form" class="mt-4">
					<div class="flex items-center px-3 pb-1.5 w-60 border-b-2 border-green-600 ">
						<input type="search" name="user_input" placeholder="Searching..." class="p-1 text-neutral-800 placeholder:text-neutral-400 bg-transparent">
						<button type="submit" name="user_submit" class="ml-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
							  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg>
						</button>
					</div>
				</form>
				<div class="scrolling-container mt-4 w-full overflow-x-scroll whitespace-nowrap">
					<!-- TABLE -->
					<div class="text-left space-y-2.5" style="width: 900px;">
						<!-- TABLE HEADER -->
						<div class="flex px-4 py-2.5 font-bold bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"></div>
							<div style="width: 40%;">Name</div>
							<div class="w-1/4">Created</div>
							<div class="w-1/4">Last Login</div>
							<div class="w-1/4">Updated</div>
						</div>

						<!-- TABLE ROW -->
						<?php
							$i = 1;
							foreach ($users as $user):
						?>
						<div class="flex items-center px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"><?= $i; ?></div>
							<div style="width: 40%;">
								<a href="./user-details.php?id=<?= $user["user_id"] ?>"><?= $user["fullname"] ?></a>
							</div>
							<div class="w-1/4">
	          		<p><?= $user["created_at"] ?></p>
							</div>
							<div class="w-1/4">
								<p><?= $user["last_login_at"] ?></p>
							</div>
							<div class="w-1/4">
								<p>
								<?php
									$updated_at = ($user["updated_at"] != "0000-00-00 00:00:00") ? $user["updated_at"] : '-';
									echo $updated_at;
								?>
								</p>
							</div>
						</div>
						<?php $i++ ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</section>

		<!-- PRODUCT -->
		<section class="relative mt-10 sm:mt-12 md:mt-14 lg:mt-20 ">
			<div id="product" class="absolute -top-24 -mt-10 sm:-mt-12 md:-mt-14 lg:-mt-20"></div>
			<div>
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">Product</h1>

				<!-- SEARCHING -->
				<form action="" method="POST" id="search-form" class="mt-4">
					<div class="flex items-center px-3 pb-1.5 w-60 border-b-2 border-green-600 ">
						<input type="search" name="product_input" placeholder="Searching..." class="p-1 text-neutral-800 placeholder:text-neutral-400 bg-transparent">
						<button type="submit" name="product_submit" class="ml-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
							  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg>
						</button>
					</div>
				</form>

				<?php if ($_SESSION["OSESSID"] == "SUPERADMIN"): ?>
					<a href="./add-product.php" class="text-green-600 inline-block mt-2">Add Product</a>
				<?php endif ?>
				<div class="scrolling-container mt-4 w-full overflow-x-scroll whitespace-nowrap">
					<!-- TABLE -->
					<div class="text-left space-y-2.5" style="width: 900px;">
						<!-- TABLE HEADER -->
						<div class="flex px-4 py-2.5 font-bold bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"></div>
							<div style="width: 40%;">Name</div>
							<div class="w-1/4">Price</div>
							<div class="w-1/4">Stock</div>
						</div>

						<!-- TABLE ROW -->
						<?php
							$i = 1;
							foreach ($products as $product):
						?>
						<div class="flex items-center px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"><?= $i; ?></div>
							<div style="width: 40%;">
								<a href="./product-details.php?id=<?= $product["product_id"] ?>"><?= $product["name"] ?></a>
							</div>
							<div class="w-1/4">
	          		<p><?= $product["price"] ?></p>
							</div>
							<div class="w-1/4">
								<p><?= $product["stock"] ?></p>
							</div>
						</div>
						<?php $i++ ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</section>

		<!-- CATEGORY -->
		<section class="relative mt-10 sm:mt-12 md:mt-14 lg:mt-20 ">
			<div id="category" class="absolute -top-24 -mt-10 sm:-mt-12 md:-mt-14 lg:-mt-20"></div>
			<div>
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">Category</h1>

				<!-- SEARCHING -->
				<form action="" method="POST" id="search-form" class="mt-4">
					<div class="flex items-center px-3 pb-1.5 w-60 border-b-2 border-green-600 ">
						<input type="search" name="category_input" placeholder="Searching..." class="p-1 text-neutral-800 placeholder:text-neutral-400 bg-transparent">
						<button type="submit" name="category_submit" class="ml-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
							  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg>
						</button>
					</div>
				</form>

				<?php if ($_SESSION["OSESSID"] == "SUPERADMIN"): ?>
					<a href="./add-category.php" class="text-green-600 inline-block mt-2">Add Category</a>
				<?php endif ?>
				<div class="scrolling-container mt-4 w-full overflow-x-scroll whitespace-nowrap">
					<!-- TABLE -->
					<div class="text-left space-y-2.5" style="width: 250px;">
						<!-- TABLE HEADER -->
						<div class="flex px-4 py-2.5 font-bold bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 50%;">Name</div>
							<div style="width: 50%;">Code</div>
						</div>

						<!-- TABLE ROW -->
						<?php foreach ($categories as $category): ?>
						<div class="flex items-center px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 50%;">
								<a href="./category-details.php?id=<?= $category["category_id"] ?>"><?= $category["name"] ?></a>
							</div>
							<div style="width: 50%">
	          		<p><?= $category["category_id"] ?></p>
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</section>

		<!-- ORDER -->
		<section class="relative mt-10 sm:mt-12 md:mt-14 lg:mt-20 ">
			<div id="order" class="absolute -top-24 -mt-10 sm:-mt-12 md:-mt-14 lg:-mt-20"></div>
			<div class="pb-20 sm:pb-24 md:pb-28 lg:pb-40">
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">Orders</h1>

				<!-- SEARCHING -->
				<form action="" method="POST" id="search-form" class="mt-4">
					<div class="flex items-center px-3 pb-1.5 w-60 border-b-2 border-green-600 ">
						<input type="search" name="order_input" placeholder="Searching..." class="p-1 text-neutral-800 placeholder:text-neutral-400 bg-transparent">
						<button type="submit" name="order_submit" class="ml-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-search" viewBox="0 0 16 16">
							  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg>
						</button>
					</div>
				</form>
				<div class="scrolling-container mt-4 w-full overflow-x-scroll whitespace-nowrap">
					<!-- TABLE -->
					<div class="text-left space-y-2.5" style="width: 900px;">
						<!-- TABLE HEADER -->
						<div class="flex px-4 py-2.5 font-bold bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"></div>
							<div class="w-1/4">Order Code</div>
							<div class="w-1/4">Entry</div>
							<div class="w-1/4">Processed</div>
							<div class="w-1/4">Completed</div>
							<div class="w-1/4">Status</div>
						</div>

						<!-- TABLE ROW -->
						<?php
							$i = 1;
							foreach ($orders as $order):
						?>
						<div class="flex items-center px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div style="width: 80px;"><?= $i ?></div>
							<div class="w-1/4">
								<a href="./order-details.php?id=<?= $order["order_id"] ?>">#<?= $order["order_id"] ?></a>
							</div>
							<div class="w-1/4">
	          		<p><?= $order["entry_at"] ?></p>
							</div>
							<div class="w-1/4">
								<p><?= ($order["processing_at"] == "0000-00-00 00:00:00") ? "-" : $order["processing_at"] ?></p>
							</div>
							<div class="w-1/4">
								<p><?= ($order["completion_at"] == "0000-00-00 00:00:00") ? "-" : $order["completion_at"] ?></p>
							</div>
							<div class="w-1/4">
								<p>
									<?php
										if ($order["processing_at"] != "0000-00-00 00:00:00") {
											echo "On Progress";
										} else if ($order["completion_at"] != "0000-00-00 00:00:00") {
											echo "Completed";
										} else {
											echo "-";
										}
									?>
								</p>
							</div>
						</div>
						<?php $i++ ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<!-- FOOTER -->
	<footer>
		<div class="py-8 lg:py-10 text-center">
			<p class="text-neutral-600">
				&copy; 2023 Living Barn Indonesia. <br class="sm:hidden">
				Powered by Timo Studio.
			</p>
		</div>
	</footer>

	<!-- -------------------- -->

	<!-- NAV. TOGGLE -->
	<div id="main-nav" class="hidden fixed top-0 left-0 px-5 sm:px-10 md:px-12 w-full sm:w-3/4 h-full lg:hidden bg-neutral-50 z-20">
		<div class="h-24 flex justify-between items-center">
	    <p class="text-xl font-bold font-mont">Menu</p>
	    <button id="nav-close">
				<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="$262626" class="bi bi-x" viewBox="0 0 16 16">
				  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</button>
		</div>
		<div class="pt-7">
			<ul class="space-y-5">
				<li>
					<a href="./#user" class="inline-block text-center hover:font-bold" style="width: 33.73px">User</a>
				</li>
				<li>
					<a href="./#product" class="inline-block text-center hover:font-bold" style="width: 57.69px">Product</a>
				</li>
				<li>
					<a href="./#order" class="inline-block text-center hover:font-bold" style="width: 43.55px">Order</a>
				</li>
			</ul>
		</div>
	</div>

	<!-- PROFILE POPUP -->
	<div id="profile-popup" class="hidden fixed top-32 left-0 w-full h-full z-20">
		<div class="absolute right-0 mx-5 sm:mx-10 md:mx-12 lg:mx-16 xl:mx-24 px-5 pb-5 w-52 bg-neutral-50 rounded-2xl">
			<div class="py-5">
        <p class="font-bold font-mont"><?= $_SESSION["OSESSID"] ?></p>
      </div>
    	<div>
    		<a href="./logout.php" class="block py-2.5 text-green-600 text-center ring-2 ring-green-600 ring-inset hover:text-neutral-50 hover:bg-green-600 rounded-lg">Logout</a>
    	</div>
		</div>
	</div>

	<!-- OVERLAY BACKGROUND -->
	<div id="overlay" class="fixed top-0 w-full h-full hidden bg-neutral-800 opacity-50 z-10">s</div>

	<script>
// HEADER SHADOW EFFECT
window.addEventListener("scroll", function() {
	let header   = document.querySelector(".fixed-header")
	let scrolled = window.scrollY > 0

	header.classList.toggle("scrolled", scrolled)
})

// NAV TOGGLE
let navToggle = document.getElementById("nav-toggle")
let navClose  = document.getElementById("nav-close")
let mainNav   = document.getElementById("main-nav")

let overlay   = document.getElementById("overlay")

navToggle.addEventListener("click", function() {
	mainNav.classList.remove("hidden")
	overlay.classList.remove("hidden")
})

navClose.addEventListener("click", function() {
	mainNav.classList.add("hidden")
	overlay.classList.add("hidden")
})

overlay.addEventListener("click", function() {
	mainNav.classList.add("hidden")
})

// PROFILE POPUP
let profileToggle = document.getElementById("profile-toggle")
let profilePopup  = document.getElementById("profile-popup")

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