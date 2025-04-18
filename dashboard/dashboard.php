<?php
include("dashboard.html");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["back"])){
        header("Location:../home/home.php");
        exit;
    }elseif($_POST["register-customer"]){
        header("Location:registerCustomer.php");
        exit;
    }elseif($_POST["delete-customer"]){
        header("Location:deleteCustomer.php");
        exit;
    }
    elseif($_POST["add-new-book"]){
        header("Location:addBook.php");
        exit;
    }elseif($_POST["update-book"]){
        header("Location:updateBook.php");
        exit;
    }elseif($_POST["issue-book"]){
        header("Location:issueBook.php");
        exit;
    }elseif($_POST["return-book"]){
        header("Location:returnBook.php");
        exit;
    }elseif($_POST["show-book"]){
        header("Location:showBook.php");
        exit;
    }


}





?>