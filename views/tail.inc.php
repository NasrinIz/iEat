
<br/>
<div role="banner"  class="owl-carousel owl-theme">
    <?php foreach ($this->advertisements as $key => $value) { ?>
        <div class="item">
            <h4><?php echo $value['title'] ?></h4>
            <img src="<?php echo PROJECT_DIR ?>uploads/advertisements/<?php echo $value['id'] ?>/<?php echo $value['img'] ?>" alt="<?php echo $value['id'] ?>" />
        </div>
    <?php } ?>
</div>
<br/>

<script>
    $('.owl-carousel').owlCarousel({
        items: 4,
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
</script>
<!-- Footer -->

<div class="navbar-collapse" id="footer" role="main">
    <div class="container">
        <div class="navbar-text">
            &copy; 2018. <a href="#" class="navbar-link"><h1>iEat</h1></a> by <a href="#"
                                                                        class="navbar-link" target="_blank">Team I</a>
            <p>Acknowledgment: Content and pictures of this website are copy righted by Subway and are for educational
                purpose only.</p>
        </div>
    </div>
</div>
<!-- /footer -->

<script src="<?php echo PROJECT_DIR ?>views/assets/js/custom.js"></script>
</body>
</html>