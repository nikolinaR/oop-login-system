<?php
if (empty($_GET['selector']) || empty($_GET['validator'])) {
    echo 'Could not validate your request!';
} else {
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap Elegant Sign Up Form with Icons</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container mt-3">
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="signup-form">
                <form method="post" action="classes/ForgotPassword.php">
                    <input type="hidden" name="type" value="reset" />
                    <input type="hidden" name="selector" value="<?php echo $selector ?>" />
                    <input type="hidden" name="validator" value="<?php echo $validator ?>" />
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" placeholder="New password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" class="btn btn-success" name="changpass" value="changpass" placeholder="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>