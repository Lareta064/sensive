<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Нет такой страницы!</title>
  <?php wp_head(); ?>
</head>

<body>
  <section class="page-404" 
   style="background: url('<?php echo get_bloginfo('template_url');?>/assets/img/banner/404.jpg') no-repeat center / cover">
   <div class="content-404">
     <h1>Упсссс, что не так!</h1>
     <p>Попробуйте изменить адрес или перейти на</p>
     <a href="index.php"> Главная</a>
   </div>
      

          
  </section>
  <!--================ Hero sm banner end =================-->
  <!--================ Start Footer Area =================-->
  <?php wp_footer(); ?>
</body>

</html>