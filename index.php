<?php  session_start();

require './conn/db.php';

    if(isset($_POST['submitRegistration'])) {

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];


        if(empty($email) || empty($username) || empty($password)) {
            $message = "Please fill all fields";
        }
        elseif(strlen($email) < 6  || strlen($username) < 6 || strlen($password) < 6) {
            $message='Make sure there are at least 6 characters in each field please';
            exit();
        }

        // this makes sure first letter is capital and the rest will all be a-zA-Z to pass the test... this is just a test given....
        elseif(preg_match("/^[A-Z][a-zA-Z]+/", $username)) {
            $message= 'pass';
        }

    // this makes sure there is al least 1 capital letter in the password  string
        elseif(!preg_match("/[A-Z]/", $password)) {
            $message = 'Password error, A minimum of one capitalized letter in password';
        }

                // check if email or username exists in database already..
        $user_check_query = "SELECT * FROM users  WHERE username='$username' OR email='$email' ";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0) {
            $message = 'email or username already exists';
        }else{
            $sql = "INSERT INTO users (email, username, password) Values('$email', '$username', '$password')";
            $result = $conn->query($sql);


            // login making a session once registered.
            $user_check_query = "SELECT * FROM users  WHERE username='$username' OR email='$email' ";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            echo " hello ".$user['username'];

            $_SESSION['uid'] = $user['id'];

        }


    }




    ////Log in
        if(isset($_POST['submitLogin'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users  WHERE username='$username' AND password='$password' ";
            $result = $conn->query($query);  // this gets used in mysqli_num_rows...
            $user = mysqli_fetch_assoc($result);

            if(mysqli_num_rows($result) == 1) {
                $_SESSION['uid'] = $user['id'];


            }

        }





    //// Log OUT

    if(isset($_POST['logoutBtn'])) {

        session_unset();
        session_destroy();
        }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">


</head>
<body>
    





<!-- If logged in...with logout button -->
<?php 
    if(isset($_SESSION['uid'])) {  ?>
    <h2>your logged in </h2>
        <form action='index.php' method='post' >
        <input type='submit' class="btn btn-danger" name='logoutBtn' value='Logout'>
    </form>
    
   <?php } else{  ?>

    <div class='btns'>
        <h3 style='color:white; padding-bottom:15px;'>Welcome! Please register or login </h3>
        <button type="button" class="btn btn-primary registerBtn">Register</button>
        <button type="button" class="btn btn-success loginBtn">Login</button>
   </div>
<div class='container'>
    <form id='registerForm' class='registerForm' action='index.php' method='post'>
    <i class="fas fa-times"></i>
        <h2 >Register</h2>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name='email'   >
        
        <?php if(isset($message)){  ?> 
            <h3><?php echo "<small id='errorMsg' class='form-text text-muted'> $message </small>";  ?></h3>
            <?php } ?>    
    </div>
    <div class="form-group">
        <label for="username">username</label>
        <input type="text" class="form-control" id="username" name='username' placeholder="username" >
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name='password' placeholder="Password" >
    </div>
    
    <button type="submit" class="btn btn-primary" name='submitRegistration'>Submit</button>
</form>


    <!-- LOGIN FORM -->
    <form id='registerForm' class='loginForm' action='index.php' method='post'>
    <i class="fas fa-times"></i>
        <h2 >Login</h2>
    <div class="form-group">
        <label for="username">username</label>
        <input type="text" class="form-control" id="username" name='username'   >
        
        <?php if(isset($message)){  ?> 
            <h3><?php echo "<small id='errorMsg' class='form-text text-muted'> $message </small>";  ?></h3>
            <?php } ?>    
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name='password' placeholder="Password" >
    </div>
    
    <button type="submit" class="btn btn-primary" name='submitLogin'>Submit</button>


    </form>


</div>

<?php } ?>









<script src='main.js'></script>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>

</body>
</html>