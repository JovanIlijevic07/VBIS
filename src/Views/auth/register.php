<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h1>Register</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/register">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Register</button>
        </form>

        <div class="auth-links">
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>