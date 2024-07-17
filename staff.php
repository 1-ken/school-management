<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = "";
$name = "";
$position = "";
$department = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $name = $_POST["name"];
        $position = $_POST["position"];
        $department = $_POST["department"];
        $sql = "INSERT INTO staff (name, position, department) VALUES ('$name', '$position', '$department')";
        $conn->query($sql);
    } elseif (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $position = $_POST["position"];
        $department = $_POST["department"];
        $sql = "UPDATE staff SET name='$name', position='$position', department='$department' WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM staff WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["load"])) {
        $id = $_POST["id"];
        $result = $conn->query("SELECT * FROM staff WHERE id='$id'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["name"];
            $position = $row["position"];
            $department = $row["department"];
        }
    }
}

$result = $conn->query("SELECT * FROM staff");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="students.php">Students</a></li>
            <li><a href="staff.php">Staff Members</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="courses.php">Courses</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Staff Members</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
            <input type="text" name="position" placeholder="Position" value="<?php echo $position; ?>" required>
            <input type="text" name="department" placeholder="Department" value="<?php echo $department; ?>" required>
            <button type="submit" name="add">Add Staff Member</button>
            <button type="submit" name="edit">Edit Staff Member</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["position"]; ?></td>
                <td><?php echo $row["department"]; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="load">Edit</button>
                    </form>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <footer>
        &copy; 2024 School Web App. All rights reserved.
    </footer>
</body>
</html>

<?php
$conn->close();
