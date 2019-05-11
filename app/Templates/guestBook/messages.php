<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>Guest Book Template</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

    <!-- Latest compiled and minified CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../../assets/main-style.css">

    <script src="https://code.jquery.com/jquery-3.1.1.js"

            integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body class="msg-container">
<?php include('menu.php') ?>
<div class="container container-content">
<div class="container">
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
    <div class="col-md-12" style="margin:20px;">
        <?php if (!empty($arguments)) { ?>
            <?php
            foreach ($arguments as $message) {
                ?>
                <form class="form-control-guest left">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    <div class="input-group">
                        <label for="message" class="label-guest">Message by <?php echo $message['name'] . ' ' . $message['surname'] ?></label>
                        <textarea rows="5" class="input-control-guest" id="message" cols="50" name="message"><?php echo $message['message']; ?></textarea>
                    </div>
                    <div class="group-btn">
                        <a  class="btn btn-primary btn-primary-radius" href="/guestBook/message/viewMessage/<?php echo $message['id']; ?>">View</a>
                        <a  class="btn btn-primary btn-primary-radius" href="/guestBook/message/edit/<?php echo $message['id']; ?>">Edit</a>
                        <a  class="btn btn-primary btn-primary-radius" href="/guestBook/message/delete/<?php echo $message['id']; ?>">Delete</a>
                    </div>
                </form>
            <?php } ?>
            <?php } else{ ?>
            <div class="input-group no-message-template">
                <label for="address" class="label-guest">  You can be the first to</label>
                <a href="/guestBook/message/create" class="btn btn-primary btn-primary-radius">Leave a message for us!</a>
            </div>
        <?php }?>
    </div>
</div>

</body>
</html>
