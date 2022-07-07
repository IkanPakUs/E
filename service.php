<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once 'helpers/DB.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria | Our Service</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="service-img">
        <img src="src/img/thumbnail/service.jpg" alt="">
    </div>
    <div class="container">
        <?php include_once('layouts/app-layouts/navbar.php') ?>
        
        <div class="content" id="service">
            <h1>What <br> We give to you</h1>
            <div class="service-content">
                <div class="service__card">
                    <div class="card__title">
                        <i class="bi bi-hammer"></i>
                        Free Installation
                    </div>
                    <div class="card__desc">
                        We're give you installation free service for each item you buy from Euphoria.
                    </div>
                </div>
                <div class="service__card">
                    <div class="card__title">
                        <i class="bi bi-stars"></i>
                        Best Price
                    </div>
                    <div class="card__desc">
                        The best price, for the interior of your dream home.
                    </div>
                </div>
                <div class="service__card">
                    <div class="card__title">
                        <i class="bi bi-pen-fill"></i>
                        Interior Desain Service
                    </div>
                    <div class="card__desc">
                        We can give you option for your interior design.
                    </div>
                </div>
            </div>
        </div>

        <div id="gallery">
            <h1>Our Gallery</h1>
            <div class="image-carousel">
                <div class="carousel__top">
                    <div class="top__track">
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7534270/pexels-photo-7534270.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147291/pexels-photo-7147291.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147285/pexels-photo-7147285.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7031720/pexels-photo-7031720.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147299/pexels-photo-7147299.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005296/pexels-photo-7005296.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7534300/pexels-photo-7534300.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7534270/pexels-photo-7534270.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147291/pexels-photo-7147291.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147285/pexels-photo-7147285.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7031720/pexels-photo-7031720.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7147299/pexels-photo-7147299.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005296/pexels-photo-7005296.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7534300/pexels-photo-7534300.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                    </div>
                </div>
                <div class="carousel__bottom">
                    <div class="bottom__track">
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/6636309/pexels-photo-6636309.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7535071/pexels-photo-7535071.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/6782353/pexels-photo-6782353.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7535073/pexels-photo-7535073.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005293/pexels-photo-7005293.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7060813/pexels-photo-7060813.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005269/pexels-photo-7005269.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/6636309/pexels-photo-6636309.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7535071/pexels-photo-7535071.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/6782353/pexels-photo-6782353.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7535073/pexels-photo-7535073.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005293/pexels-photo-7005293.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7060813/pexels-photo-7060813.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                        <div class="slide">
                            <img src="https://images.pexels.com/photos/7005269/pexels-photo-7005269.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="faqs">
            <h1>Frequently Asking Question</h1>
            <div class="faq-content">
                <div class="faq__wrap">
                    <div class="wrap__question" id="1">
                        What is Euphoria mean ?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="wrap__answer" id="1">
                        Euphoria mean "A feeling or state of intense excitement and happiness", and that we implement in our store. So we hope you will feel happy when buying product in our store, and happy after using our product
                    </div>
                </div>
                <div class="faq__wrap">
                    <div class="wrap__question" id="2">
                        Can we test the product first ?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="wrap__answer" id="2">
                        Yes, you can test your dream product in our physical store. in Cokroaminoto street, no. 334 
                    </div>
                </div>
                <div class="faq__wrap">
                    <div class="wrap__question" id="3">
                        How about the payment if i want buying online ?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="wrap__answer" id="3">
                        in our online store, we currently just have bank transfer payment method. And i hope we can expanding use payment gateway soon
                    </div>
                </div>
            </div>
        </div>

        <div id="about">
            <h1>About Us</h1>
            <div class="about-content">
                <p>As a store with the concept of <span>"One Stop Shopping"</span>  for all furnishings products, EUPHORIA provides various quality collections for residential, office, accessories, to commercial spaces. EUPHORIA provides a variety of the latest styles and designs to meet customer needs for dream furniture. </p>
                <p>Prioritizing customer needs and tastes, EUPHORIA Furnishing develops the latest concept of "innovative and durable designs at affordable prices".</p>
            </div>
            <div class="contact-content">
                <div class="contact__title">
                    Feel free to contact us
                </div>
                <div class="contact__info">
                    <ul>
                        <li>
                            <span>Telephone : +628 345 883 4532</span>
                            <span class="sm">Monday - Sunday</span>
                            <span class="sm">09:00 AM - 05:00 PM</span>
                        </li>
                        <li>
                            <span>Email : EUPHORIA@support.com</span>
                            <span class="sm">Everyday</span>
                            <span class="sm">24 Hours</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php include_once('layouts/app-layouts/footer.html') ?>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>