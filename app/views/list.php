<div class="hero">
    <div>
        <h1>Welcome to <span>Book Catalog</span></h1>
        <p>Discover, manage and explore your favorite books.</p>
        <small>Build your personal library, one book at a time.</small>
        <div style="margin-top:20px;">
            <a class="btn btn-primary" href="index.php?action=add">＋ Add New Book</a>
        </div>
    </div>
    <div class="hero-art">📚</div>
</div>

<div class="stats">
    <div class="stat">
        <div class="stat-label">Total Books</div>
        <div class="stat-value"><?= count($books) ?></div>
    </div>
    <div class="stat">
        <div class="stat-label">Categories</div>
        <div class="stat-value"><?= count($categories) ?></div>
    </div>
    <div class="stat">
        <div class="stat-label">Catalog Status</div>
        <div class="stat-value" style="font-size:20px;">● Active</div>
    </div>
</div>

<form class="searchbar" method="GET" action="index.php">
    <input type="hidden" name="action" value="list">
    <input
        type="text"
        name="search"
        value="<?= htmlspecialchars($search ?? '') ?>"
        placeholder="🔍 Search by title, author or description..."
    >

    <select name="category" aria-label="Filter by category">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= ($category ?? '') === $cat ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-primary" type="submit">Search</button>

    <?php if (!empty($search) || !empty($category)): ?>
        <a class="btn btn-secondary" href="index.php">Clear</a>
    <?php endif; ?>
</form>

<div class="section-title">
    <h2>All Books</h2>
    <span class="muted"><?= count($books) ?> book<?= count($books) === 1 ? '' : 's' ?> found</span>
</div>

<?php if (empty($books)): ?>
    <div class="empty">
        <div class="empty-icon">📚</div>
        <h3>No books found</h3>
        <p><?= (!empty($search) || !empty($category)) ? 'Try a different search or clear the filter.' : 'Your catalog is empty. Add your first book to get started.' ?></p>
        <?php if (empty($search) && empty($category)): ?>
            <a class="btn btn-primary" href="index.php?action=add">＋ Add Your First Book</a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="book-grid">
        <?php foreach ($books as $index => $book): ?>
            <article class="book-card">
                <?php if (!empty($book['cover_url'])): ?>
                    <img
                        class="book-cover-image"
                        src="<?= htmlspecialchars($book['cover_url']) ?>"
                        alt="Cover of <?= htmlspecialchars($book['title']) ?>"
                        loading="lazy"
                    >
                <?php else: ?>
                    <div class="book-cover">
                        <?= ['📕','📘','📗','📙','📔','📒'][$index % 6] ?>
                    </div>
                <?php endif; ?>

                <div class="book-card-meta">
                    <span class="category-badge"><?= htmlspecialchars($book['category'] ?: 'General') ?></span>
                    <span class="rating">★ <?= number_format((float)$book['rating'], 1) ?></span>
                </div>

                <h3><?= htmlspecialchars($book['title']) ?></h3>
                <div class="author">by <?= htmlspecialchars($book['author']) ?></div>

                <?php if (!empty($book['description'])): ?>
                    <p class="book-description">
                        <?= htmlspecialchars(mb_strimwidth($book['description'], 0, 120, '…')) ?>
                    </p>
                <?php endif; ?>

                <div>
                    <span class="year-badge">Published <?= htmlspecialchars($book['year']) ?></span>
                </div>

                <div class="actions">
                    <a class="btn btn-primary btn-small" href="index.php?action=view&id=<?= (int)$book['id'] ?>">View</a>
                    <a class="btn btn-secondary btn-small" href="index.php?action=edit&id=<?= (int)$book['id'] ?>">Edit</a>
                    <a class="btn btn-danger btn-small" href="index.php?action=delete&id=<?= (int)$book['id'] ?>" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
