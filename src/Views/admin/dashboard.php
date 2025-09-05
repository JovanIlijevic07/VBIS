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
            <canvas id="genresChart"></canvas> 
        </div>

        <div class="section">
            <h2>Latest Movie Revenue</h2>
            <canvas id="latestMovieChart"></canvas> 
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    
    window.movieGenresLabels = <?= json_encode(array_column($soldByGenre, 'genre')) ?>;
    window.movieGenresCounts = <?= json_encode(array_column($soldByGenre, 'total_sold')) ?>;

    
    window.latestRevenueLabels = <?= json_encode(array_keys($orderStats['daily_revenue'] ?? [])) ?>;
    window.latestRevenueData = <?= json_encode(array_values($orderStats['daily_revenue'] ?? [])) ?>;

</script>

<script src="/js/script.js"></script> 

<?php include __DIR__ . '/../layout/footer.php'; ?>