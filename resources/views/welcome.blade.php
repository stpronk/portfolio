<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="description"
          content="My vision is to build Website’s & Web Applications for the future. Keeping in mind the rapid changing technology and being ahead of the rest!">
    <meta name="keywords"
          content="HTML,CSS,JavaScript,PHP,React,Laravel,Symphony,Scss,Sass,Illustrator,Git,Github,Gitlab,Bootstrap,StPronk,Steve,Pronk,Developer,Designer,Develop,Design,Web,Website,Zuid,Holland,Zuid-Holland,Zoetermeer,Nederland,Maatwerk">
    <meta name="author" content="Steve Pronk">
    <meta name="google-site-verification" content="xfuyR1cAs5xv7EvMWANbPC7PMb7G1xlk8G5pMl2tnlI"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--    ~~~ Favicon is not within the project at the moment ~~~ --}}
    {{--    <link rel="apple-touch-icon" sizes="57x57" href="images/icons/favicon/apple-icon-57x57.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="60x60" href="images/icons/favicon/apple-icon-60x60.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon/apple-icon-72x72.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="76x76" href="images/icons/favicon/apple-icon-76x76.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon/apple-icon-114x114.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="120x120" href="images/icons/favicon/apple-icon-120x120.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="144x144" href="images/icons/favicon/apple-icon-144x144.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="152x152" href="images/icons/favicon/apple-icon-152x152.png">--}}
    {{--    <link rel="apple-touch-icon" sizes="180x180" href="images/icons/favicon/apple-icon-180x180.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="192x192"  href="images/icons/favicon/android-icon-192x192.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="32x32" href="images/icons/favicon/favicon-32x32.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="96x96" href="images/icons/favicon/favicon-96x96.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="16x16" href="images/icons/favicon/favicon-16x16.png">--}}
    {{--    <meta name="msapplication-TileImage" content="images/icons/favicon/ms-icon-144x144.png">--}}
    <meta name="msapplication-TileColor" content="#000">
    <meta name="theme-color" content="#000">

    <title>StPronk | Developer</title>

    <link href="{{ asset('css/stpronk.css') }}" rel="stylesheet">

</head>
<body>
<nav class="--hidden">
    {{--        Navigation is not in order for now --}}
</nav>

<main class="container">

    <header class="intro">
        <img class="intro__background" src="{{ asset('images/header.jpeg') }}" alt="stpronk heading"/>
        <div class="intro__wrapper">
            <h1 class="intro-wrapper__heading">
                <span class="--bold">"Hi</span>, my name is
                <br class="intro-heading__break intro-heading__break--second">
                <span class="--primary --bold">Steve</span>
                <br class="intro-heading__break"/>
                and I am
                <br class="intro-heading__break intro-heading__break--second">
                a <span class="--bold">Developer"</span>
            </h1>
            <ul class="intro-wrapper__navigation">
                <li class="intro-navigation__item">About</li>
                <li class="intro-navigation__item">Portfolio</li>
                <li class="intro-navigation__item intro-navigation__item--disabled">Blog</li>
            </ul>
            <a class="intro-wrapper__scroll">
                <svg width="150" viewBox="0 0 200 50">
                    <polygon points="0,0 100,35 200,0 100,27.5  0,0" style="stroke:none;stroke-width:0;fill:white"></polygon>
                </svg>
            </a>
        </div>
    </header>

    <section class="about">
        <img class="about__image" src="{{ asset('images/StevePronk_new.jpg') }}" alt="Steve Pronk"/>
        <article class="about__content">
            <h2 class="about-content__heading">
                About <span class="--primary">me</span>
            </h2>
            <p class="about-content__text">
                Hi, my name is Steve Pronk and I am a Front-end & Back-end
                Web Developer. I love myself some code with coffee, even with some designing from time to time.
            </p>

            <p class="about-content__text --secondary-light">
                My second passion is long boarding. Just scrolling through the city, forest or alongside the beach is something I love to do. For
                me it is a good way to think about problems I come across while coding and most of the time it helps me to find a solution.
            </p>

            <p class="about-content__text">
                If you are looking for a person that can work great within a group or alone, then you have come to the right place!
            </p>

            <div class="about-content__social">
                <a href="https://facebook.com/steve.pronk" class="about-social__link" target="_blank">
                    <img class="about-social__icon" src="{{ asset('icons/facebook.svg') }}" alt="facebook">
                </a>
                <a href="https://instagram.com/stpronk" class="about-social__link" target="_blank">
                    <img class="about-social__icon" src="{{ asset('icons/instagram.svg') }}" alt="instagram">
                </a>
                <a href="https://twitter.com/stpronk" class="about-social__link" target="_blank">
                    <img class="about-social__icon" src="{{ asset('icons/twitter.svg') }}" alt="twitter">
                </a>
            </div>
        </article>
    </section>

    <section class="skills">
        <h2 class="skills__heading">My <span class="--primary">Skills</span></h2>
        <article class="skills__content">
            <div class="skills__item">
                <img class="skills-item__content" src="{{ asset('icons/html.svg') }}" alt="HTML5" />
                <span class="skills-item__content skills-item__content--second">HTML5</span>
            </div>
            <div class="skills__item">
                <img class="skills-item__content" src="{{ asset('icons/css.svg') }}" alt="CSS3" />
                <span class="skills-item__content skills-item__content--second">CSS3</span>
            </div>
        </article>
    </section>

    <section class="portfolio --hidden">
        <h2 class="portfolio__heading">My Portfolio</h2>
        <article class="portfolio__content">
            <a class="portfolio__item">
                <img src="{{ asset('images/proncar.jpg') }}" alt="Proncar" class="portfolio-item__image" />
            </a>
            <a class="portfolio__item">
                <img src="{{ asset('images/maritiem.jpg') }}" alt="Maritiem" class="portfolio-item__image" />
            </a>
            <a class="portfolio__item">
                <img src="{{ asset('images/coders.jpg') }}" alt="Coders Academy" class="portfolio-item__image" />
            </a>
        </article>
    </section>

    <section class="quotes --hidden">
        <span class="quotes__item quotes__item--active">
            “My vision is to build Website’s & Web Applications for the future. Keeping
            in mind the rapid changing technology and being ahead of the rest.”
        </span>
        <span class="quotes__item">
            “Some other quote to show that the other quote is active and this one not :)”
        </span>
    </section>

    <section class="contact --hidden">
        <h2 class="contact__heading">
            Now that is enough about me, <br />
            let’s talk about you and your idea’s!
        </h2>
        <article class="contact__content">
            <div class="contact__social">
                <a class="social__item">
                    <img src="{{ asset('icons/whatsapp.svg') }}" alt="whatsapp" />
                </a>
                <a class="social__item">
                    <img src="{{ asset('icons/mail.svg') }}" alt="mail" />
                </a>
            </div>
            <span class="contact__output"></span>
        </article>
    </section>

    <footer class="footer --hidden">
            <span class="footer__content">
                Made with <i class="fa fa-heart footer__heart"></i> by StPronk
            </span>
    </footer>
</main>

<script src="{{ asset('js/stpronk.js') }}"></script>
</body>
</html>
