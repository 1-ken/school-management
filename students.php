<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = "";
$name = "";
$age = "";
$grade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $name = $_POST["name"];
        $age = $_POST["age"];
        $grade = $_POST["grade"];
        $sql = "INSERT INTO students (name, age, grade) VALUES ('$name', '$age', '$grade')";
        $conn->query($sql);
    } elseif (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $age = $_POST["age"];
        $grade = $_POST["grade"];
        $sql = "UPDATE students SET name='$name', age='$age', grade='$grade' WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM students WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["load"])) {
        $id = $_POST["id"];
        $result = $conn->query("SELECT * FROM students WHERE id='$id'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["name"];
            $age = $row["age"];
            $grade = $row["grade"];
        }
    }
}

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
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
        <h1>Students</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
            <input type="number" name="age" placeholder="Age" value="<?php echo $age; ?>" required>
            <input type="text" name="grade" placeholder="Grade" value="<?php echo $grade; ?>" required>
            <button type="submit" name="add">Add Student</button>
            <button type="submit" name="edit">Edit Student</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["age"]; ?></td>
                <td><?php echo $row["grade"]; ?></td>
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
