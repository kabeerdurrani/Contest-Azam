<?php
include("php/query.php");
include("components/header.php");

// Base query
$sql = "SELECT * FROM categories WHERE 1=1";
$params = [];

// Single search
if (!empty($_GET['search'])) {
    $sql .= " AND categoryname LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
}

$query = $pdo->prepare($sql);
$query->execute($params);
$allCategories = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card p-5 mt-5">
        <div class="card-body" style="width:100%;">
          <h4 class="card-title">View Category</h4>

          <!-- Single Search Form -->
          <form method="GET" class="mb-4">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search category..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </form>

          <!-- Categories Table -->
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
                if(count($allCategories) > 0){
                  foreach($allCategories as $category){
                ?>
                <tr>
                  <th scope="col"><?= $category['category_id'] ?></th>
                  <td><?= htmlspecialchars($category['categoryname']) ?></td>
                  <td>
                    <label class="badge badge-warning"> 
                      <a href="editCategory.php?ceId=<?= $category['category_id']; ?>" style="color: inherit; text-decoration: none;">Edit</a>
                    </label>
                  </td>
                  <td>
                    <label class="badge badge-danger">
                      <a href="?cId=<?= $category['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');" style="color: inherit; text-decoration: none;">Delete</a>
                    </label>
                  </td>
                </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='4' class='text-center'>No categories found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

<?php
include("components/footer.php");
?>
