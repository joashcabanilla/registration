    <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../dist/img/nvdc.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $row['name']; ?></p>
          <!-- Status -->
          <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu</li>

        <li class="">
          <a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>

        <li class="">
          <a href="/ssv/members/index.php"><i class="fa fa-qrcode"></i> <span>List of Members</span></a>
        </li>
        <!--<li class="treeview">-->
        <!--  <a href="#"><i class="fa fa-bar-chart"></i> <span>Reports</span>-->
        <!--    <span class="pull-right-container">-->
        <!--      <i class="fa fa-angle-left pull-right"></i>-->
        <!--    </span>-->
        <!--  </a>-->
        <!--  <ul class="treeview-menu">-->
        <!--    <li><a href="#"><i class="fa fa-street-view"></i>Total Updated Records</a></li>-->
        <!--  </ul>-->
        <!--</li>-->
        <br><br><br><br><br><br><br>
        <li class="">
          <a href="../logout.php"><i class="fa fa-sign-out"></i> <span>Log out</span></a>
        </li>
      </ul>
    </section>
  </aside>
  <div class="control-sidebar-bg"></div>
