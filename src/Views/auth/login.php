<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h1>Login</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Login</button>
        </form>

        <div class="auth-links">
            <p>Don't have an account? <a href="/register">Register here</a></p>
            <p><strong>Demo Accounts:</strong></p>
            <p>Admin: username "admin", password "admin123"</p>
            <p>User: username "john_doe", password "password123"</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>