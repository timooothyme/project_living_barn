<?php
	require "../assets/src/script.php";

	if (!isset($_SESSION["OSESSID"])) header("Location: ./login.php");
	
	$user_id = $_GET["id"];

	$datas = read_data("SELECT * FROM users WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
	<title>User Details - Living Barn Indonesia</title>

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
						<h1 class="text-green-600 text-2xl font-bold font-mont">User Details</h1>
						<p class="text-neutral-600">Access comprehensive user details.</p>
					</section>
					<?php foreach ($datas as $data): ?>
					<section class="pt-7 grid grid-cols-2 gap-5">
						<div class="w-full space-y-1">
							<label for="fullname" class="text-neutral-400">Full Name: </label>
							<input type="text" name="fullname" id="fullname" value="<?= $data["fullname"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="nickname" class="text-neutral-400">Nick Name: </label>
							<input type="text" name="nickname" id="nickname" value="<?= $data["nickname"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="email" class="text-neutral-400">Email: </label>
							<input type="email" name="email" id="email" value="<?= $data["email"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="phone" class="text-neutral-400">WhatsApp: </label>
							<input type="tel" name="phone" id="phone" value="<?= $data["phone"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="dateOfBirth" class="text-neutral-400">Date of Birth: </label>
							<input type="date" name="date_of_birth" id="dateOfBirth" value="<?= $data["date_of_birth"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="address" class="text-neutral-400">Address: </label>
							<textarea name="address" rows="3" id="address" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl"><?= $data["address"] ?></textarea>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="city" class="text-neutral-400">City: </label>
							<input type="text" name="city" id="city" value="<?= $data["city"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="province" class="text-neutral-400">Province: </label>
							<input type="text" name="province" id="province" value="<?= $data["province"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="country" class="text-neutral-400">Country: </label>
							<input type="text" name="country" id="country" value="<?= $data["country"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="socialMediaPlatform" class="text-neutral-400">Social Media:</label>
							<select name="social_media_platform" id="socialMediaPlatform" class="text-neutral-600 bg-transparent" readonly>
							<?php
								$social_media = explode(": ", $data["social_media"]);
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
							<input type="text" name="social_media" id="socialMedia" value="<?= ($data["social_media"] != "") ? $social_media[1] : "" ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="source" class="text-neutral-400">How did you hear about Living Barn Indonesia?</label>
							<input type="text" name="source" id="source" value="<?= $data["source"] ?>" readonly class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
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