<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <!-- <li><a href="index.html"><i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
            </li> -->
            <li><a href="index.php">
                <i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
            </li>
            
            <li><a href="viewAllOrders.php">
                <i class="fa fa-shopping-cart"></i><span class="nav-text">Orders</span></a>
            </li>
            <?php if($_SESSION['userType'] == "A"){ ?>
                <li class="nav-label">Reports</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="fa fa-bar-chart"></i><span class="nav-text">Reports</span></a>
                    <ul aria-expanded="false">
                        <li><a href="dateWiseReport.php">Date Wise Report</a></li>
                        
                        <li><a href="staffReport.php">Staff Report</a></li>
                        <li><a href="productReport.php">Top Order Product Report</a></li>

                    </ul>
                </li>
                <li><a href="viewAllTableReservations.php">
                    <i class="fa fa-table"></i><span class="nav-text">Table Reservations</span></a>
                </li>
                <li class="nav-label">Categories</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="icon icon-app-store"></i><span class="nav-text">Categories</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addNewCategory.php">Add New Categories</a></li>
                        
                        <li><a href="viewAllCategories.php">View All Categories</a></li>
                    </ul>
                </li>
                <li class="nav-label">Tables</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="icon icon-app-store"></i><span class="nav-text">Tables</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addNewTable.php">Add New Table</a></li>
                        
                        <li><a href="viewAllTables.php">View All Tables</a></li>
                    </ul>
                </li>

                
                
                <li class="nav-label">Products</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="icon icon-app-store"></i><span class="nav-text">Products</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addNewProduct.php">Add New Product</a></li>
                        
                        <li><a href="viewAllProducts.php">View All Products</a></li>
                    </ul>
                </li>

                <li class="nav-label">Users</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="icon icon-app-store"></i><span class="nav-text">Users</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addNewUser.php">Add New Users</a></li>
                        
                        <li><a href="viewAllUsers.php?userType=S">View All Staff</a></li>
                        <li><a href="viewAllUsers.php?userType=C">View All Customer</a></li>


                    </ul>
                </li>
                
            <?php } ?>
            
        </ul>
    </div>
</div>