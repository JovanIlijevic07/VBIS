// Movie Store JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add loading state to forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.textContent = 'Processing...';
            }
        });
    });

    // Add hover effects to movie cards
    document.querySelectorAll('.movie-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Search functionality enhancement
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }

    // Confirmation dialogs for delete actions
    document.querySelectorAll('form[action*="delete"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Add animation to stat cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInUp 0.6s ease-out';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });

    // Add buy button animation
    document.querySelectorAll('.btn-success').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // ======= Movie Genres Pie Chart =======
    if (document.getElementById('genresChart')) {
        const genresLabels = window.movieGenresLabels || [];
        const genresCounts = window.movieGenresCounts || [];

        new Chart(document.getElementById('genresChart'), {
            type: 'pie',
            data: {
                labels: genresLabels,
                datasets: [{
                    data: genresCounts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: true, text: 'Movie Genres Sold' }
                }
            }
        });
    }

    // ======= Latest Movie Revenue Line Chart =======
    if (document.getElementById('latestMovieChart')) {
        const revenueLabels = window.latestRevenueLabels || [];
        const revenueData = window.latestRevenueData || [];

        new Chart(document.getElementById('latestMovieChart'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: revenueData,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: { display: true, text: 'Latest Movie Revenue' }
                }
            }
        });
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .movie-card {
        transition: all 0.3s ease;
    }
    
    .btn {
        transition: all 0.15s ease;
    }
    
    .alert {
        transition: opacity 0.3s ease;
    }
`;
document.head.appendChild(style);
