<?php
require_once 'includes/db.php';

if (!isset($_GET['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_GET['user_id'];

$query = "SELECT * FROM tasks WHERE user_id = $user_id";
$tasks_result = mysqli_query($conn, $query);
$tasks = mysqli_fetch_all($tasks_result, MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function fonEdit($user_id) {
        global $conn;
        $edit_query = "UPDATE tasks SET onEdit = 0 WHERE user_id = $user_id";
        mysqli_query($conn, $edit_query);
    }

    if (isset($_POST['add_task'])) {
        $newTask = $_POST['new_task'];
        $insert_query = "INSERT INTO tasks (user_id, title) VALUES ($user_id, '$newTask')";
        mysqli_query($conn, $insert_query);
        fonEdit($user_id);
    } 

    elseif (isset($_POST['remove_task'])) {
        $task_id = $_POST['task_id'];
        $delete_query = "DELETE FROM tasks WHERE id = $task_id";
        mysqli_query($conn, $delete_query);
        fonEdit($user_id);
    }

    elseif (isset($_POST['update_task'])) {
        $task_id = $_POST['task_id'];
        $update_title = $_POST['update_title'];
        $update_query = "UPDATE tasks SET title = '$update_title' WHERE id = $task_id";
        mysqli_query($conn, $update_query);
        fonEdit($user_id);
    }

    elseif (isset($_POST['edit_task'])) {
        fonEdit($user_id);
        $task_id = $_POST['task_id'];
        $edit_query = "UPDATE tasks SET onEdit = 1 WHERE id = $task_id";
        mysqli_query($conn, $edit_query);
    }
    

    header("Location: dashboard.php?user_id=$user_id");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Todolist App - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dash.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="top">
            <p class="name">
                <?php
                $query = "SELECT * FROM users WHERE id = $user_id";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);
                echo $user['username'];
                ?> 
            </p>
            <a href="index.php" class="logout"> Logout</a>
        </div>
        <h2>Welcome to your Todo List</h2>

        <div class="task-list">
            <?php foreach ($tasks as $task): ?>
            <form action="dashboard.php?user_id=<?php echo $user_id; ?>" method="POST" class="task-item">
                <?php if ($task['onEdit'] == 0): ?>
                <input type="hidden" name="edit" value="<?php echo $task['onEdit']; ?>">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <input type="text" name="task_name" value="<?php echo $task['title']; ?>" readonly class="no-border">
                <button type="submit" name="edit_task" class="edit-button">Edit</button>
                <button type="submit" name="remove_task" class="remove-button">Remove</button>
                <?php else: ?>
                <input type="hidden" name="edit" value="<?php echo $task['onEdit']; ?>">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <input type="text" name="update_title" value="<?php echo $task['title']; ?>" class="editable">
                <button type="submit" name="update_task" class="update-button">Update</button>
                <button type="submit" name="remove_task" class="remove-button">Remove</button>


                <?php endif; ?>
            </form>
            <?php endforeach; ?>

        </div>
        <form action="dashboard.php?user_id=<?php echo $user_id; ?>" method="POST" class="new-task-form">
            <input type="text" name="new_task" placeholder="Add new task here!" required>
            <button type="submit" name="add_task">Add Task</button>
        </form>
    </div>
</body>

</html>