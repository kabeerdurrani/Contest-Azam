<?php
include("php/query.php");
include("components/header.php");

// Delete Review
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE review_id = :id");
    $stmt->execute([':id' => $id]);
    echo "<script>alert('Review deleted successfully'); location.href='manage_reviews.php';</script>";
    exit;
}

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "
    SELECT r.review_id, r.comment,
           u.username AS user_name,
           p.productname,
           CONCAT(d.firstname, ' ', d.lastname) AS designer_name
    FROM reviews r
    JOIN user u ON r.user_id = u.user_id
    JOIN product p ON r.product_id = p.product_id
    JOIN interioirdesigner d ON r.designer_id = d.Designer_id
    WHERE :search = ''
       OR r.comment LIKE :search_like
       OR u.username LIKE :search_like
       OR p.productname LIKE :search_like
       OR CONCAT(d.firstname, ' ', d.lastname) LIKE :search_like
    ORDER BY r.review_id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':search' => $search,
    ':search_like' => "%$search%"
]);
$allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <di class="row">
        <di class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5">
                <div class="card-body">
                    <h4 class="card-title">Manage Reviews</h4>

                    <!-- Search Form -->
                    <form method="get" class="d-flex mb-3">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control me-2" placeholder="Search reviews...">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Designer</th>
                                    <th>Comment</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allReviews)): ?>
                                    <?php $count = 1; foreach ($allReviews as $rev): ?>
                                        <tr>
                                            <td><?= $count++; ?></td>
                                            <td><?= htmlspecialchars($rev['user_name']); ?></td>
                                            <td><?= htmlspecialchars($rev['productname']); ?></td>
                                            <td><?= htmlspecialchars($rev['designer_name']); ?></td>
                                            <td><?= htmlspecialchars($rev['comment']); ?></td>
                                            <td>
                                                <label class="badge badge-danger">
                                                    <a href="?delete=<?= $rev['review_id']; ?>" 
                                                       style="color: inherit; text-decoration: none;"
                                                       onclick="return confirm('Delete this review?')">
                                                        Delete
                                                    </a>
                                                </label>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No reviews found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


<?php
include("components/footer.php");
?>
