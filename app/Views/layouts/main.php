<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>Shop Convenient</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/assets/css/shop-convenient.css">

    <!-- Cart Symbol CSS -->
    <style>
        .navbar-brand h2 {
            font-size: 28px;
            font-weight: 700;
        }

        .navbar {
            padding: 15px 0;
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .navbar.scrolled {
            padding: 10px 0;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            margin: 0 10px;
            padding: 10px 15px;
            border-radius: 30px;
            transition: all 0.3s;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-item.active .nav-link {
            background-color: #f33f3f;
            color: white !important;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-item.active .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 0px;
            background-color: #f33f3f;
        }

        .search-form {
            max-width: 300px;
            margin: 0 15px;
        }

        /* Search Input Styles */
        .search-input-wrapper {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .search-input-wrapper .form-control {
            border: none;
            padding: 10px 15px;
        }

        .search-input-wrapper .form-control:focus {
            box-shadow: none;
            outline: none;
        }

        .search-input-wrapper .btn {
            border: none;
            background-color: #f8f9fa;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .search-input-wrapper .btn:hover {
            background-color: #f33f3f;
            color: white;
        }

        .cart-btn {
            background-color: #f8f9fa;
            border-radius: 30px;
            padding: 8px 20px;
            transition: all 0.3s;
        }

        .cart-btn:hover {
            background-color: #f33f3f;
            color: white;
        }

        .cart-btn i {
            font-size: 18px;
        }

        .cart-badge {
            background-color: #f33f3f;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            line-height: 22px;
            font-size: 12px;
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .main-content {
            padding: 0px 0;
        }

        .footer {
            padding: 25px 0;
        }

        /* Cart Symbol */
        .cartSymbol {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            border-radius: 50%;
            background: #f33f3f;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .cartSymbol:hover {
            transform: scale(1.1);
        }

        .cartSymbol i {
            color: white;
            font-size: 24px;
        }

        .cartSymbol sub {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #121212;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            line-height: 25px;
            font-size: 12px;
        }

        /* Mobile adjustments */
        @media (max-width: 991px) {
            .navbar-nav .nav-link {
                margin: 5px 0;
                border-radius: 0;
            }

            .search-form {
                margin: 15px auto;
                max-width: 100%;
            }

            .cart-btn {
                margin: 10px 0;
                display: inline-block;
            }
        }

        @media (max-width: 767px) {
            .main-content {
                padding: 20px 0;
            }
        }


        .btn-outline-primary {
            border: 1px solid #f33f3f !important;
            color: #f33f3f !important;
        }

        .btn-outline-primary:hover {
            background-color: #f33f3f !important;
            border: 1px solid #f33f3f !important;
            box-shadow: 0 10px 20px rgba(243, 63, 63, 0.2) !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <h2>SHOP <em>CONV</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav me-auto">
                        <li
                            class="nav-item <?= ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index') ? 'active' : '' ?>">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li
                            class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], '/products') !== false) ? 'active' : '' ?>">
                            <a class="nav-link" href="/products">Products</a>
                        </li>
                        <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == '/about') ? 'active' : '' ?>">
                            <a class="nav-link" href="/about">About Us</a>
                        </li>
                        <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == '/contact') ? 'active' : '' ?>">
                            <a class="nav-link" href="/contact">Contact Us</a>
                        </li>
                    </ul>
                    <form class="d-flex search-form" action="/products/search" method="GET">
                        <div class="input-group search-input-wrapper">
                            <input type="text" name="item" class="form-control" placeholder="Search products..." aria-label="Search">
                            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item position-relative">
                            <a class="nav-link cart-btn" href="/cart">
                                <i class="fa fa-shopping-cart"></i> Cart
                                <?php if (isset($cartItemCount) && $cartItemCount > 0): ?>
                                    <span class="cart-badge px-2"><?= $cartItemCount ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content" style="margin-top: 80px;">
        <?= $viewContent ?>
    </main>

    <!-- Cart Symbol -->
    <?php if (isset($cartItemCount) && $cartItemCount > 0): ?>
        <a href="/cart" class="cartSymbol">
            <i class="fa fa-shopping-cart"></i>
            <sub><?= $cartItemCount ?></sub>
        </a>
    <?php else: ?>
        <a href="/cart" class="cartSymbol">
            <i class="fa fa-shopping-cart"></i>
        </a>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-dark text-light footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">Copyright &copy; <?= date('Y') ?> SHOP CONVENIENT Co. Ltd.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/owl.js"></script>
    <script src="/assets/js/slick.js"></script>
    <script src="/assets/js/isotope.js"></script>
    <script src="/assets/js/accordions.js"></script>

    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) {                   //declaring the array outside of the
            if (!cleared[t.id]) {                      // function makes it static and global
                cleared[t.id] = 1;  // you could use true and false, but that's more typing
                t.value = '';         // with more chance of typos
                t.style.color = '#fff';
            }
        }
    </script>
</body>

</html>