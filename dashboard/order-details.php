<?php
	require "../assets/src/script.php";

	if (!isset($_SESSION["OSESSID"])) header("Location: ./login.php");

	$order_id = $_GET["id"];

	$datas             = read_data("SELECT * FROM orders WHERE order_id = $order_id");

	$user_id           = $datas[0]["user_id"];
	$user_datas        = read_data("SELECT * FROM users WHERE user_id = $user_id");
	$customer_name     = $user_datas[0]["fullname"];
	$customer_phone    = $user_datas[0]["phone"];
	$customer_address  = $user_datas[0]["address"];
	$customer_city     = $user_datas[0]["city"];
	$customer_province = $user_datas[0]["province"];
	$customer_country  = $user_datas[0]["country"];

	if (isset($_POST["update"])) {
		$completion_at = (isset($_POST["completion_at"])) ? $_POST["completion_at"]: "0000-00-00 00: 00: 00";
		$processing_at = (isset($_POST["processing_at"])) ? $_POST["processing_at"]: "0000-00-00 00: 00: 00";

		$query = "UPDATE orders SET processing_at = '$processing_at', completion_at = '$completion_at' WHERE order_id = $order_id";
		mysqli_query($conn, $query);

		header("Location: ./");
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
	<title>Order Details - Living Barn Indonesia</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../assets/src/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/src/additional-style.css">
	<link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>
<body class="text-neutral-800 font-lato bg-neutral-50">
	<!-- HEADER -->
	<header class="fixed-header fixed w-full h-24 bg-neutral-50">
		<div class="h-full px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px flex justify-end items-center">
			<nav>
				<a href="./" class="block text-center hover:font-bold" style="width: 43.22px">Back</a>
			</nav>
		</div>
	</header>

	<!-- MAIN -->
	<main class="pt-24">
		<div class="px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px">
			<div class="pt-10 sm:pt-20 lg:pt-2 pb-20 sm:pb-24 md:pb-28 lg:pb-40 sm:mx-auto sm:w-96 md:w-auto md:grid md:grid-cols-4 lg:grid-cols-6">
				<div class="md:col-span-1 lg:col-span-2"></div>
				<form action="" method="POST" class="col-span-2">
					<section class="space-y-2 5">
						<h1 class="text-green-600 text-2xl font-bold font-mont">Order Details</h1>
						<p class="text-neutral-600">Access and edit comprehensive order details.</p>
					</section>
					<?php foreach ($datas as $data): ?>
					<section class="pt-7 grid grid-cols-2 gap-5">
						<div class="w-full space-y-1 col-span-2">
							<label for="orderID" class="text-neutral-400">Order ID: </label>
							<input type="text" name="order_id" id="orderID" value="<?= $data["order_id"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2 text-neutral-600">
							<label class="text-neutral-400">Status: </label>
							<div class="flex items-center space-x-2">
								<input type="checkbox" name="processing_at" id="processingAt" value="<?= date("Y-m-d H:i:s") ?>" <?= ($data["processing_at"] != "0000-00-00 00:00:00") ? "checked" : "" ?>>
								<label for="processingAt">On Process</label>
							</div>
							<div class="flex items-center space-x-2">
								<input type="checkbox" name="completion_at" id="completionAt" value="<?= date("Y-m-d H:i:s") ?>" <?= ($data["completion_at"] != "0000-00-00 00:00:00") ? "checked" : "" ?>>
								<label for="completionAt">Complete</label>
							</div>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="customerName" class="text-neutral-400">Customer: </label>
							<input type="text" name="customer_name" id="customerName" value="<?= $customer_name ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="phone" class="text-neutral-400">WhatsApp: </label>
							<input type="tel" name="phone" id="phone" value="<?= $customer_phone ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="address" class="text-neutral-400">Address: </label>
							<textarea name="address" rows="3" id="address" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl"><?= $customer_address ?></textarea>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="city" class="text-neutral-400">City: </label>
							<input type="text" name="city" id="city" value="<?= $customer_city ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="province" class="text-neutral-400">Province: </label>
							<input type="text" name="province" id="province" value="<?= $customer_province ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="country" class="text-neutral-400">Country: </label>
							<input type="text" name="country" id="country" value="<?= $customer_country ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="col-span-2">
							<p>Ordered Products:</p>
							<ul class="ml-4">
								<?php
									$items = json_decode($data["items"], true);
									foreach ($items[0] as $index => $item):
										$product = read_data("SELECT * FROM products WHERE product_id = $item");
								?>
								<li class="list-decimal">
									<span class="block font-bold"><?= $product[0]["name"] ?></span>
									<span class="block">Rp. <?= $product[0]["price"] ?> × <?= $items[1][$index] ?> = Rp. <?= $items[1][$index] * $product[0]["price"] ?></span>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
					</section>
					<?php endforeach ?>

					<button type="submit" name="update" class="w-full mt-5 py-2.5 text-neutral-50 font-bold bg-green-600 hover:ring-2 hover:ring-green-600 hover:ring-inset hover:text-green-600 hover:bg-transparent focus:ring-1 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">Update</button>
				</form>
				<div class="md:col-span-1 lg:col-span-2"></div>
			</div>
		</div>
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

	<script>
// HEADER SHADOW EFFECT
window.addEventListener("scroll", function() {
	let header   = document.querySelector(".fixed-header")
	let scrolled = window.scrollY > 0

	header.classList.toggle("scrolled", scrolled)
})
	</script>
</body>
</html>