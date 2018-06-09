<?php
require_once(__DIR__ . '/has_user_session.php');
require_once(__DIR__ . '/config.php');

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    if (empty($username)) {
        $username_err = 'Please enter username.';
    }

    $password = trim($_POST['password']);
    if (empty($password)) {
        $password_err = 'Please enter your password.';
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT username, password FROM " . TBL_ADMINS . " WHERE username = ? LIMIT 1";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION['username'] = $username;
                            header("location: index.php");
                        } else{
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else {
                    $username_err = 'No account found with that username.';
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php include_once('views/layout/partials/_head.php'); ?>
  <body>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> Admin Area <small>Account Login</small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="col-md-4 col-md-offset-4">
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>

                <form id="login" class="well"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </form>

            </div>

          </div>
        </div>
      </div>
    </section>

    <?php
        include_once('views/layout/partials/_footer.php');
        include_once('views/layout/partials/_scripts.php');
    ?>

  </body>
</html>
