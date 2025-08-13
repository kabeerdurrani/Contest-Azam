<?php
include("php/query.php");
include("components/header.php");

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM interioirdesigner
        WHERE firstname LIKE :search
           OR lastname LIKE :search
           OR contactnumber LIKE :search
           OR yearofexperience LIKE :search
           OR address LIKE :search
           OR specialization LIKE :search
    ");
    $stmt->execute([':search' => "%$search%"]);
    $allDesigners = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = $pdo->query("SELECT * FROM interioirdesigner");
    $allDesigners = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5 mt-5">
                <div class="card-body">
                    <h4 class="card-title">View Designer</h4>

                    <!-- Search Form -->
                    <form method="get" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by name, contact, address, specialization">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Experience (Years)</th>
                                    <th>Specialization</th>
                                    <th>Portfolio</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($allDesigners as $designer):
                                ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= htmlspecialchars($designer['firstname']) ?></td>
                                        <td><?= htmlspecialchars($designer['lastname']) ?></td>
                                        <td><?= htmlspecialchars($designer['contactnumber']) ?></td>
                                        <td><?= htmlspecialchars($designer['address']) ?></td>
                                        <td><?= htmlspecialchars($designer['yearofexperience']) ?></td>
                                        <td><?= htmlspecialchars($designer['specialization']) ?></td>
                                        <td>
                                            <?php if (!empty($designer['portfolio'])): ?>
                                                <a href="portfolio/<?= htmlspecialchars($designer['portfolio']) ?>" target="_blank">View</a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="editdesigner.php?designer_id=<?= $designer['Designer_id'] ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                        <td>
                                            <a href="?delete_id=<?= $designer['Designer_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this designer?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<?php
include("components/footer.php");
?>
