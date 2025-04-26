<?php require "connection.php"; 
require "functions.php";

$pageName = getCurrentPageName();


?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> <?php echo getPageTitle(); ?> </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <style>
      /* Style for the dropdown container */
      .dropdown {
        position: relative;
        display: inline-block;
/*         width: 150px; */
      }

      /* Style for the dropdown button */
      .dropdown button {
        background-color: #ffbe33;
        color: white;
        padding: 8px 30px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        width: 100%;
        display: block;
        border-radius:45px;
      }

      /* Style for the dropdown menu */
      .dropdown ul {
        position: absolute;
        z-index: 1;
        list-style-type: none;
        margin: 0;
        padding: 0;
        visibility: hidden; /* hide the dropdown menu by default */
        width: 240px;
        border-radius: 50px;
/*         margin-top: 5px; */
      }

      /* Show the dropdown menu when the parent element is hovered over */
      .dropdown:hover ul {
        visibility: visible;
      }

      /* Style for the dropdown menu items */
      .dropdown ul li:first-child{
        border-top-left-radius: 10px;
        border-top-right-radius: 10px; 
      }

      .dropdown ul li:last-child{
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px; 
      }
      
      .dropdown ul li {
        display: block;
        background-color: #ffbe33;
        color: #333;
        padding: 10px;
        text-decoration: none;
      }

      /* Style for the dropdown menu items on hover */
      .dropdown ul li:hover {
        background-color: #000000;
        
      }

      .dropdown ul li:hover a {
        color: #ffbe33;
        
      }

      .dropdown ul li a {
        color: #fff;
        display: block;
      }
      .cursor-pointer{
        cursor: pointer;
      }
    </style>

</head>

<body <?php if($pageName != "index.php"){ ?> class="sub_page" <?php } ?>>