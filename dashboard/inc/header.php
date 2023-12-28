<header class="main-header">
  <a href="../dashboard/index.php" class="logo">
    <span class="logo-lg"><b>NOVA</b>DECI</span>
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <!-- <img src="../dist/img/jo1.jpg" class="user-image" alt="User Image"> -->
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <i class="fa fa-cogs"></i><span class="hidden-xs"><?php echo $row['name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <!-- <img src="../dist/img/jo1.jpg" class="img-circle" alt="User Image"> -->
              <p>
              <strong>© 2022 JV.</strong> All rights reserved
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <a href="../logout.php" class="btn btn-default btn-flat">Log out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
      </ul>
    </div>
  </nav>
</header>
