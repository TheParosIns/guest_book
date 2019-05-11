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

    <link rel="stylesheet" href="../../../assets/main-style.css">

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
        <form class="form-control-guest left" method="POST" novalidate>
            <div class="input-group">
                <label for="address" class="label-guest">Message</label>
                <textarea readonly rows="5" class="input-control-guest" id="message" cols="50" name="message"><?php echo $arguments['message'][0]['message'] ?></textarea>
            </div>
        </form>

        <?php if (!empty($arguments['replies'])) : ?>
            <label for="message" class="label-guest" style="margin-top:27px">Replies By</label>
            <?php foreach ($arguments['replies'] as $reply) : ?>
                <form class="form-control-guest reply-comment" method="POST">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    <div class="input-group">
                        <label for="address" class="label-guest"><?php echo $reply['name']." ".$reply['surname'] ?></label>
                        <textarea readonly rows="5" class="input-control-guest" id="message" cols="50" name="reply"><?php echo $reply['reply'] ?></textarea>
                    </div>
                </form>
                <?php endforeach; ?>
            <?php endif; ?>
        <form class="form-control-guest reply-comment pull-right" method="POST" action="/guestBook/reply/<?php echo $arguments['message'][0]['id'] ?>"
              novalidate style="margin-right:20px;">
            <div class="input-group" style="width: 100%;">
                <i class="fa fa-reply-all" aria-hidden="true"></i> <label for="address" class="label-guest" style="display: inline-block;float: left;width: auto;">Reply:</label>
                <textarea rows="5" class="input-control-guest" id="message" cols="50" name="reply" style="width: 100%;max-width: 100%"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-primary-radius reply-comments">Reply</button>
        </form>
    </div>
</div>

</body>
</html>
