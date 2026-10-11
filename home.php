<?php
/*
Template Name:  home
*/
?>

<?php get_header(); ?>


   <section class="hotel" id="hotel">
   <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home_header.jpg" alt="фон" class="hotel__img">
  
<p class="city"><?php the_field('city') ?></p>
<h1>Котейка</h1>
<p class="hotel__inf">Уютная гостиница для котов и кошек</p>
<a href="tel:<?php the_field('tel') ?>"  class="booking__btn hotel__btn">Забронировать <img src="<?php echo get_template_directory_uri(); ?>/assets/images/booking.svg" alt="бронь"></a>
   </section>
   <section class="why-us">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/paw_why_are_we.svg" alt="лапка"  class="paw__why-us">
    <h2>Почему мы?</h2>
<div class="why-us__container">
<?php
global $post;

$myposts = get_posts([
	'numberposts' => 6, /*-1 */
    'category_name' => 'why-us__inf'
]);

if( $myposts ){
	foreach( $myposts as $post ){
		setup_postdata( $post );
		?>
        
  <div class="why-us__inf">

<?php the_post_thumbnail(
    array(91,91 ),
    array(
        
        'class' => "why-us__img",
    )
); ?>
     
    <h3><?php the_title(); ?> </h3>
    <p><?php the_content();  ?>  </p>
  </div>
		<?php
	}
} 
wp_reset_postdata(); 
?>




    </div>
   </section>

<section class="room" id="room">
<h2>Номера</h2>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fish.svg"class="fish" alt="fish">

<div class="room__swiper">
  <div class=" swiper-wrapper room__swiper-wrapper">
   
   


    <?php
global $post;

$myposts = get_posts([
	'numberposts' => -1, 
    'category_name' => 'room__swiper-slide'
]);

if( $myposts ){
	foreach( $myposts as $post ){
		setup_postdata( $post );
		?>
     <div class="swiper-slide  room__swiper-slide">
      <div class="room__photo">
<?php the_post_thumbnail(); ?>
      </div>
      <div class="room__inf">
        <h3><?php the_title(); ?></h3>
        <?php the_content();  ?> 
         <a href="tel:<?php the_field('tel') ?>" class="booking__btn room__btn">Забронировать <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/booking.svg" alt="бронь"></a>
      </div>
    </div>
		<?php
	}
} 
wp_reset_postdata(); 
?>

    
    </div>
  </div>
  <div class="direction_swiper">
  <div class="room__swiper-pagination"></div>

  <div class="swiper-button">
  <div class="swiper__arrow-prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/swiper-button-next.svg" alt="назад"></div>
<div class="swiper__arrow-next"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/swiper-button-prev.svg" alt="назад"></div></div></div>

</div>
</section>


<section class="comment" id="comment">
<h2>Отзывы</h2>
<img src="<?php echo get_template_directory_uri(); ?>/assets/images/paw_reviews.svg"  alt="лапка"  class="paw__why-us">
<div class="comment__swiper">
  <div class=" swiper-wrapper comment__swiper-wrapper">

    <?php
global $post;

$myposts = get_posts([
	'numberposts' => -1, 
    'category_name' => 'comment__swiper-slide'
]);

if( $myposts ){
	foreach( $myposts as $post ){
		setup_postdata( $post );
		?>
 
       <div class="swiper-slide  comment__swiper-slide">
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/comment.svg" alt="">
<div class="comment__swiper-text">
  <div class="comment__swiper-name"><p><?php the_content();  ?> </p></div>
<div class="comment__swiper-inf">
  <p class="comment__swiper-fio"><?php the_title();   ?> </p>
<p class="comment__swiper-data"><?php the_date('j F, Y'); ?> </p></div>

</div>
    </div>
		<?php
	}
} 
wp_reset_postdata(); 
?>




  </div>
  <div class="direction_swiper">
  <div class="comment__swiper-pagination"></div>

  <div class="swiper-button">
  <div class="swiper__arrow-prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/swiper-button-next.svg" alt="назад"></div>
<div class="swiper__arrow-next"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/swiper-button-prev.svg" alt="назад"></div></div></div>

</div>
</section>
<section class="how__find"  id="how__find"> 
<div class="how__find-inf">
  <h2>Как нас найти</h2>
  <div class="how__find-list">
<div class="how__find-utim">
  <h3>Адрес</h3>
  <p><?php the_field('city') ?>,<br>
<?php the_field('street') ?></p>
</div>
<div class="how__find-utim">
  <h3>Режим работы</h3>
  <p><?php the_field('phone') ?></p>
</div>
<div class="how__find-utim">
  <h3>Телефон</h3>
  <p><?php the_field('mode') ?></p>
</div>
<div class="how__find-utim">
  <h3>E-mail</h3>
  <p><?php the_field('e-mail') ?></p>
</div>
<div class="how__find-utim">
  <h3>Социальные сети</h3>
  <div class="how__find-net">
    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook.svg" alt="facebook"></a>
    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/instagram.svg" alt="instagram"></a>
    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/vk.svg" alt="vk"></a>
</div>
  </div>
</div>
</div>
<div class="how__find-map" id="map">

</div>
</section>
 
<?php get_footer(); ?>