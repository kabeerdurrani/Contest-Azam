<?php
include("php/query.php");
include("components/header.php");

if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "<script>alert('Invalid product ID'); location.assign('viewproduct.php');</script>";
    exit;
}

$product_id = (int) $_GET['product_id'];

// Fetch existing product
$stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = :product_id");
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<script>alert('Product not found'); location.assign('viewproduct.php');</script>";
    exit;
}

// Update logic
if (isset($_POST['updateProduct'])) {
    $name = $_POST['productname'];
    $category_id = $_POST['category_id'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $imageName);
    } else {
        $imageName = $product['image'];
    }

    $update = $pdo->prepare("
        UPDATE product
        SET productname = :name,
            category_id = :category_id,
            brand = :brand,
            price = :price,
            description = :description,
            quantity = :quantity,
            image = :image
        WHERE product_id = :product_id
    ");
    $update->bindParam(':name', $name);
    $update->bindParam(':category_id', $category_id);
    $update->bindParam(':brand', $brand);
    $update->bindParam(':price', $price);
    $update->bindParam(':description', $description);
    $update->bindParam(':quantity', $quantity);
    $update->bindParam(':image', $imageName);
    $update->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($update->execute()) {
        echo "<script>alert('Product updated successfully'); location.assign('viewproduct.php');</script>";
    } else {
        echo "<script>alert('Failed to update product');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row p-5 mt-10">
        <div class="col-md-6 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body p-5 mt-2 d-flex flex-column align-items-center">
                    <h4 class="card-title mb-4">Update Product</h4>

                    <form method="post" enctype="multipart/form-data" class="w-100">

                        <div class="form-group mb-3">
                            <label>Product Name:</label>
                            <input type="text" name="productname" class="form-control" value="<?php echo htmlspecialchars($product['productname']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Category:</label>
                            <select name="category_id" class="form-control" required>
                                <?php
                                $catQuery = $pdo->query("SELECT category_id, categoryname FROM categories");
                                while ($cat = $catQuery->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($cat['category_id'] == $product['category_id']) ? 'selected' : '';
                                    echo "<option value='{$cat['category_id']}' $selected>{$cat['categoryname']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Brand:</label>
                            <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Price:</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Product Image:</label><br>
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" width="80" height="80" style="object-fit:cover;">
                            <input type="file" name="image" class="form-control mt-2">
                        </div>

                        <button type="submit" name="updateProduct" class="btn btn-primary w-100">Update Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


<?php include("components/footer.php"); ?>