<?php
$connect = mysqli_connect('localhost', 'root', '', 'admin_dash');
if (!$connect) {
  die('server not connected');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/b311425060.js" crossorigin="anonymous"></script>
  <link href="style.css?v=<?php echo time(); ?>" type="text/css" rel="stylesheet">
</head>

<body>
  <div class="container-md d-flex justify-content-center align-items-center">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h3 class="text-center"><b>SIGN UP</b></h3>
            <?php
            $showName = $showMail = $showPass = "";
            if (isset($_POST['signup'])) {
              $name = $_POST['fullname'];
              $mail = $_POST['mail'];
              $pass = $_POST['pass'];

              // validate name by the pattern provided
              if (empty($name)) {
                $showName = "* This field is required";
              } else {
                $name_pattern = "/^[a-zA-Z\\s]+$/";
                $check = preg_match_all($name_pattern, $name);
                if (!$check) {
                  $showName = "* Enter name in charecters";
                }
              }

              //validate mail by filter_var
              if (empty($mail)) {
                $showMail = "* This field is required";
              } else {
                $checkMail = filter_var($mail, FILTER_VALIDATE_EMAIL);
                if (!$checkMail) {
                  $showMail = "* Enter a valid email";
                }

                //same email id should not be repeated
                $same = "SELECT * FROM `admin` WHERE `admin_email` = '$mail'";
                $same_query = mysqli_query($connect, $same);
                while ($row = mysqli_fetch_assoc($same_query)) {
                  $same_mail = $row['admin_email'];
                }
                if (mysqli_num_rows($same_query) === 0) {
                  $showMail = "";
                } else {
                  if ($mail === $same_mail) {
                    $showMail = "* This email address is already taken";
                  }
                }
              }

              //validate pass by the given pattern
              if (empty($pass)) {
                $showPass = "* This field is required";
              } else {
                $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/";
                $checking = preg_match_all($passwordPattern, $pass);
                if (!$checking) {
                  $showPass = "* Password is not strong";
                }
              }

              //sending data to mysql if the input is not empty
              if (empty($showName) && empty($showMail) && empty($showPass)) {
                $insert = "INSERT INTO `admin`(`admin_id`, `admin_name`, `admin_email`, `admin_pass`) VALUES (null,'$name','$mail','$pass')";
                $insert_query = mysqli_query($connect, $insert);

                if (!$insert_query) {
                  echo '<h2>Error occurs in sending data</h2>';
                }
              }
            }
            ?>
            <form action="index.php" method="POST" autocomplete="off">
              <div class="mb-3">
                <label for="name">Name</label>
                <input class="form-control" type="text" placeholder="Enter your name" id="name" name="fullname" minlength="5" maxlength="25">
                <span class="error-message"><?php echo $showName; ?></span>
              </div>
              <div class="mb-3">
                <label for="mail">E-mail</label>
                <input class="form-control" type="email" placeholder="Enter your email" id="mail" name="mail">
                <span class="error-message"><?php echo $showMail; ?></span>
              </div>
              <div class="mb-4">
                <label for="pass">Password</label>
                <input class="form-control" type="password" placeholder="Enter your password" id="pass" name="pass" minlength="8" maxlength="13">
                <span class="error-message"><?php echo $showPass; ?></span>
              </div>
              <div class="d-grid gap-2 mb-3">
                <button class="btn-bd-primary" type="submit" name="signup">Sign up</button>
              </div>
            </form>
            <p class="text-center">Already have an account? <a href="../Log in/index.php">Log in</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>