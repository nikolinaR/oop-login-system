<?php require_once 'includes/header.php';  ?>


    <div class="jumbotron jumbotron-fluid m-5">
        <div class="container">
            <?php
            echo "<h3> Welcome " . ($_SESSION['username']) . "</h3>";
            ?>
        </div>
    </div>



<?php require_once 'includes/footer.php';
