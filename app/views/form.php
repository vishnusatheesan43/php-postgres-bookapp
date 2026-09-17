<div class="form-card form-card-wide">
    <a class="muted" href="index.php">← Back to catalog</a>
    <h2><?= $id ? 'Edit Book' : 'Add New Book' ?></h2>
    <p class="muted">
        <?= $id ? 'Update the details of this book.' : 'Add a new book to your catalog.' ?>
    </p>

    <form method="POST">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

        <div class="form-grid">
            <div class="field">
                <label for="title">Book Title</label>
                <input id="title" type="text" name="title"
                       value="<?= htmlspecialchars($book['title'] ?? '') ?>"
                       placeholder="e.g. Kubernetes Patterns" required>
            </div>

            <div class="field">
                <label for="author">Author</label>
                <input id="author" type="text" name="author"
                       value="<?= htmlspecialchars($book['author'] ?? '') ?>"
                       placeholder="e.g. Bilgin Ibryam" required>
            </div>

            <div class="field">
                <label for="category">Category</label>
                <input id="category" type="text" name="category"
                       value="<?= htmlspecialchars($book['category'] ?? 'General') ?>"
                       placeholder="e.g. Technology" required>
            </div>

            <div class="field">
                <label for="year">Publication Year</label>
                <input id="year" type="number" name="year"
                       value="<?= htmlspecialchars($book['year'] ?? date('Y')) ?>"
                       min="1000" max="<?= date('Y') ?>" required>
            </div>

            <div class="field">
                <label for="rating">Rating <span class="muted">(0–5)</span></label>
                <input id="rating" type="number" name="rating"
                       value="<?= htmlspecialchars($book['rating'] ?? '0') ?>"
                       min="0" max="5" step="0.1" required>
            </div>

            <div class="field">
                <label for="cover_url">Cover Image URL</label>
                <input id="cover_url" type="url" name="cover_url"
                       value="<?= htmlspecialchars($book['cover_url'] ?? '') ?>"
                       placeholder="https://example.com/book-cover.jpg">
            </div>
        </div>

        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="6"
                      placeholder="Write a short description of the book..."><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                <?= $id ? '✓ Update Book' : '＋ Add Book' ?>
            </button>
            <a class="btn btn-secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>
