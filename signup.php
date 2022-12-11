<?php
require_once 'classes/UsersController.php';
$obj = new UsersController();
$errors = $obj->register();
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

<div class="signup-form">
    <form method="post">
        <h3>Create Account</h3>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="firstname" placeholder="Firstname" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['firstname'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="lastname" placeholder="Lastname" required="required" value="<? echo ?>">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['lastname'] ?? '' ?>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Username" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['username'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                <input type="text" class="form-control" name="address" placeholder="Address" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['address'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control" name="phone" placeholder="Phone" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['phone'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Email Address" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['email'] ?? '' ?>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <select class="custom-select" name="country_id">
                    <option value="">Select Country</option>
                    <?php
                    foreach ($obj->getCountries() as $row) : ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nicename'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['country_id'] ?? '' ?>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['password'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                        <i class="fa fa-check"></i>
                    </span>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
            </div>
            <div class=" text-danger">
                    <span>
                        <?php echo $errors['confirm_password'] ?? '' ?>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <!-- Button -->
            <div class="col-md-offset-3 col-md-9">
                <input type="submit" class="btn btn-info" name="submit" value="submit" placeholder="Sign Up">
            </div>
        </div>
        <div class="text-center">Already have an account? <a href="login.php">Login here</a>.</div>
    </form>

</div>
</body>

</html>