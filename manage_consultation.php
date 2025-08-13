<?php
include("php/query.php");
include("components/header.php");

// Approve / Reject Consultation
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'];
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("UPDATE consultations SET status = :status WHERE consultation_id = :id");
    $stmt->execute([
        ':status' => $status,
        ':id' => $id
    ]);

    echo "<script>alert('Consultation status updated'); location.assign('manage_consultation.php');</script>";
    exit;
}

// Delete Consultation
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM consultations WHERE consultation_id = :id");
    $stmt->execute([':id' => $id]);

    echo "<script>alert('Consultation deleted'); location.assign('manage_consultation.php');</script>";
    exit;
}

// Search Handling
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "
    SELECT 
        c.consultation_id, 
        c.user_id, 
        c.designer_id, 
        c.scheduled_datetime, 
        c.status, 
        c.notes,
        u.username AS user_name, 
        CONCAT(d.firstname, ' ', d.lastname) AS designer_name
    FROM consultations c
    JOIN user u ON c.user_id = u.user_id
    JOIN interioirdesigner d ON c.designer_id = d.Designer_id
    WHERE :search = '' 
       OR c.consultation_id LIKE :search_like
       OR u.username LIKE :search_like
       OR CONCAT(d.firstname, ' ', d.lastname) LIKE :search_like
       OR c.scheduled_datetime LIKE :search_like
       OR c.status LIKE :search_like
       OR c.notes LIKE :search_like
    ORDER BY c.consultation_id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':search' => $search,
    ':search_like' => "%$search%"
]);
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Consultation Requests</h4>
            <form method="get" class="d-flex">
                <input type="text" name="search" 
                       class="form-control form-control-sm me-2" 
                       placeholder="Search by ID, User, Designer, Date, Status..."
                       value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-light btn-sm">Search</button>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>User</th>
                            <th>Designer</th>
                            <th>Scheduled Date/Time</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($consultations)): ?>
                            <?php foreach ($consultations as $con): ?>
                                <tr>
                                    <td class="text-center"><?= $con['consultation_id']; ?></td>
                                    <td><?= htmlspecialchars($con['user_name']); ?></td>
                                    <td><?= htmlspecialchars($con['designer_name']); ?></td>
                                    <td class="text-nowrap"><?= $con['scheduled_datetime']; ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $con['status'] === 'approved' ? 'bg-success' : ($con['status'] === 'rejected' ? 'bg-danger' : 'bg-warning text-dark'); ?>">
                                            <?= ucfirst($con['status']); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($con['notes']); ?></td>
                                    <td class="text-center">
                                        <a href="?status=approved&id=<?= $con['consultation_id']; ?>" class="btn btn-success btn-sm me-1">Approve</a>
                                        <a href="?status=rejected&id=<?= $con['consultation_id']; ?>" class="btn btn-warning btn-sm me-1">Reject</a>
                                        <a href="?delete=<?= $con['consultation_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this consultation?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No consultations found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include("components/footer.php");
?>
