<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.1.1.js"
            integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="login">
    <?php
    if (isset($_SESSION['error'])) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
        <?php
    }
    if (isset($_SESSION['success'])) {
        ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
        <?php
    }
    if (isset($foundErrors) && count($foundErrors) > 0) {
        foreach ($foundErrors as $error) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error['error'] ?>
            </div>
            <?php
        }
    }
    ?>
    <form class="form-signin" method="POST" action="/auth/login/send" novalidate>
        <h2 class="form-signin-heading">Please Login</h2>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">@</span>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" name="form-login" type="submit">Login</button>
        <a class="btn btn-lg btn-primary btn-block" href="/auth/create_account">Create Account</a>
    </form>
</div>
</body>
</html>
