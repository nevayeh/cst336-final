<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?php if (!$loggedIn){?>
                <a class="nav-item nav-link" id="logInButton" onclick="createLogInModal()">Log In</a>
                <?php } else {?>
                <a class="nav-item nav-link" id="logOutButton" onclick="logout()">Log Out</a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <?php if ($loggedIn){?>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link" id="navbarUnclickable1">Logged in as <?php echo $_SESSION['user'] ?></span>
            </li>
            <!-- Separator -->
            <li class="nav-item">
                <a class="nav-link" id="navbarUnclickable2">|</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <!-- Separator -->
            <li class="nav-item">
                <a class="nav-link" id="navbarUnclickable3">|</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="">Profile</a>
            </li>
            <!-- Separator -->
            <li class="nav-item">
                <a class="nav-link" id="navbarUnclickable4">|</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="recipes.php">Your Recipes</a>
            </li>
        </ul>
    </div>
    <?php } ?>
</nav>