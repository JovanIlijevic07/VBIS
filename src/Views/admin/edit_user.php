<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="admin-header">
        <h1>Edit User</h1>
        <nav class="admin-nav">
            <a href="/admin">Dashboard</a>
            <a href="/admin/users">Manage Users</a>
        </nav>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="edit-form">
        <form method="POST" action="/admin/edit-user?id=<?= $user['id'] ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="/admin/users" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>