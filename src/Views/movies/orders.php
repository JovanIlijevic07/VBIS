<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <h1>My Orders</h1>
    
    <?php if (\App\Core\Session::get('success_message')): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars(\App\Core\Session::get('success_message')) ?>
        </div>
        <?php \App\Core\Session::remove('success_message'); ?>
    <?php endif; ?>
    
    <?php if (!empty($orders)): ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-movie">
                        <img src="<?= htmlspecialchars($order['movie']['image']) ?>" alt="<?= htmlspecialchars($order['movie']['title']) ?>" onerror="this.src='/images/placeholder.jpg'">
                        <div class="order-info">
                            <h3><?= htmlspecialchars($order['movie']['title']) ?></h3>
                            <p class="order-date">Purchased: <?= date('M j, Y', strtotime($order['created_at'])) ?></p>
                            <p class="order-price">$<?= number_format($order['price'], 2) ?></p>
                        </div>
                    </div>
                    <div class="order-actions">
                        <a href="/movie?id=<?= $order['movie_id'] ?>" class="btn btn-outline">View Movie</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="order-summary">
            <h3>Order Summary</h3>
            <p>Total Orders: <?= count($orders) ?></p>
            <p>Total Spent: $<?= number_format(array_sum(array_column($orders, 'price')), 2) ?></p>
        </div>
    <?php else: ?>
        <div class="no-orders">
            <h2>No orders yet</h2>
            <p>You haven't purchased any movies yet.</p>
            <a href="/" class="btn btn-primary">Browse Movies</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>