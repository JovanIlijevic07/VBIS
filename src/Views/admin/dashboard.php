<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <nav class="admin-nav">
            <a href="/admin" class="active">Dashboard</a>
            <a href="/admin/users">Manage Users</a>
        </nav>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3><?= $userStats['total_users'] ?></h3>
                <p>Total Users</p>
                <small><?= $userStats['new_users_today'] ?> new today</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🎬</div>
            <div class="stat-info">
                <h3><?= $movieStats['total_movies'] ?></h3>
                <p>Total Movies</p>
                <small>$<?= $movieStats['average_price'] ?> avg price</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3><?= $orderStats['total_orders'] ?></h3>
                <p>Total Orders</p>
                <small><?= $orderStats['orders_today'] ?> today</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>$<?= number_format($orderStats['total_revenue'], 2) ?></h3>
                <p>Total Revenue</p>
                <small>$<?= number_format($orderStats['revenue_today'], 2) ?> today</small>
            </div>
        </div>
    </div>
    
    <div class="dashboard-sections">
        <div class="section">
            <h2>Movie Genres</h2>
            <div class="genre-stats">
                <?php foreach ($movieStats['genres'] as $genre => $count): ?>
                    <div class="genre-item">
                        <span class="genre-name"><?= htmlspecialchars($genre) ?></span>
                        <span class="genre-count"><?= $count ?> movies</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="section">
            <h2>Latest Movie</h2>
            <div class="latest-movie">
                <h3><?= htmlspecialchars($movieStats['latest_movie']['title']) ?></h3>
                <p><?= htmlspecialchars($movieStats['latest_movie']['genre']) ?> • <?= $movieStats['latest_movie']['year'] ?></p>
                <p>$<?= number_format($movieStats['latest_movie']['price'], 2) ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>