<?php
include("php/query.php");
include("components/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5 mt-5">
                <div class="card-body">
                    <h4 class="card-title">View Products</h4>
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
                                $query = $pdo->query("
                  SELECT p.product_id, p.productname, c.categoryname, p.brand, p.price, p.quantity, p.image
                  FROM product p
                  LEFT JOIN categories c ON p.category_id = c.category_id
                ");
                                $allProducts = $query->fetchAll(PDO::FETCH_ASSOC);
                                $count = 1;
                                foreach ($allProducts as $product) {
                                ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($product['productname']); ?></td>
                                        <td><?php echo htmlspecialchars($product['categoryname']); ?></td>
                                        <td><?php echo htmlspecialchars($product['brand']); ?></td>
                                        <td><?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo (int)$product['quantity']; ?></td>
                                        <td>
                                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="width:50px; height:50px; object-fit:cover;">
                                        </td>
                                        <td>
                                            <a href="editproduct.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                        <td><label class="badge badge-danger">
                                <a href="?product_id=<?php echo $product['product_id']; ?>" style="color: inherit; text-decoration: none;">Delete</a>
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