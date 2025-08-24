<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStore - Your Digital Cinema</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">🎬 MovieStore</a>
                <div class="nav-links">
                    <a href="/">Home</a>
                    <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                        <a href="/orders">My Orders</a>
                        <?php if (\App\Core\Session::isAdmin()): ?>
                            <a href="/admin">Admin Dashboard</a>
                        <?php endif; ?>
                        <span class="welcome">Welcome, <?= htmlspecialchars($username) ?></span>
                        <a href="/logout" class="btn btn-outline">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary">Login</a>
                        <a href="/register" class="btn btn-outline">Register</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    <main class="main">