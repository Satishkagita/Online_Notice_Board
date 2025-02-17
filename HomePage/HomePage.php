<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

</head>

<body>

    <div class="container">

        <h1>Online Notice Board</h1>
        <div class="login-container">
            <div class="login-card">

                <div class="right-half">

                    <h2>Login Details</h2>
                    <?php if (isset($_GET['error'])) {
                        echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
                    }
                    ?>
                    <form action="checktype.php" method="post">

                        <div class="form-group">
                            <select name="role">

                                <option value="admin">Admin</option>
                                <option value="hod">HOD</option>
                                <option value="faculty">Faculty</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <div class="password-container">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="Password">

                            </div>

                            <i class="fas fa-eye " style="display:none;" id="togglePassword"></i>


                        </div>

                        <button type="submit">Login</button>
                    </form>
                    <a href="forgot_password.php?step1=1">Forgot Password?</a>
                </div>
            </div>


        </div>
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const username = document.getElementById('username');

            password.addEventListener('focus', function (e) {
                togglePassword.style.display = "inline-block";
            })
            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                if (type === 'text') {
                    togglePassword.classList.remove('fa-eye');
                    togglePassword.classList.add('fa-eye-slash');
                } else {
                    togglePassword.classList.remove('fa-eye-slash');
                    togglePassword.classList.add('fa-eye');
                }
            });
        </script>


</body>

</html>