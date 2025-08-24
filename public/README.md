# MovieStore - PHP MVC Web Application

A complete PHP-based movie browsing and purchasing platform with MVC architecture.

## Features

### For Non-Users (Visitors)
- Browse movie catalog
- Search movies by title or description
- View movie details

### For Registered Users
- All visitor features
- User registration and login
- Purchase movies
- View order history

### For Admin
- Admin dashboard with statistics
- User management (view, edit, delete users)
- Sales and movie analytics

## Architecture

The application follows MVC (Model-View-Controller) pattern:

- **Models**: Data management (`User.php`, `Movie.php`, `Order.php`)
- **Views**: Presentation layer (HTML templates)
- **Controllers**: Business logic (`HomeController.php`, `AuthController.php`, `MovieController.php`, `AdminController.php`)
- **Core**: Framework utilities (`Router.php`, `Database.php`, `Session.php`)

## Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx) or PHP built-in server

## Installation & Setup

1. **Clone/Download** the project files

2. **Install Dependencies** (if Composer is available):
   ```bash
   composer install
   ```

3. **Start the Application**:
   ```bash
   # Using PHP built-in server
   cd public
   php -S localhost:8000
   ```

4. **Access the Application**:
   - Open your browser and go to `http://localhost:8000`

## Demo Accounts

### Admin Account
- **Username**: `admin`
- **Password**: `admin123`
- **Access**: Full admin dashboard and user management

### User Account
- **Username**: `john_doe`
- **Password**: `password123`
- **Access**: Movie browsing and purchasing

## File Structure

```
moviestore/
├── src/
│   ├── Controllers/
│   │   ├── HomeController.php      # Homepage and search
│   │   ├── AuthController.php      # Login/Register/Logout
│   │   ├── MovieController.php     # Movie details and purchasing
│   │   └── AdminController.php     # Admin dashboard and user management
│   ├── Models/
│   │   ├── User.php               # User data management
│   │   ├── Movie.php              # Movie catalog management
│   │   └── Order.php              # Order processing
│   ├── Views/
│   │   ├── layout/
│   │   │   ├── header.php         # Common header
│   │   │   └── footer.php         # Common footer
│   │   ├── home/
│   │   │   ├── index.php          # Homepage
│   │   │   └── search.php         # Search results
│   │   ├── auth/
│   │   │   ├── login.php          # Login form
│   │   │   └── register.php       # Registration form
│   │   ├── movies/
│   │   │   ├── show.php           # Movie details
│   │   │   └── orders.php         # User orders
│   │   └── admin/
│   │       ├── dashboard.php      # Admin statistics
│   │       ├── users.php          # User management
│   │       └── edit_user.php      # Edit user form
│   └── Core/
│       ├── Router.php             # URL routing
│       ├── Database.php           # Database connection
│       └── Session.php            # Session management
├── public/
│   ├── index.php                  # Application entry point
│   ├── css/
│   │   └── style.css             # Application styles
│   ├── js/
│   │   └── script.js             # JavaScript functionality
│   └── images/                    # Movie poster images
├── composer.json                  # PHP dependencies
└── README.md                     # This file
```

## Key Features Implementation

### 1. MVC Architecture
- Clean separation of concerns
- Organized file structure
- Reusable components

### 2. User Authentication
- Session-based authentication
- Role-based access (user/admin)
- Secure login/logout

### 3. Movie Management
- Movie catalog with details
- Search functionality
- Purchase system

### 4. Admin Dashboard
- User statistics
- Sales analytics
- User management tools

### 5. Responsive Design
- Mobile-friendly interface
- Modern CSS styling
- Interactive JavaScript features

## Database Design (Array-Based Demo)

The application uses array-based storage for demonstration. In production, you would replace with actual database:

### Users Table Structure
```php
[
    'id' => int,
    'username' => string,
    'password' => string,
    'email' => string,
    'role' => 'user|admin',
    'created_at' => datetime
]
```

### Movies Table Structure
```php
[
    'id' => int,
    'title' => string,
    'description' => string,
    'price' => decimal,
    'genre' => string,
    'year' => int,
    'image' => string
]
```

### Orders Table Structure
```php
[
    'id' => int,
    'user_id' => int,
    'movie_id' => int,
    'price' => decimal,
    'created_at' => datetime
]
```

## Usage Guide

### For Visitors
1. Visit the homepage to browse movies
2. Use search to find specific movies
3. Click "View Details" to see movie information
4. Register or login to purchase movies

### For Users
1. Login with user credentials
2. Browse and search movies
3. Click "Buy Movie" to purchase
4. View "My Orders" to see purchase history

### For Admins
1. Login with admin credentials
2. Access admin dashboard for statistics
3. Manage users through "Manage Users"
4. Edit or delete user accounts

## Customization

### Adding New Movies
Edit `src/Models/Movie.php` and add to the `$movies` array.

### Styling Changes
Modify `public/css/style.css` for visual customizations.

### Adding Features
1. Create new controller methods
2. Add corresponding views
3. Update routes in `public/index.php`

## Security Features

- Input sanitization with `htmlspecialchars()`
- Session-based authentication
- Role-based access control
- CSRF protection ready (can be enhanced)

## Production Considerations

1. **Database**: Replace array storage with MySQL/PostgreSQL
2. **Password Hashing**: Use `password_hash()` and `password_verify()`
3. **Environment Variables**: Store sensitive config in `.env` files
4. **Error Handling**: Implement proper error logging
5. **Validation**: Add comprehensive input validation
6. **Security**: Implement CSRF tokens, input filtering

## Troubleshooting

### Common Issues

1. **404 Errors**: Ensure URL rewriting is configured for your web server
2. **Missing Images**: Movie images fall back to placeholder
3. **Session Issues**: Check PHP session configuration

### Web Server Configuration

#### Apache (.htaccess in public/)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## License

This project is open source and available under the MIT License.