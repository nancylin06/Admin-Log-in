<?php
ob_start();
session_start();
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
  <title>Log in</title>
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
            <h3 class="text-center"><b>LOG IN</b></h3>
            <form action="index.php" method="POST" autocomplete="off">
              <div class="mb-3">
                <label for="mail">E-mail</label>
                <input class="form-control" type="email" placeholder="Enter your email" id="mail" name="email">
              </div>
              <div class="mb-4">
                <label for="pass">Password</label>
                <input class="form-control" type="password" placeholder="Enter your password" id="pass" name="password">
              </div>
              <div class="d-grid gap-2 mb-3">
                <button class="btn-bd-primary" type="submit" name="login">Log in</button>
              </div>
            </form>
            <?php
            if (isset($_POST['login'])) {
              $get_mail = $_POST['email'];
              $get_pass = $_POST['password'];

              if (!empty($get_mail) && !empty($get_pass)) {
                //fetch the data from mysql to log in
                $select_login = "SELECT * FROM `admin` WHERE `admin_email` = '$get_mail'";
                $select_login_query = mysqli_query($connect, $select_login);

                while ($row = mysqli_fetch_assoc($select_login_query)) {
                  $login_id = $row['admin_id'];
                  $login_name = $row['admin_name'];
                  $login_email = $row['admin_email'];
                  $login_pass = $row['admin_pass'];
                }

                //Throw error if any of the condition is not satisfied
                if (mysqli_num_rows($select_login_query) === 0) {
                  echo '<div class="error my-2">
                  <h6 class="pt-1">Your are not a admin!<br>Click the below link to sign up</h6>
                  </div>';
                } else {
                  if ($get_mail === $login_email && $get_pass === $login_pass) {
                    header('location:../Dashboard/index.php');
                    $_SESSION['admin_name'] = $login_name;
                    $_SESSION['admin_id'] = $login_id;
                  } else {
                    echo '<div class="error my-2">
                    <h6 class="pt-1">Password or email is incorrect</h6>
                    </div>';
                  }
                }
              }
              // error occurs when there is no input value 
              else {
                echo '<div class="error my-2">
                <h6 class="pt-1">Enter your email id and password</h6>
                </div>';
              }
            }
            ?>
            <p class="text-center">Create account <a href="../Sign UP/index.php">sign up</a></p>
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