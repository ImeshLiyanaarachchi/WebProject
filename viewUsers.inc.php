<?php
require 'dbh.inc.php';

$sql = "SELECT id, username, email FROM users";
$result = mysqli_query($conn, $sql);

$tableRows = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tableRows .= '<tr>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['id'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['username'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['email'] . '</td>';
        $tableRows .= '<td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-action="includes/deleteUser.inc.php?id=' . $row['id'] . '" data-message="Are you sure you want to delete this user?">Delete</button>
                      </td>';
        $tableRows .= '</tr>';
    }
} else {
    $tableRows = '<tr><td colspan="4" class="text-center">No users found.</td></tr>';
}

mysqli_close($conn);

// Pass the generated HTML to the frontend
echo $tableRows;
?>
