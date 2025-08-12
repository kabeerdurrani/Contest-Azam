<?php
include("php/query.php");
include("components/header.php");
?>

<div class="container mt-5">
            <div class="row p-5 mt-10">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body p-5 mt-5 " style="justify-content: center; align-items: center;">
                    <h4 class="card-title">Add User</h4>
                    <form class="forms-sample"  method="post"  >
                      <div class="form-group">
                        <label for="exampleInputUsername1">User Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="uName" placeholder="Username">
                        <small class="text-danger"><?php echo $userNameErr?></small>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="uEmail" placeholder="Email">
                         <small class="text-danger"><?php echo $userEmailErr?></small>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="uPassword" placeholder="Password">
                         <small class="text-danger"><?php echo $userPasswordErr?></small>
                      </div>
                       <button name="addUser" class="btn btn-primary mt-3">Add</button>
</form>
</div>
</div>
</div>
</div>
 <?php
    if (isset($_POST['addUser'])) {
        $userName = $_POST['uName'];
        $userEmail = $_POST['uEmail'];
        echo " " .$userName . " " .$userEmail ;
    }
    ?>

<?php
include("components/footer.php");
?>