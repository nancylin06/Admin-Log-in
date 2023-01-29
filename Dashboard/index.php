<?php
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
    <title>ADMIN DASHBOARD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b311425060.js" crossorigin="anonymous"></script>
    <link href="style.css?v=<?php echo time(); ?>" type="text/css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #023436;">
        <div class="container col-md-11">
            <div class="profile mb-2 mb-md-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <?php
                if (isset($_SESSION['admin_id'])) {
                    $name = $_SESSION['admin_name'];
                    $id = $_SESSION['admin_id'];

                    $select_profile = "SELECT * FROM `admin` WHERE `admin_id` = '$id'";
                    $select_profile_query = mysqli_query($connect, $select_profile);

                    while ($row = mysqli_fetch_assoc($select_profile_query)) {
                        $final_name = $row['admin_name'];
                    }
                }
                ?>
            </div>
            <div class="navbar-nav me-auto ms-3 pt-2 mb-lg-0 text-light">
                <h2>Admin Dashboard</h2>
            </div>
        </div>
    </nav>
    <div class="container col-md-10 mt-3">
        <div class="row navbar">
            <div class="col-md-9 col-7">
                <h3 class="mt-2" style="font-weight:600;">
                    <?php echo '<h5>Hi, Admin</h5>'; ?>
                </h3>
            </div>
            <div class="col-md-2">
                <a href="../Log OUT/index.php">
                    <button class="btn-bd-primary" type="submit">Log out</button>
                </a>
            </div>
        </div>
    </div>
    <div class="container col-md-6 table-responsive mb-5">
        <table class="table table-hover table-bordered">
            <thead>
                <tr style="background-color: #03b5aa;" class="text-center text-light">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Delete</th>
                </tr>
            </thead>
            <?php
            $select = "SELECT * FROM `admin`";
            $select_query = mysqli_query($connect, $select);

            while ($row = mysqli_fetch_assoc($select_query)) {
                $admin_id = $row['admin_id'];
                $admin_name = $row['admin_name'];
                $admin_email = $row['admin_email'];
            ?>
                <tbody>
                    <tr>
                        <th scope="row" class="text-center align-middle"><?php echo $admin_id; ?></th>
                        <td class="align-middle text-center"><?php echo $admin_name; ?></td>
                        <td class="align-middle text-center"><?php echo $admin_email; ?></td>
                        <td class="align-middle text-center">
                            <a href="index.php?delete=<?php echo $admin_id ?>">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
        <?php
        if (isset($_GET['delete'])) {
            $del = $_GET['delete'];
            $delete = "DELETE FROM `admin` WHERE `admin_id` = '$del'";
            $delete_query = mysqli_query($connect, $delete);

            header("location:index.php");
        }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>