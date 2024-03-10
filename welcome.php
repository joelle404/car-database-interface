<?php
session_start();

if (isset($_SESSION['username'])){
    header('Location:lab10.html');   
}
    else
        header('Location:login.html');   
    

?>