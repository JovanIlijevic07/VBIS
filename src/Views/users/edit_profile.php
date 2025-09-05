<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <section class="hero">
        <h1>Edit Profile</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="/edit_profile" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">New Password <small>(leave blank to keep current)</small></label>
                <input type="password" name="password" id="password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/user/profile" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </section>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>