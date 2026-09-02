<?php
session_start(); // For CSRF and messages

require_once 'db.php';
require_once 'books.php';

// Simple routing based on URL
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'add':
        handleAddOrEdit();
        break;
    case 'edit':
        handleAddOrEdit($id);
        break;
    case 'delete':
        handleDelete($id);
        break;
    case 'list':
    default:
        listBooks();
        break;
}

// Function to display messages
function displayMessage() {
    if (isset($_SESSION['message'])) {
        echo '<div style="padding: 10px; margin: 10px 0; border-radius: 5px; ' .
             ($_SESSION['message_type'] === 'success' ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;') .
             '">' . htmlspecialchars($_SESSION['message']) . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}
