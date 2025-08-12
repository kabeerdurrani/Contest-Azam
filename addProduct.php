<?php
include("php/query.php");
include("components/header.php");

$productName = $productPrice = $productImageName = $productDes = $productQty = $categoryId = $productBrand = "";
$productNameErr = $productPriceErr = $productImageNameErr = $productDesErr = $productQtyErr = $categoryIdErr = $productBrandErr = "";

if (isset($_POST['addProduct'])) {
    $productName  = $_POST['pName'];
    $productDes   = $_POST['pDes'];
    $productPrice = $_POST['pPrice'];
    $productQty   = $_POST['pQty'];
    $categoryId   = $_POST['category_id']; // updated name
    $productBrand = $_POST['pBrand'];

    $productImageName    = strtolower($_FILES['pImage']['name']);
    $productImageTmpName = $_FILES['pImage']['tmp_name'];
    $extension           = pathinfo($productImageName, PATHINFO_EXTENSION);
    $destination         = "images/" . $productImageName;

    // Validation
    if (empty($productName))  $productNameErr = "Product Name is Required";
    if (empty($productPrice)) $productPriceErr = "Product Price is Required";
    if (empty($productDes))   $productDesErr = "Product Description is Required";
    if (empty($productQty))   $productQtyErr = "Product Quantity is Required";
    if (empty($productBrand)) $productBrandErr = "Product Brand Name is Required";
    if (empty($productImageName)) {
        $productImageNameErr = "Product Image is Required";
    } else {
        $format = ["jpg", "png", "jpeg", "webp", "svg"];
        if (!in_array($extension, $format)) {
            $productImageNameErr = "Invalid Extension";
        }
    }
    if (empty($categoryId)) $categoryIdErr = "Category is Required";

    // If no errors
    if (
        empty($productImageNameErr) &&
        empty($productDesErr) &&
        empty($productPriceErr) &&
        empty($productQtyErr) &&
        empty($productNameErr) &&
        empty($categoryIdErr) &&
        empty($productBrandErr)
    ) {
        if (move_uploaded_file($productImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO product (productname, price, brand, description, quantity, image, category_id) 
                                    VALUES (:productname, :price, :brand, :description, :quantity, :image, :category_id)");
            $query->bindParam(':productname', $productName);
            $query->bindParam(':price', $productPrice);
            $query->bindParam(':brand', $productBrand);
            $query->bindParam(':description', $productDes);
            $query->bindParam(':quantity', $productQty);
            $query->bindParam(':image', $productImageName);
            $query->bindParam(':category_id', $categoryId);
            $query->execute();
            echo "<script>alert('Product added');location.assign('addProduct.php');</script>";
        }
    }
}
?>

<div class="container">
    <div class="row p-5 mt-10">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-5 mt-5">
                    <h4 class="card-title">Add Product</h4>
                    <form class="forms-sample" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="pName" class="form-control" placeholder="Product Name">
                            <small class="text-danger"><?php echo $productNameErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Product Price</label>
                            <input type="text" name="pPrice" class="form-control" placeholder="Product Price">
                            <small class="text-danger"><?php echo $productPriceErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Product Quantity</label>
                            <input type="text" name="pQty" class="form-control" placeholder="Product Quantity">
                            <small class="text-danger"><?php echo $productQtyErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Image</label>
                            <input type="file" name="pImage" class="form-control">
                            <small class="text-danger"><?php echo $productImageNameErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Brand</label>
                            <input type="text" name="pBrand" class="form-control" placeholder="Brand Name">
                            <small class="text-danger"><?php echo $productBrandErr ?></small>
                        </div>

                        <div class="form-floating mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                <option value=""> Select Category</option>
                                <?php
                                $query = $pdo->query("SELECT * FROM categories");
                                $allCategories = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($allCategories as $category) {
                                ?>
                                    <option value="<?php echo $category['category_id'] ?>"><?php echo $category['categoryname'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-danger"><?php echo $categoryIdErr ?></small>
                        </div>

                        <div class="form-floating">
                            <label>Description</label>
                            <textarea name="pDes" class="form-control" style="height: 150px;"></textarea>
                            <small class="text-danger"><?php echo $productDesErr ?></small>
                        </div>

                        <button name="addProduct" class="btn btn-primary mt-3">Add Product</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("components/footer.php"); ?>
