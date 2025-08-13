<?php
include("php/query.php");
include("components/header.php");

// Base query
$sql = "
    SELECT p.product_id, p.productname, c.categoryname, p.brand, p.price, p.quantity, p.image
    FROM product p
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE 1=1
";

$params = [];

// Single search
if (!empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $sql .= " AND (p.productname LIKE ? OR c.categoryname LIKE ? OR p.brand LIKE ? OR p.price LIKE ?)";
    $params = [$search, $search, $search, $search];
}

$query = $pdo->prepare($sql);
$query->execute($params);
$allProducts = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    < class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5 mt-5">
                <div class="card-body">
                    <h4 class="card-title">View Products</h4>

                    <!-- Single Search Form -->
                    <form method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <button class="btn btn-primary" type="submit">Search</button>
                            
                        </div>
                    </form>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($allProducts) > 0) {
                                    $count = 1;
                                    foreach ($allProducts as $product) {
                                        ?>
                                        <tr>
                                            <td><?= $count++; ?></td>
                                            <td><?= htmlspecialchars($product['productname']); ?></td>
                                            <td><?= htmlspecialchars($product['categoryname']); ?></td>
                                            <td><?= htmlspecialchars($product['brand']); ?></td>
                                            <td><?= number_format($product['price'], 2); ?></td>
                                            <td><?= (int)$product['quantity']; ?></td>
                                            <td>
                                                <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="Product Image" style="width:50px; height:50px; object-fit:cover;">
                                            </td>
                                            <td>
                                                <a href="editproduct.php?product_id=<?= $product['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            </td>
                                            <td>
                                                <label class="badge badge-danger">
                                                    <a href="?product_id=<?= $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" style="color: inherit; text-decoration: none;">Delete</a>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
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
