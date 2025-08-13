<?php
include("php/query.php");
include("components/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5 mt-5">
                <div class="card-body">
                    <h4 class="card-title">View Designer</h4>
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
                                $query = $pdo->query("SELECT * FROM interioirdesigner");
                                $allDesigners = $query->fetchAll(PDO::FETCH_ASSOC);
                                $count = 1;
                                foreach ($allDesigners as $designer) {
                                ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($designer['firstname']); ?></td>
                                        <td><?php echo htmlspecialchars($designer['lastname']); ?></td>
                                        <td><?php echo htmlspecialchars($designer['contactnumber']); ?></td>
                                        <td><?php echo htmlspecialchars($designer['address']); ?></td>
                                        <td><?php echo htmlspecialchars($designer['yearofexperience']); ?></td>
                                        <td><?php echo htmlspecialchars($designer['specialization']); ?></td>
                                        <td>
                                            <?php if (!empty($designer['portfolio'])): ?>
                                                <a href="portfolio/<?php echo htmlspecialchars($designer['portfolio']); ?>" target="_blank">View</a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="editdesigner.php?designer_id=<?php echo $designer['Designer_id']; ?>" class="btn btn-warning ">Edit</a>
                                        </td>
                                        <td>
                                            <a href="?delete_id=<?php echo $designer['Designer_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this designer?')">Delete</a>
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

<?php
include("components/footer.php");
?>
