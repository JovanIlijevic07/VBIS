<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <section class="hero">
        <h1>My Profile</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <div class="profile-details">
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Role:</strong> <?= $user['is_admin'] ? 'Admin' : 'User'; ?></p>
        </div>

        <div class="form-actions" style="margin-top: 2rem;">
            <a href="/user/edit-profile" class="btn btn-outline">Edit Profile</a>
            <a href="/orders" class="btn btn-primary">My Orders</a>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>