<?php
use app\core\Application;
use app\core\Constant;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VBISFramework</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png"/>
    <link rel="stylesheet" href="../assets/css/styles.min.css"/>
    <link rel="stylesheet" href="../assets/js/plugins/toastr/toastr.min.css">
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/js/plugins/toastr/toastr.min.js"></script>
    <script src="../assets/js/plugins/toastr/toastr-options.js"></script>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="/home" class="text-nowrap logo-img">
                    <img src="../assets/images/logos/dark-logo.svg" width="180" alt=""/>
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/home" aria-expanded="false">
                            <span>
                            <i class="ti ti-chart-area-line"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/about" aria-expanded="false">
                            <span>
                              <i class="ti ti-info-circle"></i>
                            </span>
                            <span class="hide-menu">About us</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/contact" aria-expanded="false">
                            <span>
                             <i class="ti ti-phone-call"></i>
                            </span>
                            <span class="hide-menu">Contact us</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Users</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/userCreate" aria-expanded="false">
                            <span>
                              <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Create User</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Cars</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/carList" aria-expanded="false">
                            <span>
                              <i class="ti ti-car"></i>
                            </span>
                            <span class="hide-menu">Car list</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <div class="body-wrapper">
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="/cart">
                            <i class="ti ti-shopping-cart"></i>
                           <div id="shopping-cart" class=""></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                     class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="/logout"
                                       class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container-fluid">
            {{ renderSection }}
        </div>
    </div>
</div>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/js/constants/localStorageConstants.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>
<?php
$success = Application::$app->session->getFlash(Constant::$flash_session_success);
if ($success !== false) {
    echo "
        <script>
            $(document).ready(function (){
                toastr.success('$success');
            });
        </script>
    ";
}

$error = Application::$app->session->getFlash(Constant::$flash_session_error);
if ($error !== false) {
    echo "
        <script>
            $(document).ready(function (){
                toastr.error('$error');
            });
        </script>
    ";
}

?>

<script>
    $(document).ready(function (){
        showCartNotification();
    });

    $(document).on('click', '.add-car', function (){
        let id = $(this).data("id");
        let brand = $(this).data("brand");
        let model = $(this).data("model");
        let price = $(this).data("price");
        let image_path = $(this).data("image-path");
        let description = $(this).data("description");

        addToCart(id, brand, model, price, image_path, description);
        $("#quantity-button-" + id).html(checkQuantity(id));
    });

    $(document).on('click', '.remove-car', function (){
        let id = $(this).data("id");

        removeFromCart(id);
        $("#quantity-button-" + id).html(checkQuantity(id));
    });
</script>


</body>

</html>