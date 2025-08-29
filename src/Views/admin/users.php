<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="admin-header">
        <h1>User Management</h1>
        <nav class="admin-nav">
            <a href="/admin">Dashboard</a>
            <a href="/admin/users" class="active">Manage Users</a>
        </nav>
    </div>
    
    <?php if (\App\Core\Session::get('success_message')): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars(\App\Core\Session::get('success_message')) ?>
        </div>
        <?php \App\Core\Session::remove('success_message'); ?>
    <?php endif; ?>
    
    <?php if (\App\Core\Session::get('error_message')): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars(\App\Core\Session::get('error_message')) ?>
        </div>
        <?php \App\Core\Session::remove('error_message'); ?>
    <?php endif; ?>
    
    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td class="actions">
                            <a href="/admin/edit-user?id=<?= $user['id'] ?>" class="btn btn-small btn-outline">Edit</a>
                            <form method="POST" action="/admin/delete-user" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn btn-small btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>