<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Account</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <form class="form-signin" method="POST" action="index.php">
        <h2 class="form-signin-heading">Create Acount</h2>

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" required autofocus>
        <label for="inputSurname" class="sr-only">Surname</label>
        <input type="text" name="surname" id="inputSurname" class="form-control" placeholder="Surname" required autofocus>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">@</span>
            <input type="text" name="email" class="form-control" placeholder="Email" required>
        </div>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" name="form-create_account" type="submit">Register</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.html">Login</a>
    </form>
</div>
</body>
</html>