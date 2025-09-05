<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <h1 style="margin-bottom: 2rem; color: #2c3e50; text-align:center;">Your Cart</h1>

    <?php if (!empty($items)): ?>
        <div class="order-summary">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background:#f8f9fa;">
                        <th style="padding: 1rem; text-align:left;">Movie</th>
                        <th style="padding: 1rem; text-align:center;">Price</th>
                        
                        <th style="padding: 1rem; text-align:center;">Subtotal</th>
                        <th style="padding: 1rem; text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $price = $item['price'] ?? 0;
                        $quantity = $item['quantity'] ?? 1;
                        $subtotal = $price * $quantity;
                        ?>
                        <tr style="border-bottom:1px solid #ecf0f1;">
                            <td style="padding: 1rem; display:flex; align-items:center; gap:1rem;">
                                <img src="<?= htmlspecialchars($item['image_url'] ?? '/images/placeholder.jpg') ?>"
                                    alt="<?= htmlspecialchars($item['title'] ?? 'Movie') ?>"
                                    style="width:60px; height:90px; object-fit:cover; border-radius:4px;"
                                    onerror="this.src='/images/placeholder.jpg'">
                                <span><?= htmlspecialchars($item['title'] ?? 'Movie') ?></span>
                            </td>
                            <td style="padding: 1rem; text-align:center;">$<?= number_format($price, 2) ?></td>
                           
                            <td style="padding: 1rem; text-align:center;">$<?= number_format($subtotal, 2) ?></td>
                            <td style="padding: 1rem; text-align:center;">
                                <form method="post" action="/cart/remove">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-small">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $subtotal; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top:2rem; text-align:right;">
                <h3>Total: $<?= number_format($total, 2) ?></h3>
                <form method="post" action="/cart/buy" style="margin-top:1rem;">
                    <button type="submit" class="btn btn-success btn-large">Buy Now</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="no-orders">
            <h2>Your cart is empty</h2>
            <p>Add some movies to your cart to start shopping.</p>
            <a href="/" class="btn btn-primary">Browse Movies</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>