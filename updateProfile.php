<?php
require_once 'includes/header.php';
require_once 'classes/UsersController.php';
$obj = new UsersController();
$user = $obj->findUser($_SESSION['email']);
$errors = $obj->update($user);
?>

    <div class="container mt-3">
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="signup-form">
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="firstname" placeholder="Firstname"
                                       value="<?php echo $user['firstname'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="lastname" placeholder="Lastname"
                                       required="required" value="<?php echo $user['lastname'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                       required="required" value="<?php echo $user['username'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="address" placeholder="Address"
                                       required="required" value="<?php echo $user['address'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="phone" placeholder="Phone"
                                       required="required" value="<?php echo $user['phone'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address"
                                       required="required" value="<?php echo $user['email'] ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <select class="custom-select" name="country_id">
                                    <?php
                                    foreach ($obj->getCountries() as $row) {
                                        $selected = 'select';
                                        if ($row['id'] === $user['country_id']) {
                                            $selected = 'selected';
//                                            echo '<option>' . $row['name'].'</option>';
                                        }
                                        echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" class="btn btn-warning" name="update" value="update"
                                   placeholder="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php require_once 'includes/footer.php'; ?>