<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStore - Your Digital Cinema</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<?php
use App\Core\Auth;

$auth = Auth::check();
?>

<header class="header">
    <div class="container">
        <nav class="navbar">
            <a href="/" class="logo">🎬 MovieStore</a>
            <div class="nav-links">
                <a href="/">Home</a>

                <?php if ($auth['isLoggedIn']): ?>
                    <a href="/orders">My Orders</a>
                    <?php if ($auth['isAdmin']): ?>
                        <a href="/admin">Admin Dashboard</a>
                    <?php endif; ?>
                    <span class="welcome">Welcome, <?= htmlspecialchars($auth['username']) ?></span>
                    <a href="/user/profile" class="btn btn-primary">Profile</a>
                    <a href="/logout" class="btn btn-outline">Logout</a>

                    <!-- Cart dugme kada je loginovan -->
                    <a href="/cart" class="btn btn-success" style="margin-left:10px;">🛒 Cart</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary">Login</a>
                    <a href="/register" class="btn btn-outline">Register</a>

                    <!-- Cart dugme kada nije loginovan -->
                    <a href="/login" class="btn btn-success" style="margin-left:10px;" 
                       title="Login to access your cart">🛒 Cart</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
