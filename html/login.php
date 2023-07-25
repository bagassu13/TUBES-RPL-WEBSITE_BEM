<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location:../index.html");
            exit;
        }
    }

    $is_invalid = true;
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/main-style.css"/>
    <link rel="stylesheet" href="css/sign-responsive.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
    <title>Login</title>

    
</head>
<body>

<?php
$is_invalid = false;
if ($is_invalid): ?>
    <em>Invalid login</em>
<?php endif; ?>

<section class="register">
    <div class="container">
        <div class="wrapper d-flex">
            <div class="image-content">
                <img src="assets/images/img-login.png" alt=""/>
            </div>
            <div class="text-content">
                <div class="heading-content sign-in">
                    <h2>Sign In</h2>
                </div>
                <div class="form-content d-flex">
                    <form method="post" action="../index.html">
                        <label for="email">Email</label><br/>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            class="text-input"
                           value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" 
                        /><br/>
                        <label for="create-password">Password</label><br/>
                        <div class="password-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                class="text-input"
                            />
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>

                        <div class="form-wrap d-flex">
                            <div class="form-check d-flex">
                                <input
                                    type="checkbox"
                                    class="form-check--input"
                                    id="checkbox"
                                    name="checkbox"
                                />
                                <label for="checkbox" class="form-check-label">Remember me</label>
                            </div>
                            <br/>
                            <a href="#" 1 em class="forget-password">Forget Password?</a>
                        </div>
                        <!-- <span for="agree" class="span-form d-flex"
                            >I agree to Platforms Terms of service and Privacy Policy</span
                        > -->
                        <button type="submit" id="submit" class="btn btn--form submit">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/script.js"></script>
<script language="php">
    echo "Hello World...,";
</script>
</body>
</html>
