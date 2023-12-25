<nav>              
        <?php 
        if(isset($_SESSION['user_id'])){
        ?>
        <?php if($_SESSION['role'] == 'administrator'){
        ?>
        <a href='add_new_location.php'>Add a new city</a>
        <?php
        }
        ?>
        <a href='statistics-region.php'>Statistics</a>
        <a href='index.php'>Visited locations</a>
        <a href='add_visited_location.php'>Add a new visited city</a>
        <a href='login.php?logout=1'>Log out</a>
        <?php echo "Currently logged in: {$_SESSION['username']}"; ?>
        <?php
        } else {
        ?>
        <a href='login.php'>Login</a>
        <?php
        }
        ?>        
</nav>