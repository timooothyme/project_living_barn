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

	if (!isset($_SESSION["SESSID"])) header("Location: ./login.php");
	if (!isset($_COOKIE["YOUR_CART_DATA"])) header("Location: ./catalog.php");

	$checkout_items = read_data("SELECT * FROM products");

	// --------------------

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["remove_from_cart"])) {
			$product_id = $_POST["remove_from_cart"];
			remove_from_cart($product_id);

			header("Refresh: 0");
		}
	}

	function get_product_data($product_id) {
		global $checkout_items;

		foreach ($checkout_items as $checkout_item) {
			if ($checkout_item["product_id"] == $product_id) return $checkout_item;
		}
	}

	$items = isset($_COOKIE["YOUR_CART_DATA"]) ? unserialize($_COOKIE["YOUR_CART_DATA"]) : [];

	$order_count = (isset($_POST["order_submit"])) ? $_POST["order_count"] : [];
	if (isset($_POST["order_submit"])) {
		foreach ($items as $key => $item) {
			$order_count[$key] = (isset($_POST["order_count"][$key])) ? $_POST["order_count"][$key] : 1;
		}
	}

	$order_id = substr(rand(), 0, 5);
	$checkout = json_encode([$items, $order_count]);

	if (isset($_POST["checkout_submit"])) {
	$user_datas = read_data("SELECT * FROM users WHERE user_id = $user_id");
	$user_datas = $user_datas[0];

		if (!empty($user_datas["phone"]) && !empty($user_datas["address"]) && !empty($user_datas["city"]) && !empty($user_datas["province"]) && !empty($user_datas["country"])) {
			$created_at = date("Y-m-d H:i:s");

			$order_id      = $_POST["order_id"];
			$user_id       = $_POST["user_id"];
			$checkout      = $_POST["checkout"];

			$weight        = $_POST["weight"];
			$courier       = $_POST["courier"];
			$shipping_cost = $_POST["shipping_cost"];

			if (empty($weight) && empty($courier) && empty($shipping_cost)) {
				header("Refresh: 0");
				exit;
			}
			
	    $query = "INSERT INTO orders VALUES ($order_id, $user_id, '$checkout', $weight, '$courier', $shipping_cost, '$created_at', '', '')";
			mysqli_query($conn, $query);

			unset($_SESSION["cart"]);
			setcookie("YOUR_CART_DATA", "", time() - 1);
			// header("Location: ./catalog.php");
			header("Location: https://wa.me/+6281339224800?text=Halo,%20Living%20Barn!");

			exit;
		}

		header("Location: ./profile-settings.php");
	}

	// ----------

	$curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "key: 4fb242a1c81734fe8b29980346dc64c8"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $data = json_decode($response);
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
	<title>Checkout - Living Barn Indonesia</title>

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
				<nav>
					<div class="flex items-center">
						<div class="mr-6">
							<a href="./catalog.php" class="block text-center hover:font-bold" style="width: 35.5px">Back</a>
						</div>

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
		</div>
	</header>

	<!-- MAIN -->
	<main class="px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px">
		<section class="pt-24 lg:grid lg:grid-cols-7 lg:gap-x-5">
			<!-- CHECKOUT -->
			<section class="pt-10 lg:col-span-5">
				<h1 class="text-neutral-800 text-3xl font-bold font-mont">Checkout</h1>
				<div class="scrolling-container mt-4 w-full overflow-x-scroll whitespace-nowrap">
					<!-- TABLE -->
					<div class="w-640px sm:w-full text-left space-y-2.5">
						<!-- TABLE HEADER -->
						<div class="flex px-4 py-2.5 font-bold bg-white rounded-xl sm:rounded-2xl">
							<div class="w-1/2">Product</div>
							<div class="w-1/4">Quantity</div>
							<div class="w-1/4">Total Price</div>
						</div>

						<!-- TABLE ROW -->
						<form action="" method="POST" id="order" class="w-1/4 flex items-center space-x-3"></form>
						<?php
							$total = 0;
							$total_weight = 0;
							foreach ($items as $key => $item):
								$product = get_product_data($item);
								$quantity_per_box = json_decode($product["packaging"], true);
								$quantity_per_box = $quantity_per_box[1];

								$discount = json_decode($product["discount"], true);
								$minimal_order = $discount[0];
								$discount = $discount[1]
						?>
						<div class="flex items-center px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div class="w-1/2 flex items-center space-x-6">
								<div class="w-12 h-12 sm:w-16 sm:h-16 bg-neutral-200 rounded-xl sm:rounded-2xl">
			            <img src="./assets/database/img/<?= $product["picture"] ?>" alt="" class="w-full h-full object-cover object-center rounded-xl sm:rounded-2xl">
								</div>
								<p><?= $product["name"] ?></p>
							</div>
							
							<div class="w-1/4 flex items-center space-x-3">
	          		<input type="number" name="order_count[<?= $key ?>]" min="1" value="<?= (isset($order_count[$key])) ? $order_count[$key] : 1 ?>" form="order" required class="px-4 py-2.5 w-14 bg-transparent ring-2 ring-green-600 ring-inset rounded-lg">
	          		<button type="submit" name="order_submit" form="order">
	          			<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
									  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
									  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
									</svg>
	          		</button>
							</div>
							<div class="w-1/4 flex justify-between items-center">
								<p>Rp. 
									<?php
										if (isset($order_count[$key])) {
											$order_count[$key] = intval($order_count[$key]);
											if ($order_count[$key] > $quantity_per_box) {
												$close_to_discount = $order_count[$key] / $quantity_per_box;
												if ($close_to_discount >= $minimal_order[0] && $close_to_discount >= $minimal_order[1]  && $close_to_discount >= $minimal_order[2]) {
													$initial_price = ($close_to_discount * $quantity_per_box) * $product["price"];
													$price = $initial_price - (($discount[2] / 100) * $initial_price);
													echo $initial_price;
												} else if ($close_to_discount >= $minimal_order[0] && $close_to_discount >= $minimal_order[1]) {
													$initial_price = ($close_to_discount * $quantity_per_box) * $product["price"];
													$price = $initial_price - (($discount[1] / 100) * $initial_price);
													echo $initial_price;
												} else if ($close_to_discount >= $minimal_order[0]) {
													$initial_price = ($close_to_discount * $quantity_per_box) * $product["price"];
													$price = $initial_price - (($discount[0] / 100) * $initial_price);
													echo $initial_price;
												} else {
													$price = ($close_to_discount * $quantity_per_box) * $product["price"];
													echo $price;
												}
											} else {
												echo $price = $order_count[$key] * $product["price"];
											}
										} else {
											echo $price = $product["price"];
										}
									?>
								</p>
								<!-- <p>Rp. <?php // echo $price = (isset($order_count[$key])) ? $order_count[$key] * $product["price"] : $product["price"]; ?></p> -->
								<?php $weight = (isset($order_count[$key])) ? $order_count[$key] * $product["weight"] : 0; ?>
								<form action="" method="POST">
			          	<button type="submit" name="remove_from_cart" value="<?= $product["product_id"] ?>" class="p-2.5">
			          		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#16A34A" stroke="#16A34A" stroke-width=".5" class="bi bi-x" viewBox="0 0 16 16">
										  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
										</svg>
			          	</button>
			          </form>
							</div>
						</div>
						<?php
							$total += $price;
							$total_weight += $weight;
						?>
						<?php endforeach ?>

						<!-- TABLE FOOTER -->
						<div class="flex px-4 py-4 bg-white rounded-xl sm:rounded-2xl">
							<div class="w-3/4 font-bold">Total</div>
							<div class="w-1/4">Rp. <?= $total ?></div>
						</div>
					</div>
				</div>
			</section>

			<!-- SHIPPING & PAYMENT -->
			<section class="pt-10 sm:w-96 lg:col-span-2">
				<div>
					<h2 class="text-neutral-800 text-3xl font-bold font-mont">Shipping</h2>
					<div class="mt-4 p-5 bg-white rounded-xl sm:rounded-2xl">
						<div>
							<div>
								<label for="provinceDestination" class="text-neutral-600">Destination Province</label><br>
								<select id="provinceDestination" class="w-full p-2.5 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-lg" onchange="requestCityDestination(this.value)">
									<option>Select Province</option>
									<?php foreach ($data->rajaongkir->results as $value): ?>
										<option value="<?= $value->province_id?>"><?= $value->province ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="pt-2.5">
								<label for="cityDestination" class="text-neutral-600">Destination City</label><br>
								<select id="cityDestination" class="w-full p-2.5 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-lg">
									<option>Select City</option>
								</select>
							</div>
							<div class="pt-2.5">
								<label for="courier" class="text-neutral-600">Courier</label><br>
								<select id="courierOrigin" class="w-full p-2.5 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-lg" onchange="sendCourierData()">
									<option>Select Courier</option>
									<option value="jne">JNE</option>
									<option value="tiki">TIKI</option>
									<option value="pos">POS Indonesia</option>
								</select>
							</div>
						</div>
						<div>
							<div class="w-full mt-8 py-2.5 text-center bg-transparent ring-2 ring-green-600 ring-inset rounded-lg">
								<p class="text-green-600 font-bold">Rp. <span id="shippingCost2">-</span></p>
							</div>
							<div class="mt-2.5">
								<button type="submit" name="courier_submit" class="w-full px-6 py-2.5 text-neutral-50 text-center font-bold bg-green-600 hover:ring-2 hover:ring-green-600 hover:ring-inset hover:text-green-600 hover:bg-transparent focus:ring-1 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-lg" onclick="shippingCost()">Check</button>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-4">
					<h2 class="text-neutral-800 text-3xl font-bold font-mont">Payment</h2>
					<div class="mt-4 p-5 bg-white rounded-xl sm:rounded-2xl">
						<ul class="ml-5 text-neutral-600 space-y-1 list-decimal">
							<li>Verify and ensure that the quantity of the desired products has been entered correctly, then click the "Refresh" button.</li>
							<li>Copy the order code that appears after refreshing.</li>
							<li>Click the "Checkout" button to be directed to WhatsApp.</li>
							<li>Paste the order code when communicating with the admin for the verification process.</li>
						</ul>
						<form action="" method="POST">
							<div class="w-full mt-8 py-2.5 text-center bg-transparent ring-2 ring-green-600 ring-inset rounded-lg">
								<p class="text-green-600 font-bold"><?= "#" . $order_id ?></p>
							</div>
							<div class="mt-2.5">
								<form action="" method="POST" id="checkoutForm">
									<input type="hidden" name="order_id" value='<?= $order_id ?>'>
									<input type="hidden" name="user_id" value='<?= $user_id ?>'>
									<input type="hidden" name="checkout" value='<?= $checkout ?>'>

									<input type="hidden" name="weight" value="<?= $total_weight ?>" id="weight">
									<input type="hidden" name="courier" value="" id="courier">
									<input type="hidden" name="shipping_cost" value="" id="shippingCost1">
									<button type="submit" name="checkout_submit" class="w-full px-6 py-2.5 text-neutral-50 text-center font-bold bg-green-600 hover:ring-2 hover:ring-green-600 hover:ring-inset hover:text-green-600 hover:bg-transparent focus:ring-1 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-lg">Checkout</button>
								</form>
							</div>
						</form>
					</div>
				</div>
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
						  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
						</svg>
					</a>
					<a href="https://wa.me/+6281339224800?text=Halo,%20Living%20Barn!" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" fill="#E5E5E5" class="w-5 h-5 lg:w-6 lg:h-6 bi bi-whatsapp" viewBox="0 0 16 16">
						  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
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
							  <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
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
	<div id="overlay" class="hidden fixed top-0 w-full h-full bg-neutral-800 opacity-50 z-10"></div>

	<script>
// HEADER SHADOW EFFECT
window.addEventListener("scroll", function() {
	let header   = document.querySelector(".fixed-header")
	let scrolled = window.scrollY > 0

	header.classList.toggle("scrolled", scrolled)
})

// PROFILE POPUP
let profileToggle = document.getElementById("profile-toggle")
let profilePopup  = document.getElementById("profile-popup")

let overlay   = document.getElementById("overlay")

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

function requestCityDestination(id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("cityDestination").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "requestCity.php?id=" + id, true);
	xmlhttp.send();
}

function shippingCost() {
	var cityOrigin      = 17,
			cityDestination = document.getElementById("cityDestination").value,
			weight          = document.getElementById("weight").value,
			courier         = document.getElementById("courierOrigin").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("shippingCost1").value = this.responseText;
			document.getElementById("shippingCost2").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", `requestCost.php?origin=${cityOrigin}&destination=${cityDestination}&weight=${weight}&courier=${courier}`, true);
	xmlhttp.send();
}

function sendCourierData() {
	var courierOrigin = document.getElementById("courierOrigin").value;

	document.getElementById("courier").value = courierOrigin;
}
	</script>
</body>
</html>