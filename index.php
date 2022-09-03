<?php
/*
---------------------------
Made by Galstyan with heart
---------------------------
*/

session_start();

require_once('database/connect.php');

if(isset($_GET['cmd'])){
    require_once('app/configuration.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('public/inc/head.php'); ?>
        <title>Quizzes</title>
    </head>
    <body>
        
        <div class="container"></div>
        <div class="actions">
            <button class="previous">Նախորդը</button>
            <button type="submit" class="submit">Հաստատել</button>
            <button type="next" class="next">Հաջորդը</button>
        </div>
        
        <?php include_once('public/inc/scripts.php'); ?>
    </body>
</html>