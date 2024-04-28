<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/user_controller.php';

$userController = new UserController($conn);
$users = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="get_users.css" >
    <title>All Users</title>
</head>
<body>
    <?php require_once __DIR__ . "/../admin_navbar.php"; ?>
    <h1>User List</h1>
    <a href="add_user.php" class="add"><button type="button">Add User</button></a>
    <?php if (empty($users)): ?>
        <p>No users available to display.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                        <?php if (!empty($user['image_url'])): ?>
                            <img src="../uploads-user/<?php echo $user['image_url']; ?>" alt="User Photo" style="width: 100px;">
                        <?php else: ?>
                            No photo available
                        <?php endif; ?>
                        </td>
                        <td>
                            <form action="update_user.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit">Update</button>
                            </form>
                            <form action="delete_user.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>