<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Handle Add Service
if (isset($_POST['add_service'])) {
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    $insert = "INSERT INTO Services (service_name, description, price) VALUES ('$name', '$desc', $price)";
    mysqli_query($conn, $insert);
    header("Location: services.php");
    exit;
}

// Handle Delete Service
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM Services WHERE service_id = $id");
    header("Location: services.php");
    exit;
}

// Handle Edit
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Services WHERE service_id = $id"));
}

// Handle Update Service
if (isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    $update = "UPDATE Services SET service_name='$name', description='$desc', price=$price WHERE service_id=$id";
    mysqli_query($conn, $update);
    header("Location: services.php");
    exit;
}

// Fetch all services
$services = mysqli_query($conn, "SELECT * FROM Services ORDER BY service_id DESC");
?>

<?php include '../includes/header.php'; ?>

<h2>Manage Services</h2>

<!-- Service Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="">
            <input type="hidden" name="service_id" value="<?= $edit_mode ? $edit_data['service_id'] : '' ?>">
            <div class="row mb-2">
                <div class="col-md-4">
                    <input type="text" name="service_name" class="form-control" required placeholder="Service Name"
                        value="<?= $edit_mode ? htmlspecialchars($edit_data['service_name']) : '' ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="description" class="form-control" placeholder="Description"
                        value="<?= $edit_mode ? htmlspecialchars($edit_data['description']) : '' ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="price" class="form-control" required placeholder="Price"
                        value="<?= $edit_mode ? htmlspecialchars($edit_data['price']) : '' ?>">
                </div>
                <div class="col-md-2">
                    <?php if ($edit_mode): ?>
                        <button class="btn btn-success w-100" type="submit" name="update_service">Update</button>
                    <?php else: ?>
                        <button class="btn btn-primary w-100" type="submit" name="add_service">Add</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Services Table -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price (Rs.)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($services)) : ?>
            <tr>
                <td><?= $row['service_id'] ?></td>
                <td><?= htmlspecialchars($row['service_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td>
                    <a href="?edit=<?= $row['service_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $row['service_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
