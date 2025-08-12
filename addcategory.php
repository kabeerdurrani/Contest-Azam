<?php
include("php/query.php");
include("components/header.php");
?>
<div class="row p-5 mt-10">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
                  <div class="card-body p-5 mt-5 " style="justify-content: center; align-items: center;">
                    <h4 class="card-title">Add Category</h4>
                    <form class="forms-sample"  method="post"  >
                            <div class="form-group">
                        <label for="exampleInputUsername1">Category Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="cName" placeholder="categoryname">
                        <small class="text-danger"><?php echo $categoryNameErr?></small>
                      </div>
                    <button name="addcategory" class="btn btn-primary mt-3">Add Category</button>
                            </form>
                        </div>
                    </div>
                    </div>
 <?php
                    include("components/footer.php");
                    ?>