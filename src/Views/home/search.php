<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <section class="search-results">
        <div class="search-header">
            <h1>Search Results</h1>
            <div class="search-box">
                <form action="/search" method="GET">
                    <input type="text" name="q" placeholder="Search movies..."
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <?php if (!empty($movies)): ?>
            <p class="results-count"><?= count($movies) ?> movie(s) found</p>
            <div class="grid">
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-poster">
                <img src="<?= htmlspecialchars($movie['image_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>"
                    onerror="this.src='/images/placeholder.jpg'">
            </div>
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($movie['title']) ?></h3>
                            <p class="genre"><?= htmlspecialchars($movie['genre']) ?> • <?= $movie['year'] ?></p>
                            <p class="description"><?= htmlspecialchars(substr($movie['description'], 0, 100)) ?>...</p>
                            <div class="movie-actions">
                                <span class="price">$<?= number_format($movie['price'], 2) ?></span>
                                <a href="/movie?id=<?= $movie['id'] ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h2>No movies found</h2>
                <p>Try searching with different keywords.</p>
                <a href="/" class="btn btn-primary">Browse All Movies</a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>