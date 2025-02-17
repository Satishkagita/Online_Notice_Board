<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="nav-area">
            <div class="profile-area">
                <div class="profile-img">
                <center>
                        <?php
                        if(isset($_SESSION['image']))
                        {
                            $image = $_SESSION['image'];
                        }
                        echo "<img id='img' src='image/$image' alt='profile '>";
                        echo '<h3 style="color: white; padding-bottom: 20px;">Admin</h3> ';
                        ?>
                    </center>
                </div>
            </div>
            <div class="nav-bar">
                <ul>
                    <li>
                        <a class="navbar-link" href="profile.php"><span class="material-symbols-outlined">account_circle</span>Profile</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="view notice.php"><span class="material-symbols-outlined">mark_unread_chat_alt</span>View Notice</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="notice.php"><span class="material-symbols-outlined">edit_note</span>Manage Notice</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="hodmanagement.php"><span class="material-symbols-outlined">group_add</span>Manage HOD</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="facultymanagement.php"><span class="material-symbols-outlined">group_add</span>Manage Faculty</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="student.php"><span class="material-symbols-outlined">badge</span>View Student</a>
                    </li>
                    <li>
                        <a class="navbar-link" href="logout.php"><span class="material-symbols-outlined">logout</span>Logout</a>
                    </li>
                      
              </ul>
            </div>
        </div>
    </nav>
    <div class="content">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <?php
    if (basename($_SERVER['SCRIPT_FILENAME']) === 'admin_index.php') {
    header('Location:view notice.php');
    exit;
}
?>   
</body>
</html>