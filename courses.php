<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = "";
$course_name = "";
$description = "";
$credits = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $course_name = $_POST["course_name"];
        $description = $_POST["description"];
        $credits = $_POST["credits"];
        $sql = "INSERT INTO courses (course_name, description, credits) VALUES ('$course_name', '$description', '$credits')";
        $conn->query($sql);
    } elseif (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $course_name = $_POST["course_name"];
        $description = $_POST["description"];
        $credits = $_POST["credits"];
        $sql = "UPDATE courses SET course_name='$course_name', description='$description', credits='$credits' WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM courses WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["load"])) {
        $id = $_POST["id"];
        $result = $conn->query("SELECT * FROM courses WHERE id='$id'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $course_name = $row["course_name"];
            $description = $row["description"];
            $credits = $row["credits"];
        }
    }
}

$result = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
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
        <h1>Courses</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="course_name" placeholder="Course Name" value="<?php echo $course_name; ?>" required>
            <input type="text" name="description" placeholder="Description" value="<?php echo $description; ?>" required>
            <input type="number" name="credits" placeholder="Credits" value="<?php echo $credits; ?>" required>
            <button type="submit" name="add">Add Course</button>
            <button type="submit" name="edit">Edit Course</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Description</th>
                <th>Credits</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["course_name"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo $row["credits"]; ?></td>
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
?>
