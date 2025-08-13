<?php
include("php/query.php");
include("components/header.php");
?>


<div class="container">
    <div class="row p-5 mt-10">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-5 mt-5">
                    <h4 class="card-title">Add Interior Designer</h4>
                    <form class="forms-sample" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="dfName" class="form-control" placeholder="Enter First Name">
                            <small class="text-danger"><?php echo $dfirstnameErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Last Name</label>
                            <input type="text" name="dlname" class="form-control" placeholder="Enter Last Name">
                            <small class="text-danger"><?php echo $dlastnameErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Contact Number</label>
                            <input type="number" name="dcnumber" class="form-control" placeholder="Enter Contact Number">
                            <small class="text-danger"><?php echo $dcontactnoErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Enter Your Address</label>
                            <input type="text" name="daddress" class="form-control" placeholder="Enter Your Address">
                            <small class="text-danger"><?php echo $daddressErr ?></small>
                        </div>

                       
                        <div class="form-floating mb-3">
                            <label>Year Of Experience</label>
                            <input type="number" name="dexperience" class="form-control" placeholder="Enter Your Experience">
                            <small class="text-danger"><?php echo $dexperienceErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Specialization</label>
                            <input type="text" name="dspecialization" class="form-control" placeholder="Specialization">
                            <small class="text-danger"><?php echo $dspecializationErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Portfollio</label>
                            <input type="text" name="dportfollio" class="form-control" placeholder="Enter Your Portfollio">
                            <small class="text-danger"><?php echo $dportfollioErr ?></small>
                        </div>

                        

                        <button name="addDesigner" class="btn btn-primary mt-3">Add Designer</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("components/footer.php"); ?>
