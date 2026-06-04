<!DOCTYPE html>
<html>

<head>
    <title>Beat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    @vite(['resources/css/app.css'])
</head>

<body>
    <div class='navbar'>
        <div class='px-12 text-white p-4 flex justify-between items-center'>
            <div class='navbar-left'>
                <a href="/"><img src={{ url('images/Logo.png') }} alt="Beat Logo" class="w-4/6"></a>
            </div>
            <div class='navbar-right'>
                <select id="language-select" onchange="changeLanguage(this.value)">
                    <option value="en">English</option>
                    <option value="ar">Arabic</option>
                </select>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="welcome-section">
            <div class="user-count">
                <div class="icon"><img src={{ asset('images/Icon.png') }} alt="User Icon"></div>
                <div class="count">مشجع يتابع و يتوقع نتائج المباريات يوميًا
                    +10K</div>
            </div>
            <div class="welcome-message">
                <h1 id="welcome-title" class="text-3xl font-bold">تابع المباريات، توقّع النتائج، نافس أصدقاءك.</h1>
                <p id="welcome-subtitle" class="text-3xl mt-2">تابع النتائج المباشرة، إحصائيات الفرق، وتوقعات المباريات في تجربة مصممة لعشاق كرة القدم.</p>
            </div>
            <div class="width-full flex justify-center gap-4">
                <a href="/download/ios" class="btn btn-primary"><img src={{ asset('images/ios-icon.png') }}
                        alt="iOS Icon"></a>
                <a href="/download/android" class="btn btn-secondary"><img src={{ asset('images/android-icon.png') }}
                        alt="Android Icon"></a>
            </div>
            <div class="app-screenshot">
                <img src={{ asset('images/screenshoot.png') }} alt="App Screenshot">
            </div>
        </div>
    </div>
    <swiper-container class="mySwiper" init="false">
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 1"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 2"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 3"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 4"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 5"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 6"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 7"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 8"></swiper-slide>
        <swiper-slide><img src={{ asset('images/leages/Ads.png') }} alt="Slide 9"></swiper-slide>
    </swiper-container>
    
    <script type="module" src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-element-bundle.min.js"></script>
    <script type="module">
        const swiperEl = document.querySelector('.mySwiper');

        Object.assign(swiperEl, {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 5
                }
            }
        });

        swiperEl.initialize();
    </script>
</body>

</html>
