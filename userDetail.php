<?php
include("php/query.php");
include("components/header.php");
?>
<div class="container mt-5">
    <div class="row p-5 mt-10">
        <div class="col-md-6 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body p-5 mt-2 d-flex flex-column align-items-center">
                    <h4 class="card-title mb-4">Add User Details</h4>

                    <form method="post" class="w-100 user-details-form">
                        
                        
                        <div class="form-group mb-3">
                            <label>First Name:</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Enter First Name" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Last Name:</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Enter Last Name" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Contact Number:</label>
                            <input type="number" name="contactnumber" class="form-control" placeholder="Enter Contact Number" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Address:</label>
                            <textarea name="address" class="form-control" placeholder="Enter Address" rows="3" required></textarea>
                        </div>

                        <button type="submit" name="addUserDetails" class="btn btn-primary w-100">Add Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
include("components/footer.php");
?>