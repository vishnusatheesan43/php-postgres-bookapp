<?php
require_once __DIR__ . '/db.php';
function listBooks() {
    $db = getDb();
    $stmt = $db->query("SELECT * FROM books ORDER BY title ASC");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include 'views/header.php';
    displayMessage();
    include 'views/list.php';
    include 'views/footer.php';
}

function handleAddOrEdit($id = null) {
    $db = getDb();
    $book = null;

    if ($id) {
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$book) {
            $_SESSION['message'] = "Book not found.";
            $_SESSION['message_type'] = 'error';
            header("Location: index.php");
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CSRF check
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            $_SESSION['message'] = "Invalid request.";
            $_SESSION['message_type'] = 'error';
            header("Location: index.php?action=" . ($id ? "edit&id=$id" : "add"));
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $year = (int)($_POST['year'] ?? 0);

        // Basic validation
        if (empty($title) || empty($author) || $year < 1000 || $year > date('Y')) {
            $_SESSION['message'] = "Invalid input. Title and author required; year between 1000 and current.";
            $_SESSION['message_type'] = 'error';
            header("Location: index.php?action=" . ($id ? "edit&id=$id" : "add"));
            exit;
        }

        if ($id) {
            $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, year = ? WHERE id = ?");
            $stmt->execute([$title, $author, $year, $id]);
            $_SESSION['message'] = "Book updated successfully.";
        } else {
            $stmt = $db->prepare("INSERT INTO books (title, author, year) VALUES (?, ?, ?)");
            $stmt->execute([$title, $author, $year]);
            $_SESSION['message'] = "Book added successfully.";
        }
        $_SESSION['message_type'] = 'success';
        header("Location: index.php");
        exit;
    }

    // Generate CSRF token
    $_SESSION['csrf'] = bin2hex(random_bytes(32));

    include 'views/header.php';
    displayMessage();
    include 'views/form.php';
    include 'views/footer.php';
}

function handleDelete($id) {
    if (!$id) {
        header("Location: index.php");
        exit;
    }

    $db = getDb();
    $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = "Book deleted successfully.";
    $_SESSION['message_type'] = 'success';
    header("Location: index.php");
    exit;
}
