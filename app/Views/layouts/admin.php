<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Shop Convenient</title>
    
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/shop-convenient.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        
        .admin-header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            padding: 15px 0;
            border-radius: 10px;
        }
        
        .admin-header h1 {
            color: #f33f3f;
            font-weight: 700;
            margin: 0;
        }
        
        .admin-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .admin-nav a {
            color: #4a4a4a;
            font-weight: 500;
            padding: 8px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 30px;
            background-color: #f8f9fa;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .admin-nav a:hover {
            color: white;
            background-color: #f33f3f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .admin-content {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .admin-footer {
            text-align: center;
            padding: 25px 0;
            color: #6c757d;
            font-size: 14px;
            margin-top: 20px;
        }
        
        .btn-admin {
            background-color: #f33f3f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-admin:hover {
            background-color: #121212;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .card-admin {
            border: 1px solid #eee;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card-admin:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
        }
        
        .card-admin-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 20px;
            font-weight: 600;
            border-radius: 12px 12px 0 0;
        }
        
        .card-admin-body {
            padding: 25px;
        }
        
        /* Mobile adjustments */
        @media (max-width: 767px) {
            .admin-nav {
                justify-content: center;
            }
            
            .admin-nav a {
                margin: 5px;
                font-size: 14px;
                padding: 6px 15px;
            }
            
            .admin-content {
                padding: 20px;
            }
            
            .card-admin-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <header class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fa fa-cog"></i> Admin Panel</h1>
                </div>
                <div class="col-md-6 text-end admin-nav">
                    <a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <a href="/admin/categories"><i class="fa fa-folder"></i> Categories</a>
                    <a href="/admin/tags"><i class="fa fa-tags"></i> Tags</a>
                    <a href="/admin/products"><i class="fa fa-cube"></i> Products</a>
                    <a href="/admin/products/create"><i class="fa fa-plus"></i> Add Product</a>
                    <a href="/admin/orders"><i class="fa fa-shopping-cart"></i> Orders</a>
                    <a href="/admin/payments"><i class="fa fa-credit-card"></i> Payments</a>
                    <a href="/"><i class="fa fa-home"></i> Back to Site</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="admin-content">
            <?= $viewContent ?>
        </div>
    </div>

    <footer class="admin-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Shop Convenient Admin Panel</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enhanced Admin JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to buttons
            const buttons = document.querySelectorAll('.btn, .btn-admin');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
                });
            });
            
            // Add confirmation for delete actions
            const deleteLinks = document.querySelectorAll('a[href*="delete"]');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Form validation enhancements
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButtons = this.querySelectorAll('button[type="submit"]');
                    submitButtons.forEach(button => {
                        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                        button.disabled = true;
                    });
                });
            });
        });
    </script>
</body>

</html>