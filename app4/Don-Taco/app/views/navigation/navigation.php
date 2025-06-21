<!-- NAV -->

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="javascript:void(0)"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Chat</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= PATH_URL ?>auth/logout">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- SIDENAVIGATION SECTION -->
    <div id="layoutSidenav_nav">
        <div class="page-wrapper chiller-theme toggled">
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="sidebar-content">
                    <div class="sidebar-brand">
                        <a href="<?php echo PATH_URL; ?>">Don Taco</a>
                    </div>
                    <div class="sidebar-header">
                        <div class="user-pic">
                            <img class="img-responsive img-rounded" alt="logo" src="<?php echo PATH_URL; ?>/img/Logo/Logo.png">
                        </div>
                        <div class="user-info">
                            <span class="user-name">
                                <strong>
                                    <?= ucfirst(strtok(htmlspecialchars($_SESSION['user_name'] ?? 'Guest'), ' ')) ?>
                                </strong>
                            </span>
                            <span class="user-role">
                                <?= ucfirst(strtok(htmlspecialchars($_SESSION['user_type'] ?? 'Estándar'), ' ')) ?>
                            </span>
                            <span class="user-status">
                                <i class="fa fa-circle"></i>
                                <span>Online</span>
                            </span>
                        </div>
                    </div>
                    <!-- sidebar-header  -->
                    <div class="sidebar-search">
                        <div>
                            <div class="input-group">
                                <input type="text" class="form-control search-menu" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sidebar-search  -->
                    <div class="sidebar-menu">
                        <ul>
                            <li class="header-menu">
                                <span>General</span>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a class="nav-link" href="product">Producto</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="balance">Balance</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="gastosd">Gastos diarios</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="sidebar-dropdown">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-user-circle"></i>
                                    <span>Cuentas</span>
                                    <span class="badge badge-pill badge-primary">Pendiente</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">Usuarios</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="header-menu">
                                <span>Extra</span>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="fa fa-comments"></i>
                                    <span>Chat</span>
                                    <span class="badge badge-pill badge-primary">Pendiente</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
                <!-- sidebar-content  -->
                <div class="sidebar-footer">
                    <a href="javascript:void(0)">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-pill badge-warning notification">3</span>
                    </a>
                    <a href="javascript:void(0)">
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-pill badge-success notification">7</span>
                    </a>
                    <a href="javascript:void(0)">
                        <i class="fa fa-cog"></i>
                    </a>
                    <a href="<?= PATH_URL ?>auth/logout">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>
            </nav>
        </div>
        <!-- sidebar-wrapper  -->
    </div>