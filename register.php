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
	}
	
	if (isset($_SESSION["SESSID"])) header("Location: ./catalog.php");

	if (isset($_POST["register"])) {
		if (register($_POST) === true) header("Location: ./login.php");
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
	<title>Register - Living Barn Indonesia</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./assets/src/style.css">
	<link rel="stylesheet" type="text/css" href="./assets/src/additional-style.css">
	<link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico">
</head>
<body class="text-neutral-800 font-lato bg-neutral-50">
	<!-- HEADER -->
	<header class="fixed-header fixed w-full h-24 bg-neutral-50">
		<div class="h-full px-5 sm:px-10 md:px-12 lg:px-16 xl:px-24 xl:mx-auto xl:max-w-1366px flex justify-between items-center">
			<!-- LOGO -->
			<section>
				<a href="./index.php" title="Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="flex items-center space-x-5">
					<img src="./assets/img/logo.png" alt="Logo Living Barn Indonesia - 100% Gluten-Free for a Healthy Life." class="w-12 h-12">
					<span class="text-xl font-bold font-mont">Living Barn</span>
				</a>
			</section>

			<!-- NAV. -->
			<nav>
				<a href="./index.php" class="block text-center hover:font-bold" style="width: 43.22px">Home</a>
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
						<h1 class="text-green-600 text-2xl font-bold font-mont">Register for an Account</h1>
						<p class="text-neutral-600">Please complete the information below to register for a new account in our system.</p>
					</section>
					<section class="pt-7 grid grid-cols-2 gap-5">
						<div class="w-full space-y-1">
							<label for="fullname" class="text-neutral-400">Full Name: </label>
							<input type="text" name="fullname" id="fullname" placeholder="John Doe" maxlength="50" required autofocus class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="nickname" class="text-neutral-400">Nick Name: </label>
							<input type="text" name="nickname" id="nickname" placeholder="John" maxlength="50" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="email" class="text-neutral-400">Email: </label>
							<input type="email" name="email" id="email" placeholder="johndoe@gmail.com" maxlength="100" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="password" class="text-neutral-400">Password: </label>
							<input type="password" name="password" id="password" placeholder="••••••" minlength="8" maxlength="32" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="password_confirm" class="text-neutral-400">Password Confirm: </label>
							<input type="password" name="password_confirm" id="password_confirm" placeholder="••••••" minlength="8" maxlength="32" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
					</section>

					<button type="submit" name="register" class="w-full mt-5 py-2.5 text-neutral-50 font-bold bg-green-600 hover:ring-2 hover:ring-green-600 hover:ring-inset hover:text-green-600 hover:bg-transparent focus:ring-1 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">Registration</button>
					<a href="./login.php" class="block pt-2.5 text-neutral-400 text-sm text-center hover:text-neutral-800">Already have an account? Login</a>
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