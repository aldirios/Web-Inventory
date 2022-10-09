<?php
  session_start();
      if(isset($_SESSION['login'])){
        if($_SESSION['role']==1){
            header("location: admin/menu.php");
            exit;
        }else{
            header("location: pegawai/menu.php");
            exit;
        }
    }
?>
<html>
<head>
    <title>Inventory Supermarket</title>
    <link rel = "stylesheet" type = "text/css" href = "style/style.css";
    <link rel="icon" href="image/.png">
    <style>
        .trans {
            background: rgba(0, 106, 193, 0.75);
        }
    </style>
</head>

<body style="background-image: url(image/1.jpg);">
    <div class="boxslide">
    <!--image slider start-->
    <div class="slider">
        <div class= "link-home" >
            <h1 style="color: white;">Our Market</h1>
            <div>
            <a href="login.php">Login</a>
            <a href="regis.php">Registrasi</a>
        </div></div>
      <div class="slides">
        <!--radio buttons start-->
        <input type="radio" name="radio-btn" id="radio1">
        <input type="radio" name="radio-btn" id="radio2">
        <input type="radio" name="radio-btn" id="radio3">
        <input type="radio" name="radio-btn" id="radio4">
        <!--radio buttons end-->
        <!--slide images start-->
        <div class="slide first">
          <img src="image/1.jpg" alt="">
        </div>
        <div class="slide">
          <img src="image/2.jpg" alt="">
        </div>
        <div class="slide">
          <img src="image/3.jpg" alt="">
        </div>
        <div class="slide">
          <img src="image/4.jpg" alt="">
        </div>
        <!--slide images end-->
        <!--automatic navigation start-->
        <div class="navigation-auto">
          <div class="auto-btn1"></div>
          <div class="auto-btn2"></div>
          <div class="auto-btn3"></div>
          <div class="auto-btn4"></div>
        </div>
        <!--automatic navigation end-->
      </div>
      <!--manual navigation start-->
      <div class="navigation-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label>
      </div>
      <!--manual navigation end-->
    </div>
    <!--image slider end-->
    </div>


    <script type="text/javascript">
    var counter = 1;
    setInterval(function(){
      document.getElementById('radio' + counter).checked = true;
      counter++;
      if(counter > 4){
        counter = 1;
      }
    }, 5000);
    </script>

</body>

</html>
