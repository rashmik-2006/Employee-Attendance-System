<?php
$conn = new mysqli("localhost", "root", "", "emp_attendance");

$res = $conn->query("SELECT id, password FROM employees");
while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $pw = $row['password'];

    // Only hash if not already bcrypt (starts with $2y$)
    if (strpos($pw, '$2y$') !== 0) {
        $hashed = password_hash($pw, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE employees SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed, $id);
        $update->execute();
        echo "Updated ID $id\n";
    }
}
?>