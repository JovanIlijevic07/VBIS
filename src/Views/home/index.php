<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <section class="hero">
        <h1>Welcome to MovieStore</h1>
        <p>Discover and purchase your favorite movies</p>
        
        <div class="search-box">
            <form action="/search" method="GET">
                <input type="text" name="q" placeholder="Search movies..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </section>

    <section class="movies-grid">
        <h2>Featured Movies</h2>
        <div class="grid">
            <?php foreach ($movies as $movie): ?>
                <div class="movie-card">
                    <div class="movie-image">
    <img src="<?= htmlspecialchars($movie['image_url']) ?>" 
         alt="<?= htmlspecialchars($movie['title']) ?>" 
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
    </section>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>