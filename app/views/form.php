<h2><?= $id ? 'Edit Book' : 'Add Book' ?></h2>
<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" required></label>
    <label>Author: <input type="text" name="author" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required></label>
    <label>Year: <input type="number" name="year" value="<?= htmlspecialchars($book['year'] ?? date('Y')) ?>" min="1000" max="<?= date('Y') ?>" required></label>
    <button type="submit"><?= $id ? 'Update' : 'Add' ?></button>
</form>
