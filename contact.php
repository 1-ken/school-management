<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = "";
$name = "";
$email = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
        $conn->query($sql);
    } elseif (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $sql = "UPDATE contact SET name='$name', email='$email', message='$message' WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM contact WHERE id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST["load"])) {
        $id = $_POST["id"];
        $result = $conn->query("SELECT * FROM contact WHERE id='$id'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["name"];
            $email = $row["email"];
            $message = $row["message"];
        }
    }
}

$result = $conn->query("SELECT * FROM contact");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
        <h1>Contact Us</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
            <textarea name="message" placeholder="Message" required><?php echo $message; ?></textarea>
            <button type="submit" name="add">Add Message</button>
            <button type="submit" name="edit">Edit Message</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["message"]; ?></td>
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
