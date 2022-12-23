 <?php
session_start();
include "Main.php";

if(!isset($_SESSION['isLogin'])){
  header("Location:index.php?admin=no_login");
  }
    $obj = new Main();

?>
 <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                     <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Manage Student</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                
                          <li class="">
                            <a href="manage_student.php">
                                <i class="fas fa-users"></i>Add Student</a>
                        </li>
                          <li class="">
                            <a href="view_student.php">
                                <i class="fas fa-book"></i>view Student</a>
                        </li>
                            </ul>
                        </li> 

                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Manage Student</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                
                          <li class="">
                            <a href="manage_student.php">
                                <i class="fas fa-users"></i>Add Student</a>
                        </li>
                          <li class="">
                            <a href="view_student.php">
                                <i class="fas fa-book"></i>view Student</a>
                        </li>
                            </ul>
                        </li> 
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->