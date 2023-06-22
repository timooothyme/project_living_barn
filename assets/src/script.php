<?php
	session_start();

	$conn = mysqli_connect("localhost", "root", "", "project_living_barn");
	date_default_timezone_set("Asia/Kuala_Lumpur");

	function register() {
		global $conn;
		$created_at       = date("Y-m-d H:i:s");

		$fullname         = stripslashes(htmlspecialchars($_POST["fullname"]));
		$nickname         = stripslashes(htmlspecialchars($_POST["nickname"]));
		$email            = stripslashes(htmlspecialchars(strtolower(($_POST["email"]))));
		$password         = stripslashes(htmlspecialchars($_POST["password"]));
		$password_confirm = stripslashes(htmlspecialchars($_POST["password_confirm"]));

		$query  = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			echo "
				<script>
					alert('Apologies, the account you are trying to register is already registered in our system. Please proceed to log in first.')
				</script>
			";
			return false;
		}

		if ($password !== $password_confirm) {
			echo "
				<script>
					alert('Apologies, the password and password confirmation you entered earlier do not match. Please try again.')
				</script>
			";
			return false;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);

		$query = "INSERT INTO users VALUES ('', '$fullname', '$nickname', '$email', '$password', '', '', '', '', '', '', '', '$created_at', '', '', '', '', '')";
		mysqli_query($conn, $query);

		return true;
	}

	function login() {
		global $conn;
		$last_login_at = date("Y-m-d H:i:s");

		$email    = stripslashes(htmlspecialchars(strtolower(($_POST["email"]))));
		$password = stripslashes(htmlspecialchars($_POST["password"]));

		$query  = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			if (password_verify($password, $row["password"])) {
				$query = "UPDATE users SET last_login_at = '$last_login_at' WHERE email = '$email'";
				mysqli_query($conn, $query);

				$_SESSION["SESSID"] = $row["user_id"];
				if (isset($_POST["remember_me"])) {
					$session_id	= password_hash($row["user_id"], PASSWORD_DEFAULT);
					setcookie("SESSID", $session_id, time() + 60 * 60 * 24 * 100);
				}

				return true;
			} else {
				echo "
					<script>
						alert('Login attempt unsuccessful. Please verify your email and password.')
					</script>
				";

				return false;
			}
		}
	}

	function reset_password() {
		global $conn;

		$email            = stripslashes(htmlspecialchars(strtolower(($_POST["email"]))));
		$password         = stripslashes(htmlspecialchars($_POST["password"]));
		$password_confirm = stripslashes(htmlspecialchars($_POST["password_confirm"]));

		$query  = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			if ($password !== $password_confirm) {
				echo "
					<script>
						alert('Apologies, the password and password confirmation you entered earlier do not match. Please try again.')
					</script>
				";
				return false;
			}

			$password = password_hash($password, PASSWORD_DEFAULT);

			$query = "UPDATE users SET password = '$password' WHERE email = '$email'";
			mysqli_query($conn, $query);

			return true;
		} else {
			echo "
				<script>
					alert('Apologize, the account you entered is not registered in our system. Please verify your email or proceed to register to create a new account.')
				</script>
			";

			return false;
		}
	}

	function read_data($query) {
		global $conn;

		$result = mysqli_query($conn, $query);

		$rows = [];
		while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;

		return $rows;
	}

	function add_to_cart($product_id) {
		$_SESSION["cart"][] = $product_id;
		$cart = serialize($_SESSION["cart"]);

		setcookie("YOUR_CART_DATA", $cart, time() + 60 * 60 * 24 * 100);
	}

	function remove_from_cart($product_id) {
		$index = array_search($product_id, $_SESSION["cart"]);
		if ($index !== false) {
	    unset($_SESSION["cart"][$index]);
      $_SESSION["cart"] = array_values($_SESSION["cart"]);	

      if (empty($_SESSION["cart"])) {
        setcookie("YOUR_CART_DATA", "", time() - 3600);
      } else {
        $cart = serialize($_SESSION["cart"]);
        setcookie("YOUR_CART_DATA", $cart, time() + 60 * 60 * 24 * 100);
      }
		}
	}

	function img_upload() {
		$file_name = $_FILES["image"]["name"];
		$file_size = $_FILES["image"]["size"];
		$file_error = $_FILES["image"]["error"];
		$file_tmp = $_FILES["image"]["tmp_name"];

		$valid_file_type = ["jpg", "jpeg", "png"];
		$file_type = explode(".", $file_name);
		$file_type = strtolower(end($file_type));
		if (!in_array($file_type, $valid_file_type)) return false;
		if ($file_size > 1000000) return false;
		
		$new_file_name = uniqid() . "." . $file_type;
		move_uploaded_file($file_tmp, "../assets/database/img/" . $new_file_name);
		return $new_file_name;
	}
?>