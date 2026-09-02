<h2>All Books</h2>
<?php if (empty($books)): ?>
    <p>No books yet. Add one!</p>
<?php else: ?>
    <table>
        <tr><th>Title</th><th>Author</th><th>Year</th><th>Actions</th></tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['year']) ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $book['id'] ?>">Edit</a> |
                    <a href="index.php?action=delete&id=<?= $book['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
