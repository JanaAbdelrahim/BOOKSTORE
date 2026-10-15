<?php
require_once __DIR__ . "/../../helpers/Helpers.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <!-- Plugins: AOS (scroll animations) + Swiper (testimonials slider) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('home/css/index.css') ?>">
</head>

<body>
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>

    <header id="Hero" class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h2>ISBN Search Feature</h2>
                                    <p>Search books using ISBN numbers or Auther names and save your time</p>
                                    <div class="hero-actions mt-4">
                                        <a href="#categories" class="btn btn-hero"><i class="fa-solid fa-book-open me-2"></i>Explore books</a>
                                        <a href="#how" class="btn btn-hero-outline"><i class="fa-solid fa-circle-play me-2"></i>How it works</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_1.png") ?>" class="img-fluid" alt="...">
                                    <span class="chip chip-1"><i class="fa-solid fa-star"></i> 4.9 rating</span>
                                    <span class="chip chip-2"><i class="fa-solid fa-truck-fast"></i> Fast delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h5>LARGEST CATALOG</h5>
                                    <h2>Over 12 Million Books</h2>
                                    <p>Start your learning journey by browsing Millions of books from our library </p>
                                    <div class="hero-actions mt-4">
                                        <a href="#categories" class="btn btn-hero"><i class="fa-solid fa-book-open me-2"></i>Explore books</a>
                                        <a href="#how" class="btn btn-hero-outline"><i class="fa-solid fa-circle-play me-2"></i>How it works</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_2.png") ?>" class="img-fluid" alt="...">
                                    <span class="chip chip-1"><i class="fa-solid fa-star"></i> 4.9 rating</span>
                                    <span class="chip chip-2"><i class="fa-solid fa-truck-fast"></i> Fast delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h5>SEARCH BOOKS EASILY</h5>
                                    <h2>ISBN Search Feature</h2>
                                    <p>Search books using ISBN numbers or Auther names and save your time</p>
                                    <div class="hero-actions mt-4">
                                        <a href="#categories" class="btn btn-hero"><i class="fa-solid fa-book-open me-2"></i>Explore books</a>
                                        <a href="#how" class="btn btn-hero-outline"><i class="fa-solid fa-circle-play me-2"></i>How it works</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_3.png") ?>" class="img-fluid" alt="...">
                                    <span class="chip chip-1"><i class="fa-solid fa-star"></i> 4.9 rating</span>
                                    <span class="chip chip-2"><i class="fa-solid fa-truck-fast"></i> Fast delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <svg class="hero-wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0,64 C240,120 480,0 720,48 C960,96 1200,110 1440,40 L1440,120 L0,120 Z"></path>
        </svg>
    </header>

    <!-- ===== Features ===== -->
    <section id="features" class="section features">
        <div class="container">
            <div class="section-head text-center" data-aos="fade-up">
                <span class="eyebrow"><i class="fa-solid fa-leaf me-2"></i>Why us</span>
                <h2>Everything a reader needs</h2>
                <p>A calm, simple place to find your next favourite book.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-card">
                        <div class="icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                        <h5>Smart search</h5>
                        <p>Find books by title, author or price in seconds.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon"><i class="fa-solid fa-tags"></i></div>
                        <h5>Fair prices</h5>
                        <p>Honest prices on every title, no hidden fees.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <h5>Fast delivery</h5>
                        <p>Your order is prepared and shipped quickly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h5>Secure account</h5>
                        <p>Your data and your orders are always protected.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Stats band ===== -->
    <section class="stats-band">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-6 col-lg-3" data-aos="zoom-in">
                    <i class="fa-solid fa-book"></i>
                    <h3><span class="counter" data-target="12000">0</span>+</h3>
                    <p>Books</p>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fa-solid fa-users"></i>
                    <h3><span class="counter" data-target="5400">0</span>+</h3>
                    <p>Happy readers</p>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fa-solid fa-feather-pointed"></i>
                    <h3><span class="counter" data-target="850">0</span>+</h3>
                    <p>Authors</p>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fa-solid fa-box-open"></i>
                    <h3><span class="counter" data-target="9800">0</span>+</h3>
                    <p>Orders delivered</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Categories ===== -->
    <section id="categories" class="section categories">
        <div class="container">
            <div class="section-head text-center" data-aos="fade-up">
                <span class="eyebrow"><i class="fa-solid fa-layer-group me-2"></i>Browse</span>
                <h2>Pick your world</h2>
                <p>From science to stories, there is a shelf for everyone.</p>
            </div>
            <div class="row g-4">
                <div class="col-6 col-lg-4" data-aos="fade-up">
                    <div class="cat-card"><i class="fa-solid fa-flask"></i><h5>Science</h5><span>Discover how things work</span></div>
                </div>
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="cat-card"><i class="fa-solid fa-landmark"></i><h5>History</h5><span>Learn from the past</span></div>
                </div>
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="cat-card"><i class="fa-solid fa-feather-pointed"></i><h5>Literature</h5><span>Novels, poems and more</span></div>
                </div>
                <div class="col-6 col-lg-4" data-aos="fade-up">
                    <div class="cat-card"><i class="fa-solid fa-laptop-code"></i><h5>Technology</h5><span>Code, design and AI</span></div>
                </div>
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="cat-card"><i class="fa-solid fa-brain"></i><h5>Self growth</h5><span>Build better habits</span></div>
                </div>
                <div class="col-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="cat-card"><i class="fa-solid fa-child-reaching"></i><h5>Kids</h5><span>Stories for little readers</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== How it works ===== -->
    <section id="how" class="section how">
        <div class="container">
            <div class="section-head text-center" data-aos="fade-up">
                <span class="eyebrow"><i class="fa-solid fa-route me-2"></i>Simple steps</span>
                <h2>How it works</h2>
            </div>
            <div class="row g-4 steps">
                <div class="col-md-4" data-aos="fade-right">
                    <div class="step"><span class="num">1</span><i class="fa-solid fa-user-plus"></i><h5>Create an account</h5><p>Register in less than a minute.</p></div>
                </div>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="step"><span class="num">2</span><i class="fa-solid fa-cart-shopping"></i><h5>Choose your books</h5><p>Add what you love to your cart.</p></div>
                </div>
                <div class="col-md-4" data-aos="fade-left">
                    <div class="step"><span class="num">3</span><i class="fa-solid fa-circle-check"></i><h5>Receive your order</h5><p>Track it from your profile page.</p></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section testimonials">
        <div class="container">
            <div class="section-head text-center" data-aos="fade-up">
                <span class="eyebrow"><i class="fa-solid fa-heart me-2"></i>Readers say</span>
                <h2>Loved by our readers</h2>
            </div>
            <div class="swiper reviewsSwiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="review">
                            <i class="fa-solid fa-quote-left"></i>
                            <p>Finding the book I wanted took seconds. The whole site feels calm and easy to use.</p>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6>Sara M.</h6>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review">
                            <i class="fa-solid fa-quote-left"></i>
                            <p>Great prices and the order tracking in my profile is super handy.</p>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6>Omar A.</h6>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review">
                            <i class="fa-solid fa-quote-left"></i>
                            <p>My go-to place for gifts. Delivery was quick and everything arrived perfectly.</p>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
                            <h6>Mona H.</h6>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review">
                            <i class="fa-solid fa-quote-left"></i>
                            <p>The catalog is huge and well organised. I always discover something new.</p>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6>Karim S.</h6>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <?php if (!isAuth("admin") && !isAuth("customer")): ?>
        <section class="cta" data-aos="zoom-in">
            <div class="container text-center">
                <i class="fa-solid fa-book-open-reader"></i>
                <h2>Ready to start reading?</h2>
                <p>Create your free account and fill your shelf today.</p>
                <a href="<?= route('/auth/register') ?>" class="btn btn-hero me-2"><i class="fa-solid fa-user-plus me-2"></i>Register</a>
                <a href="<?= route('/auth/login') ?>" class="btn btn-hero-outline"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</a>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===== Footer ===== -->
    <footer class="site-footer">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-md-4 text-center text-md-start">
                    <img src="<?= asset("images/logo.png") ?>" alt="Book Store" class="footer-logo">
                </div>
                <div class="col-md-4 text-center">
                    <a href="<?= route("") ?>"><i class="fa-solid fa-house me-1"></i>Home</a>
                    <a href="<?= route("/profile") ?>"><i class="fa-solid fa-user me-1"></i>Profile</a>
                </div>
                <div class="col-md-4 text-center text-md-end social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>
            <p class="copy">&copy;  Book Store. All rights reserved.</p>
        </div>
    </footer>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="<?= asset('home/js/index.js') ?>"></script>
</body>

</html>