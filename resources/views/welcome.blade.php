<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no" />
    <title>Mytrans.uz</title>

    <!-- Web Fonts
======================== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900"
        type="text/css" />

    <!-- Stylesheet
======================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/coming-soon.css') }}" />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Document Wrapper
=============================== -->
    <div id="main-wrapper">
        <!-- Header -->
        <header id="header">
            <!-- Navbar -->
            <nav class="primary-menu navbar navbar-expand-md navbar-text-light bg-transparent border-bottom-0">
                <div class="container position-relative">
                    <div class="col-auto col-lg-2">
                        <!-- Logo -->
                        <a class="logo" href="/" title="My Trans">MY TRANS</a>
                        <!-- Logo End -->
                    </div>
                    <div class="col col-lg-8 navbar-accordion px-0">
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#header-nav">
                            <span></span><span></span><span></span>
                        </button>
                        <div id="header-nav" class="collapse navbar-collapse justify-content-center">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto col-lg-2 d-flex justify-content-end">
                        <ul class="social-icons social-icons-light">
                            <li class="social-icons-twitter">
                                <a data-bs-toggle="tooltip" href="http://www.twitter.com/" target="_blank"
                                    title="Twitter"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="social-icons-facebook">
                                <a data-bs-toggle="tooltip" href="http://www.facebook.com/" target="_blank"
                                    title="Facebook"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li class="social-icons-instagram">
                                <a data-bs-toggle="tooltip" href="http://www.instagram.com/" target="_blank"
                                    title="Instagram"><i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
        </header>
        <!-- Header End -->

        <div class="container-fluid px-0">
            <section class="hero-wrap">
                <div id="particles-js" class="hero-particles"></div>
                <div class="hero-mask opacity-9 bg-dark"></div>
                <div class="hero-bg" style="background-image: url('./images/intro-bg.jpg')"></div>
                <div class="hero-content min-vh-100 d-flex flex-column">
                    <div class="container py-5 px-4 px-lg-5 my-auto">
                        <div class="row py-5 py-sm-4">
                            <div class="col-auto text-white text-center mx-auto mb-4 pb-2">
                                <div class="countdown" data-countdown-end="2022/06/18 12:00:00"></div>
                            </div>
                            <div class="col-12 text-center mx-auto">
                                <h1 class="text-9 text-white bg-danger d-inline-block fw-700 rounded px-3 py-2 mb-4">
                                    Coming Soon!
                                </h1>
                                <h2 class="text-15 fw-600 text-white mb-4">
                                    Our new website is on its way.
                                </h2>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="container text-center">
                        <p class="text-light text-2 mb-2">
                            Copyright © 2021
                            <a class="fw-600" href="https://mytrans.uz">MyTrans.uz</a>. All
                            Rights Reserved.
                        </p>
                    </footer>
                </div>
            </section>
        </div>
    </div>
    <!-- Document Wrapper End -->

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"
        integrity="sha512-72WD92hLs7T5FAXn3vkNZflWG6pglUDDpm87TeQmfSg8KnrymL2G30R7as4FmTwhgu9H7eSzDCX3mjitSecKnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"
        integrity="sha512-Kef5sc7gfTacR7TZKelcrRs15ipf7+t+n7Zh6mKNJbmW+/RRdCW9nwfLn4YX0s2nO6Kv5Y2ChqgIakaC6PW09A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.js"
        integrity="sha512-FG4FmjLeSvZ4T4WW7nwMqwA/sEzOn5l0jHjceT+N5UX/sTFaBgljBhFWpTRi+n4YuxIgvnokTX0IQ9ROE0Y0QA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"
        integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Preloader
        $(window).on("load", function() {
            $(".lds-ellipsis").fadeOut();
            $(".preloader").delay(333).fadeOut("slow");
            $("body").delay(333);
        });

        // Mobile Menu
        $(".navbar-toggler").on("click", function() {
            $(this).toggleClass("show");
        });
        $(".navbar-nav a").on("click", function() {
            $(".navbar-collapse, .navbar-toggler").removeClass("show");
        });

        /*------------------------
          tooltips
        -------------------------- */
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        /*------------------------
          Countdown
        -------------------------- */
        var countdown = $(".countdown[data-countdown-end]");

        if (countdown.length > 0) {
            countdown.each(function() {
                var $countdown = $(this),
                    finalDate = $countdown.data("countdown-end");
                $countdown.countdown(finalDate, function(event) {
                    $countdown.html(
                        event.strftime(
                            '<div class="row"><div class="col"><div class="text-12 fw-600 px-sm-3">%-D</div><span class="fw-300 opacity-9">Day%!d</span></div><div class="col"><div class="text-12 fw-600 px-sm-3">%H</div><span class="fw-300 opacity-9">Hrs</span></div><div class="col"><div class="text-12 fw-600 px-sm-3">%M</div><span class="fw-300 opacity-9">Min</span></div><div class="col"><div class="text-12 fw-600 px-sm-3">%S</div><span class="fw-300 opacity-9">Sec</span></div></div>'
                        )
                    );
                });
            });
        }

        /*------------------------
          Particles
        -------------------------- */
        particlesJS(
            "particles-js",

            {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800,
                        },
                    },
                    color: {
                        value: "#ffffff",
                    },
                    shape: {
                        type: "circle",
                        stroke: {
                            width: 0,
                            color: "#000000",
                        },
                        polygon: {
                            nb_sides: 5,
                        },
                        image: {
                            src: "img/github.svg",
                            width: 100,
                            height: 100,
                        },
                    },
                    opacity: {
                        value: 0.5,
                        random: false,
                        anim: {
                            enable: false,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false,
                        },
                    },
                    size: {
                        value: 5,
                        random: true,
                        anim: {
                            enable: false,
                            speed: 40,
                            size_min: 0.1,
                            sync: false,
                        },
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#ffffff",
                        opacity: 0.4,
                        width: 1,
                    },
                    move: {
                        enable: true,
                        speed: 6,
                        direction: "none",
                        random: false,
                        straight: false,
                        out_mode: "out",
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200,
                        },
                    },
                },
                interactivity: {
                    detect_on: "window",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "repulse",
                        },
                        onclick: {
                            enable: true,
                            mode: "push",
                        },
                        resize: true,
                    },
                    modes: {
                        grab: {
                            distance: 400,
                            line_linked: {
                                opacity: 1,
                            },
                        },
                        bubble: {
                            distance: 400,
                            size: 40,
                            duration: 2,
                            opacity: 8,
                            speed: 3,
                        },
                        repulse: {
                            distance: 200,
                        },
                        push: {
                            particles_nb: 4,
                        },
                        remove: {
                            particles_nb: 2,
                        },
                    },
                },
                retina_detect: true,
                config_demo: {
                    hide_card: false,
                    background_color: "#b61924",
                    background_image: "",
                    background_position: "50% 50%",
                    background_repeat: "no-repeat",
                    background_size: "cover",
                },
            }
        );
    </script>
</body>

</html>
