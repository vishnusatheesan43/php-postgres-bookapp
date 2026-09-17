<?php
require_once __DIR__ . '/db.php';

function listBooks() {
    $db = getDb();

    $search = trim($_GET['search'] ?? '');
    $category = trim($_GET['category'] ?? '');

    $sql = "SELECT * FROM books WHERE 1=1";
    $params = [];

    if ($search !== '') {
        $sql .= " AND (title ILIKE ? OR author ILIKE ? OR description ILIKE ?)";
        $term = '%' . $search . '%';
        $params[] = $term;
        $params[] = $term;
        $params[] = $term;
    }

    if ($category !== '') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }

    $sql .= " ORDER BY title ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $categoryStmt = $db->query("SELECT DISTINCT category FROM books WHERE category IS NOT NULL AND category <> '' ORDER BY category");
    $categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);

    include 'views/header.php';
    displayMessage();
    include 'views/list.php';
    include 'views/footer.php';
}

function viewBook($id) {
    if (!$id) {
        header("Location: index.php");
        exit;
    }

    $db = getDb();
    $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        $_SESSION['message'] = "Book not found.";
        $_SESSION['message_type'] = 'error';
        header("Location: index.php");
        exit;
    }

    $pageTitle = $book['title'];
    include 'views/header.php';
    displayMessage();
    include 'views/detail.php';
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
        if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
            $_SESSION['message'] = "Invalid request.";
            $_SESSION['message_type'] = 'error';
            header("Location: index.php?action=" . ($id ? "edit&id=$id" : "add"));
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $year = (int)($_POST['year'] ?? 0);
        $category = trim($_POST['category'] ?? 'General');
        $description = trim($_POST['description'] ?? '');
        $rating = (float)($_POST['rating'] ?? 0);
        $coverUrl = trim($_POST['cover_url'] ?? '');

        if (
            empty($title) ||
            empty($author) ||
            $year < 1000 ||
            $year > date('Y') ||
            $rating < 0 ||
            $rating > 5 ||
            !preg_match('/^\d+(\.\d)?$/', (string)$_POST['rating']) && $rating != 0
        ) {
            $_SESSION['message'] = "Invalid input. Check title, author, year, and rating (0-5).";
            $_SESSION['message_type'] = 'error';
            header("Location: index.php?action=" . ($id ? "edit&id=$id" : "add"));
            exit;
        }

        if ($id) {
            $stmt = $db->prepare("
                UPDATE books
                SET title = ?, author = ?, year = ?, category = ?, description = ?, rating = ?, cover_url = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $author, $year, $category, $description,
                $rating, $coverUrl !== '' ? $coverUrl : null, $id
            ]);
            $_SESSION['message'] = "Book updated successfully.";
        } else {
            $stmt = $db->prepare("
                INSERT INTO books (title, author, year, category, description, rating, cover_url)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $title, $author, $year, $category, $description,
                $rating, $coverUrl !== '' ? $coverUrl : null
            ]);
            $_SESSION['message'] = "Book added successfully.";
        }

        $_SESSION['message_type'] = 'success';
        header("Location: index.php");
        exit;
    }

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
