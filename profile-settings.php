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
		$users = read_data("SELECT * FROM users WHERE user_id = $user_id");
	} else if (isset($_SESSION["SESSID"])) {
		$user_id = $_SESSION["SESSID"];
		$users = read_data("SELECT * FROM users WHERE user_id = $user_id");
	}

	if (!isset($_SESSION["SESSID"])) header("Location: ./login.php");

	if (isset($_POST["update"])) {
		$updated_at    = date("Y-m-d H:i:s");

		$fullname      = stripslashes(htmlspecialchars($_POST["fullname"]));
		$nickname      = stripslashes(htmlspecialchars($_POST["nickname"]));
		$phone         = stripslashes(htmlspecialchars($_POST["phone"]));
		$date_of_birth = stripslashes(htmlspecialchars($_POST["date_of_birth"]));
		$address       = stripslashes(htmlspecialchars($_POST["address"]));
		$city          = stripslashes(htmlspecialchars($_POST["city"]));
		$province      = stripslashes(htmlspecialchars($_POST["province"]));
		$country       = stripslashes(htmlspecialchars($_POST["country"]));
		$social_media  = $_POST["social_media_platform"] . ": " . stripslashes(htmlspecialchars($_POST["social_media"]));
		$source        = stripslashes(htmlspecialchars($_POST["source"]));

		$query = "UPDATE users SET fullname = '$fullname', nickname = '$nickname', phone = $phone, date_of_birth = '$date_of_birth', address = '$address', city = '$city', province = '$province', country = '$country', updated_at = '$updated_at', social_media = '$social_media', source = '$source' WHERE user_id = $user_id";
		mysqli_query($conn, $query);

		header("Refresh: 0");
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
	<title>Profile Settings - Living Barn Indonesia</title>

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
						<h1 class="text-green-600 text-2xl font-bold font-mont">Profile Settings</h1>
						<p class="text-neutral-600">Customize your profile and manage your account settings effortlessly.</p>
					</section>
					<?php foreach ($users as $user): ?>
					<section class="pt-7 grid grid-cols-2 gap-5">
						<div class="w-full space-y-1">
							<label for="fullname" class="text-neutral-400">Full Name: </label>
							<input type="text" name="fullname" id="fullname" value="<?= $user["fullname"] ?>" maxlength="50" required autofocus class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="nickname" class="text-neutral-400">Nick Name: </label>
							<input type="text" name="nickname" id="nickname" value="<?= $user["nickname"] ?>" maxlength="50" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="email" class="text-neutral-400">Email: </label>
							<input type="email" name="email" id="email" value="<?= $user["email"] ?>" readonly required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="phone" class="text-neutral-400">WhatsApp: </label>
							<input type="tel" name="phone" id="phone" value="<?= $user["phone"] ?>" placeholder="081234567890" maxlength="20" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="dateOfBirth" class="text-neutral-400">Date of Birth: </label>
							<input type="date" name="date_of_birth" id="dateOfBirth" value="<?= $user["date_of_birth"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="address" class="text-neutral-400">Address: </label>
							<textarea name="address" rows="3" id="address" placeholder="Jl. Ahmad Yani No. 123, Kota Baru, Provinsi Jawa Timur" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl"><?= $user["address"] ?></textarea>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="city" class="text-neutral-400">City: </label>
							<input type="text" name="city" id="city" value="<?= $user["city"] ?>" placeholder="Kota Baru" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="province" class="text-neutral-400">Province: </label>
							<input type="text" name="province" id="province" value="<?= $user["province"] ?>" placeholder="Jawa Timur" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="country" class="text-neutral-400">Country: </label>
							<input type="text" name="country" id="country" value="<?= $user["country"] ?>" placeholder="Indonesia" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="social_media_platform" class="text-neutral-400">Social Media:</label>
							<select name="social_media_platform" id="socialMediaPlatform" class="text-neutral-600 bg-transparent" required>
							<?php
								$social_media = explode(": ", $user["social_media"]);
								$social_media_platforms = ["Facebook", "Instagram", "Twitter", "TikTok"];
								foreach ($social_media_platforms as $social_media_platform):
									if ($social_media[0] == $social_media_platform):
							?>
								<option value="<?= $social_media_platform ?>" selected><?= $social_media_platform ?></option>
								<?php else: ?>
								<option value="<?= $social_media_platform ?>"><?= $social_media_platform ?></option>
								<?php endif ?>
							<?php endforeach ?>
							</select>
							<input type="text" name="social_media" id="socialMedia" value="<?= ($user["social_media"] != "") ? $social_media[1] : "" ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="source" class="text-neutral-400">How did you hear about Living Barn Indonesia?</label>
							<input type="text" name="source" id="source" value="<?= $user["source"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
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