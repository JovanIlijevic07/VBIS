<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="movie-details">
        <div class="movie-header">
            <div class="movie-poster">
                <img src="/images/<?= $movie['image'] ?>" alt="<?= htmlspecialchars($movie['title']) ?>" onerror="this.src='/images/MoviePoster.jpg'">
            </div>
            <div class="movie-info">
                <h1><?= htmlspecialchars($movie['title']) ?></h1>
                <div class="movie-meta">
                    <span class="genre"><?= htmlspecialchars($movie['genre']) ?></span>
                    <span class="year"><?= $movie['year'] ?></span>
                    <span class="price">$<?= number_format($movie['price'], 2) ?></span>
                </div>
                <p class="description"><?= htmlspecialchars($movie['description']) ?></p>
                
                <?php if ($isLoggedIn): ?>
                    <form method="POST" action="/buy" class="buy-form">
                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                        <button type="submit" class="btn btn-success btn-large">
                            🛒 Buy Movie - $<?= number_format($movie['price'], 2) ?>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="login-prompt">
                        <p>Please <a href="/login">login</a> to purchase this movie.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="back-link">
        <a href="/" class="btn btn-outline">← Back to Movies</a>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>