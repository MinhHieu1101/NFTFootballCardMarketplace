<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "SwinBalls";
		include_once('includes/header.inc');
	?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>

    <!-- Main Section -->
    <section>
      <!-- Welcome Title and Image Carousel -->
      <h1 class="title title_effect">Welcome to NFT SwinBalls!</h1>
      <div id="carousel">
        <div id="slider-container" class="slider">
          <!-- Image Slides -->
          <div class="slide">
              <img src="assets/images/bryan_mbeumo.jpg" alt="">
          </div>
		  <div class="slide">
			  <img src="assets/images/bukayo_saka.jpg" alt="">
		  </div>
		  <div class="slide">
			<img src="assets/images/jordan_pickford.jpg" alt="">
		  </div>
		  <div class="slide">
			  <img src="assets/images/gabriel_martinelli.jpg" alt="">
		  </div>
		  <div class="slide">
			  <img src="assets/images/jarrod_bowen.jpg" alt="">
		  </div>
		  <div class="slide">
			  <img src="assets/images/joao_palhinha.jpg" alt="">
		  </div>
		  <div class="slide">
			  <img src="assets/images/kaoru_mitoma.jpg" alt="">
		  </div>
          
          <!-- Control Buttons for Carousel -->
          <div onclick="prev()" class="control-prev-btn">
            <i class="fas fa-arrow-left"></i>
          </div>
          <div onclick="next()" class="control-next-btn">
            <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>

      <!-- About Us Section -->
      <div id="about-us">
        <!-- Introduction and Mission -->
		<p>At NFT Football Cards, we're not just a platform; we're a community of football enthusiasts and digital art aficionados. Our passion for the beautiful game and the world of digital collectibles has driven us to create a space where fans can experience the excitement of football in a whole new way.</p>

		<h3 class="title2 title_effect">Our Mission: Redefining Football Collectibles</h3>
		<p>Our mission is to revolutionize the way you collect and cherish football memorabilia. We've embarked on a journey to bring the thrill of the game into the digital realm, where each NFT football card is a unique piece of art, capturing the essence of your favorite players and the excitement of the sport.</p>
		
        <!-- Promises and Authenticity/Value Sections -->
        <div class="promises-container">
            <!-- Promises -->
            <div class="promise">
                <h3 class="title2 title_effect">Our Promise to You</h3>
				<p>Our promise is to provide you with a seamless and immersive experience as you explore and collect our NFT football cards. We are dedicated to offering a platform where the joy of collecting meets the digital age. Your satisfaction and enjoyment are our top priorities.</p>
			</div>

            <!-- Authenticity and Value -->
            <div class="authenticity-value">
                <h3 class="title2 title_effect">Authenticity and Value</h3>
				<p>What sets us apart is our unwavering commitment to authenticity and quality. Each NFT card on our platform is more than just a digital asset; it's a carefully crafted representation of the spirit of the game. We promise to deliver a collection that not only reflects the rich history of the sport but also holds significant value for both avid collectors and passionate fans.</p>
			</div>
        </div>
      </div>
    </section>

	<?php include_once('includes/footer.inc'); ?>

    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/index.js"></script>
</body>
</html>
