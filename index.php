<?php include 'core.php' ?>
<!DOCTYPE html>
<html>

<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="toggle-mode">
        <input type="checkbox" id="themeToggle">
        <label for="themeToggle">
            <span id="modeIcon">🌙</span>
        </label>
    </div>
    <main>
        <div class="container">
            <div class="row">
                <div class="table-1">
                    <?php if (isset($_SESSION['message']) && isset($_SESSION['message_type'])): ?>
                        <div class="alert alert-<?= $_SESSION['message_type']; ?>">
                            <?= $_SESSION['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    <?php endif; ?>
                </div>
                <div class="table-2">
                    <div class="card">
                        <div class="card-header">
                            <p>Todo Menu</p>
                        </div>
                        <div class="card-body">
                            <form method="post"
                                action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>"
                                class="todo-form">
                                <input type="hidden" name="add" value="1">
                                <div class="input-box">
                                    <input type="text" class="form-control" name="item" placeholder="Place an Item to Complete"
                                        required>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" class="submit" value="Add Item">
                                        <select name="priority" class="form-select priority-dropdown">
                                        <option value="Low">Low 🔵</option>
                                        <option value="Medium">Medium 🟠</option>
                                        <option value="High">High 🔴</option>
                                    </select>
                                </div>
                            </form>
                            <div class="datas">
                                <?php
                                $query = 'SELECT * FROM todo_table';
                                $res = mysqli_query($conn, $query);
                                if ($res->num_rows > 0) {
                                    $i = 1;
                                    while ($r = $res->fetch_assoc()) {
                                        $name = htmlspecialchars($r['name']);
                                        $done = ($r['status'] == 1) ? 'done' : '';
                                        $badge = '';
                                        switch ($r['priority']) {
                                            case 'High':
                                                $badge = '<span class="badge high">High</span>';
                                                break;
                                            case 'Medium':
                                                $badge = '<span class="badge medium">Medium</span>';
                                                break;
                                            case 'Low':
                                            default:
                                                $badge = '<span class="badge low">Low</span>';
                                        }
                                        echo '
                                                <div class="row mt-2 fade-in">
                                                    <div class="task-name ' . $done . '">
                                                        <h5>' . $i . ')   ' . $name . ' ' . $badge . '</h5>
                                                    </div>
                                                    <div class="task-actions">
                                                        <a href="?action=done&item=' . $r['id'] . '" class="done-icon">✅</a>
                                                        <button class="edit-icon" data-id="' . $r['id'] . '" data-name="' . $r['name'] . '" data-priority="' . $r['priority'] . '">📝</button>
                                                        <a href="?action=delete&item=' . $r['id'] . '" class="delete-icon">🗑️</a>
                                                    </div>
                                                </div>
                                                ';
                                        $i++;
                                    }
                                } else
                                    echo '
                                                <center>
                                                    <img src="\TodoApp\assets\folder.png" width="50px" alt="Your List is Empty"><br><span>Your Empty List</span>
                                                </center>
                                            ';
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="tagline">Built with ❤️ using HTML, CSS, JS,PHP and MySQL</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="editModal" class="modal" style="display:none;">
        <div class="modal-content">
            <form method="post" id="editForm">
                <button type="button" id="closeModalBtn">✖️</button>
                <input type="hidden" name="edit" value="1"> 
                <input type="hidden" name="edit_id" id="edit_id">
                <input type="text" name="edit_name" id="edit_name" required>
                <select name="edit_priority" id="edit_priority">
                    <option value="Low">Low 🔵</option>
                    <option value="Medium">Medium 🟠</option>
                    <option value="High">High 🔴</option>
                </select>
                <input type="submit" value="Update Task" class="btn btn-primary">
            </form>
        </div>
    </div>
    <audio id="addSound" src="assets/addSound.mp3" preload="auto"></audio>
    <audio id="doneSound" src="assets/doneSound.mp3" preload="auto"></audio>
    <audio id="updateSound" src="assets/updateSound.mp3" preload="auto"></audio>
    <audio id="deleteSound" src="assets/deleteSound.mp3" preload="auto"></audio>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
