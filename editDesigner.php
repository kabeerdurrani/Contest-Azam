<?php
include("php/query.php");
include("components/header.php");

// Validate ID
if (!isset($_GET['designer_id']) || empty($_GET['designer_id'])) {
    echo "<script>alert('Invalid designer ID'); location.assign('ViewDesigner.php');</script>";
    exit;
}

$designer_id = (int) $_GET['designer_id'];

// Fetch existing designer data
$stmt = $pdo->prepare("SELECT * FROM interioirdesigner WHERE designer_id = :designer_id");
$stmt->bindParam(':designer_id', $designer_id, PDO::PARAM_INT);
$stmt->execute();
$designer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$designer) {
    echo "<script>alert('Designer not found'); location.assign('ViewDesigner.php');</script>";
    exit;
}

// Handle update
if (isset($_POST['updateDesigner'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contactnumber = $_POST['contactnumber'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];
    $specialization = $_POST['specialization'];

    // Handle portfolio upload
    if (!empty($_FILES['portfolio']['name'])) {
        $portfolioName = time() . "_" . basename($_FILES['portfolio']['name']);
        move_uploaded_file($_FILES['portfolio']['tmp_name'], "portfolio/" . $portfolioName);
    } else {
        $portfolioName = $designer['portfolio'];
    }

    $update = $pdo->prepare("
        UPDATE interioirdesigner SET
            firstname = :firstname,
            lastname = :lastname,
            contactnumber = :contactnumber,
            address = :address,
            yearofexperience = :experience,
            specialization = :specialization,
            portfolio = :portfolio
        WHERE designer_id = :designer_id
    ");

    $update->bindParam(':firstname', $firstname);
    $update->bindParam(':lastname', $lastname);
    $update->bindParam(':contactnumber', $contactnumber);
    $update->bindParam(':address', $address);
    $update->bindParam(':experience', $experience);
    $update->bindParam(':specialization', $specialization);
    $update->bindParam(':portfolio', $portfolioName);
    $update->bindParam(':designer_id', $designer_id, PDO::PARAM_INT);

    if ($update->execute()) {
        echo "<script>alert('Designer updated successfully'); location.assign('ViewDesigner.php');</script>";
    } else {
        echo "<script>alert('Failed to update designer');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row p-5 mt-10">
        <div class="col-md-8 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body p-5 mt-2 d-flex flex-column align-items-center">
                    <h4 class="card-title mb-4">Update Designer</h4>

                    <form method="post" enctype="multipart/form-data" class="w-100">

                        <div class="form-group mb-3">
                            <label>First Name:</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($designer['firstname']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Last Name:</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($designer['lastname']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Contact Number:</label>
                            <input type="text" name="contactnumber" class="form-control" value="<?php echo htmlspecialchars($designer['contactnumber']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Address:</label>
                            <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($designer['address']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Experience (Years):</label>
                            <input type="number" name="experience" class="form-control" value="<?php echo htmlspecialchars($designer['yearofexperience']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Specialization:</label>
                            <input type="text" name="specialization" class="form-control" value="<?php echo htmlspecialchars($designer['specialization']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Portfolio (PDF or Image):</label><br>
                            <?php if (!empty($designer['portfolio'])): ?>
                                <a href="portfolio/<?php echo htmlspecialchars($designer['portfolio']); ?>" target="_blank">View Existing</a><br>
                            <?php endif; ?>
                            <input type="file" name="portfolio" class="form-control mt-2">
                        </div>

                        <button type="submit" name="updateDesigner" class="btn btn-primary w-100">Update Designer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include("components/footer.php"); ?>
