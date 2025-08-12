<?php
include("php/query.php");
include("components/header.php");
?>
<div class="container">
  <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card p-5 mt-5">
                  <div class="card-body" style="width:100%;">
                    <h4 class="card-title">View Category</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Action</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                             <?php
                                        $query = $pdo->query("select * from categories");
                                        $allCategories = $query->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($allCategories);
                                        foreach($allCategories as $category){
                                        ?>
                          <tr>
                            <th scope="col"><?php echo $category['category_id']?></th>
                            <td><?php echo $category['categoryname']?></td>
                            <td>
                                <label class="badge badge-warning"> 
                                <a href="editCategory.php?ceId=<?php echo $category['category_id']; ?>" style="color: inherit; text-decoration: none;">Edit</a>
                            </label>
                        </td>
                            <td><label class="badge badge-danger">
                                <a href="?cId=<?php echo $category['category_id']; ?>" style="color: inherit; text-decoration: none;">Delete</a>
                            </label>
                        </td>
                          </tr>
                          <?php
                                        }
                          ?>
                           </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>



<?php
include("components/footer.php");
?>