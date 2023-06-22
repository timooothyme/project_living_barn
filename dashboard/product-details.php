<?php
	require "../assets/src/script.php";

	if (!isset($_SESSION["OSESSID"])) header("Location: ./login.php");

	$product_id = $_GET["id"];

	$datas = read_data("SELECT * FROM products WHERE product_id = $product_id");

	if (isset($_POST["update"])) {
		if (isset($_POST["featured"]) == "1") {
			$featured = stripslashes(htmlspecialchars($_POST["featured"]));
		} else {
			$featured = "0";
		}
		
		if (isset($_POST["best_seller"]) == "1") {
			$best_seller = stripslashes(htmlspecialchars($_POST["best_seller"]));
		} else {
			$best_seller = "0";
		}

		$packing = explode(", ", stripcslashes(htmlspecialchars($_POST["packaging"])));
		$packaging[] = $packing[0];
		$packaging[] = intval($packing[1]);

		$minimum_order = explode(", ", stripslashes(htmlspecialchars($_POST["minimum_order"])));
		foreach ($minimum_order as $value) $min_order[] = intval($value);
		$minimum_order = $min_order;
		
		$discountCount = explode(", ", stripslashes(htmlspecialchars($_POST["discount"])));
		foreach ($discountCount as $value) {
			if (strpos($value, '.') !== false) {
				$disc[] = floatval($value);
			} else {
				$disc[] = intval($value);
			}
		}
		$discountCount = $disc;

		$discount = [$minimum_order, $discountCount];

		$packaging = json_encode($packaging, true);
		$discount = json_encode($discount, true);

		$name        = stripslashes(htmlspecialchars($_POST["name"]));
		$short_desc  = stripslashes(htmlspecialchars($_POST["short_desc"]));
		$long_desc   = stripslashes(htmlspecialchars($_POST["long_desc"]));
		$review      = stripslashes(htmlspecialchars($_POST["review"]));
		$size		     = stripslashes(htmlspecialchars($_POST["size"]));
		$weight		     = stripslashes(htmlspecialchars($_POST["weight"]));
		$stock       = stripslashes(htmlspecialchars($_POST["stock"]));
		$price       = stripslashes(htmlspecialchars($_POST["price"]));
		$minimum_order = stripslashes(htmlspecialchars($_POST["minimum_order"]));
		$category    = stripslashes(htmlspecialchars($_POST["category"]));

		$old_img = $_POST["old_img"];

		if ($_FILES["image"]["error"] === 4) {
			$image = $old_img;
		} else {
			$image = img_upload();
		}

		$query = "UPDATE products SET name = '$name', short_desc = '$short_desc', long_desc = '$long_desc', featured = '$featured', best_seller = '$best_seller', review = '$review', packaging = '$packaging', size = '$size', weight = '$weight', stock = '$stock', price = '$price', discount = '$discount', category_id = '$category', picture = '$image' WHERE product_id = $product_id";
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
	<title>Product Details - Living Barn Indonesia</title>

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
				<form action="" method="POST" enctype="multipart/form-data" class="col-span-2">
					<section class="space-y-2 5">
						<h1 class="text-green-600 text-2xl font-bold font-mont">Product Details</h1>
						<p class="text-neutral-600">Access and edit comprehensive product details.</p>
					</section>
					<?php foreach ($datas as $data): ?>
					<section class="pt-7 grid grid-cols-2 gap-5">
						<div class="w-full space-y-1 col-span-2">
							<label for="name" class="text-neutral-400">Name: </label>
							<input type="text" name="name" id="name" value="<?= $data["name"] ?>" required autofocus class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="shortDesc" class="text-neutral-400">Short Desc: </label>
							<textarea name="short_desc" rows="5" id="shortDesc" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl"><?= $data["short_desc"] ?></textarea>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="longDesc" class="text-neutral-400">Long Desc: </label>
							<textarea name="long_desc" rows="10" id="longDesc" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl"><?= $data["long_desc"] ?></textarea>
						</div>
						<div class="w-full space-y-1 col-span-2 text-neutral-600">
							<label>Status: </label>
							<div class="flex items-center space-x-2">
								<input type="checkbox" name="featured" id="featured" value="1" <?= ($data["featured"] == "1") ? "checked" : "" ?>>
								<label for="featured">Featured</label>
							</div>
							<div class="flex items-center text-neutral-600 space-x-2">
								<input type="checkbox" name="best_seller" id="bestSeller" value="1" <?= ($data["best_seller"] == "1") ? "checked" : "" ?>>
								<label for="bestSeller">Best Seller</label>
							</div>
						</div>
						<div class="w-full space-y-1 col-span-2">
							<label for="review" class="text-neutral-400">Review: </label>
							<input type="number" name="review" id="review" value="<?= $data["review"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<?php
							$packaging = json_decode($data["packaging"]);
							$discount = json_decode($data["discount"]);
						?>
						<div class="w-full space-y-1 col-span-2">
							<label for="packaging" class="text-neutral-400">Packaging and Quantity per Box: </label>
							<input type="text" name="packaging" id="packaging" value="<?= ($packaging != []) ? $packaging[0] . ", " . $packaging[1] : "" ?>" class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="size" class="text-neutral-400">Size: </label>
							<input type="text" name="size" id="size" value="<?= $data["size"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="weight" class="text-neutral-400">Weight (gram): </label>
							<input type="text" name="weight" id="weight" value="<?= $data["weight"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="price" class="text-neutral-400">Price: </label>
							<input type="text" name="price" id="price" value="<?= $data["price"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="stock" class="text-neutral-400">Stock: </label>
							<input type="number" name="stock" id="stock" value="<?= $data["stock"] ?>" required class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="minimumOrder" class="text-neutral-400">Minimum Order: </label>
							<input type="text" name="minimum_order" id="minimumOrder" value="<?= ($discount != []) ? implode(", ", $discount[0]) : "" ?>" class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-y-1">
							<label for="discount" class="text-neutral-400">Discount: </label>
							<input type="text" name="discount" id="discount" value="<?= ($discount != []) ? implode(", ", $discount[1]) : "" ?>" class="w-full p-4 text-neutral-800 bg-transparent ring-2 ring-neutral-400 ring-inset hover:ring-green-600 focus:ring-0 focus:outline-1 focus:outline-offset-0 focus:outline-green-600 rounded-xl">
						</div>
						<div class="w-full space-x-2 col-span-2">
							<label for="category" class="text-neutral-400">Category:</label>
							<select name="category" id="category" class="text-neutral-600 bg-transparent" required>
							<?php
								$categories = read_data("SELECT * FROM categories");
								foreach ($categories as $category):
									if ($data["category_id"] == $category["category_id"]):
							?>
								<option value="<?= $category["category_id"] ?>" selected><?= $category["name"] ?></option>
								<?php else: ?>
								<option value="<?= $category["category_id"] ?>"><?= $category["name"] ?></option>
								<?php endif ?>
							<?php $value++ ?>
							<?php endforeach ?>
							</select>
						</div>
						<div class="w-full space-x-2 col-span-2">
							<label for="image" class="text-neutral-400">Image:</label>
							<div class="flex items-center space-x-2">
								<img src="../assets/database/img/<?= $data['picture'] ?>" style="height: 30px">
								<input type="hidden" name="old_img" value="<?= $data['picture'] ?>" />
								<input type="file" name="image" id="image" class="text-neutral-600">
							</div>
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