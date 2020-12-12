<header class="header">
    <div class="header-inner">

        
        <div class="header-logo-row">
            <div class="header-logo">
                <img src="<?=URL?>/static/images/logo.svg" alt="Xcomp">
            </div>
            <div class="header-logo-slogan">
                <p><b>Integraded</b> High quality synth engine</p>
            </div>
        </div>

        <div class="header-purchase">
            <a href="<?=URL?>/purchase.php"><i class="fas fa-cart-plus"></i> Purchase</a>
        </div>

    </div>
</header>

<section class="main">
    <div class="main-inner">
        
        <div class="main-content">
            <div class="main-bg" style="background-image: url(static/images/main-bg.jpg)"></div>
            
            <div class="main-content-text">
                <h2>Simple, stable <span>and powerful</span></h2>
                <p>Real-time chords recognition played on a midi keyboard or a midi guitar
                    An Auto-accompaniment is generated in real-time, based on chords played
                    Intelligent FINGERED mode or SINGLE FINGER mode</p>
                <h4>Extended Style Format compatibility</h4>
                
                <button class="main-content-button" id="open-popup">
                    <i class="fas fa-video"></i> Watch Demostration
                </button>

                <div class="main-brands">
                    <div class="brand-box">
                        <div class="brand-image">
                            <img src="<?=URL?>/static/images/brands/yamaha.png" alt="Yamaha">
                        </div>
                        <div class="brand-text">
                            <h3>Support</h3>
                            <p>All models SFF 1: PSR – Tyros 1/2/3 – SFF 2: Tyros 3/4/5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="features">
    <div class="features-inner">

        <div class="features-heading">
            <h1>Software <span>Features</span></h1>
        </div>

        <div class="features-details">
            <div class="features-details-text">
                <h3>Description</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto modi at a officia est labore nostrum laborum similique, aperiam, officiis molestiae eaque? Voluptatum, qui nulla.</p>
    
                <h3>Extensive Features</h3>
                <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit iure magni.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit iure magni.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit iure magni.</li>
                </ul>
            </div>
            <div class="features-details-screenshot">
                <img src="<?=URL?>/static/images/screenshot.png" alt="Screenshot">
            </div>
        </div>

    </div>
</section>

<section class="buy">
    <div class="buy-inner">
        <div class="buy-text">
            <h3>Exclusive!</h3>
            <h2>Price <span>$<?=get_setting('product_cost')?></span></h2>
            <h4>Per license</h4>
            <p>For Windows XP, Vista, 7, 8, 8.1, 10  (32/64 bits)</p>
        </div>
        <div class="buy-checkout">
            <h3><i class="fas fa-lock"></i> Secure Checkout</h3>
            <a href="<?=URL?>/purchase.php" class="red-button"><i class="paypal-logo"></i> Pay now</a>
        </div>
    </div>
</section>

<!-- VIDEO POP UP -->
<div class="popup" id="video-popup">
    <div class="popup-content">
        <div style="overflow:hidden;position: relative;">
            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="400" height="300" type="text/html" src="https://www.youtube.com/embed/3miqd4jqSW8?autoplay=0&fs=1&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0"></iframe>
        </div>
    </div>
</div>
<!-- VIDEO POP UP END -->


<script>

    let popup = document.querySelector("#video-popup");
    let popup_btn = document.querySelector("#open-popup");

    // listens for click event on button and add active class to popup div
    popup_btn.addEventListener('click', (e)=>{
        popup.classList.add('active');
    })

    // listens for click event on popup back-drop and remove active class
    popup.addEventListener('click', (e)=>{
        if (e.target.classList.contains('popup')) {
            popup.classList.remove('active');
        }
    })

</script>
