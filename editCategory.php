<?php
include("php/query.php");
include("components/header.php");

$category = null;

// Category fetch for update
if (isset($_GET['ceId']) && !isset($_GET['deleteId'])) {
    $categoryId = $_GET['ceId'];
    $query = $pdo->prepare("SELECT * FROM categories WHERE category_id = :catId");
    $query->bindParam(':catId', $categoryId, PDO::PARAM_INT);
    $query->execute();
    $category = $query->fetch(PDO::FETCH_ASSOC);
}

// UPDATE CATEGORY
if (isset($_POST['updateCategory'])) {
    $categoryName = $_POST['cName'];
    $categoryId = $_POST['cId']; // hidden field se id aayegi

    $query = $pdo->prepare("UPDATE categories SET categoryname = :cName WHERE category_id = :cId");
    $query->bindParam(':cName', $categoryName);
    $query->bindParam(':cId', $categoryId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Updated successfully'); location.assign('viewCategory.php');</script>";
}

?>

<div class="container mt-5">
    <div class="row p-5 mt-10">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-5 mt-2" style="justify-content: center; align-items: center;">
                    <h4 class="card-title">Update Category</h4>
                    <?php if ($category): ?>
                        <form class="forms-sample" method="post">
                            <!-- ✅ Hidden input for category id -->
                            <input type="hidden" name="cId" value="<?php echo $category['category_id']; ?>">

                            <div class="form-group">
                                <label for="exampleInputUsername1">Category Name</label>
                                <input type="text" value="<?php echo $category['categoryname']; ?>" class="form-control" id="exampleInputUsername1" name="cName" placeholder="categoryname">
                            </div>
                            <button name="updateCategory" class="btn btn-primary mt-3">Update Category</button>
                        </form>
                    <?php else: ?>
                        <p>No category selected for update.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("components/footer.php");
?>
