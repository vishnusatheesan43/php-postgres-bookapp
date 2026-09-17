<div class="detail-card">
    <a class="muted" href="index.php">← Back to catalog</a>

    <div class="detail-layout">
        <div class="detail-cover">
            <?php if (!empty($book['cover_url'])): ?>
                <img
                    src="<?= htmlspecialchars($book['cover_url']) ?>"
                    alt="Cover of <?= htmlspecialchars($book['title']) ?>"
                >
            <?php else: ?>
                <div class="detail-cover-placeholder">📖</div>
            <?php endif; ?>
        </div>

        <div class="detail-content">
            <div class="book-card-meta">
                <span class="category-badge"><?= htmlspecialchars($book['category'] ?: 'General') ?></span>
                <span class="rating large-rating">★ <?= number_format((float)$book['rating'], 1) ?>/5</span>
            </div>

            <h1><?= htmlspecialchars($book['title']) ?></h1>
            <p class="detail-author">by <?= htmlspecialchars($book['author']) ?></p>

            <div class="detail-meta">
                <div>
                    <span>Published</span>
                    <strong><?= htmlspecialchars($book['year']) ?></strong>
                </div>
                <div>
                    <span>Category</span>
                    <strong><?= htmlspecialchars($book['category'] ?: 'General') ?></strong>
                </div>
            </div>

            <div class="detail-description">
                <h3>About this book</h3>
                <p>
                    <?= !empty($book['description'])
                        ? nl2br(htmlspecialchars($book['description']))
                        : 'No description has been added for this book yet.' ?>
                </p>
            </div>

            <div class="form-actions">
                <a class="btn btn-primary" href="index.php?action=edit&id=<?= (int)$book['id'] ?>">Edit Book</a>
                <a class="btn btn-secondary" href="index.php">Back to Books</a>
            </div>
        </div>
    </div>
</div>
