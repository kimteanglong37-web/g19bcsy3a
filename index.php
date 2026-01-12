<?php
    include './incloud/header.inc.php';
    include './incloud/navbar.inc.php';


     $available_pages = ['page' , 'register'];

    if (isset($_GET['page'])){
      $page = $_GET['page'];
      if (in_array($page, $available_pages)) {

          include './pages/' .$page. '.php';

      }else{

      echo '<h1>Error 404</h1>';
      }
      

    }else{
      echo '<h1>Home Page<h1>';
    }
        
     include './incloud/footer.inc.php';
     ?>

     