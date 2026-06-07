<!DOCTYPE html>
<html dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <title>{{ __('welcome.meta.title') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                        {{ __('welcome.language.english') }}</option>
                    <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>
                        {{ __('welcome.language.arabic') }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="welcome-section">
            <div class="user-count">
                <div class="icon"><img src={{ asset('images/Stacked.png') }} alt="User Icon"></div>
                <div class="count">{{ __('welcome.hero.fans_text') }}
                    {{ __('welcome.hero.fans_count') }}</div>
            </div>
            <div class="welcome-message">
                <h1 id="welcome-title" class="text-3xl font-bold">{{ __('welcome.hero.title') }}</h1>
                <p id="welcome-subtitle" class="text-3xl mt-2">{{ __('welcome.hero.subtitle') }}</p>
            </div>
            <div class="width-full flex justify-center gap-4">
                <a href="/download/ios" class="btn btn-primary"><img src={{ asset('images/app-store.png') }}
                        alt="iOS Icon"></a>
                <a href="/download/android" class="btn btn-secondary"><img src={{ asset('images/google-play.png') }}
                        alt="Android Icon"></a>
            </div>
            <div class="app-screenshot">
                <img src={{ asset('images/screenshoot.png') }} alt="App Screenshot">
            </div>
        </div>
    </div>
    <div class="legus">
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
    </div>

    <!-- Countdown Section -->


    <!-- Match Predictions Section -->
    <div class="predictions-section">
        <div class="flex w-4/5 mx-auto py-20 gap-12 items-center justify-between">
            <div class="flex flex-col justify-center items-start gap-6 w-1/2">
                <span class="text-sm text-[#53b848] font-semibold uppercase tracking-wide">{{ __('welcome.predictions.badge') }}</span>
                <h1 class="text-4xl font-bold leading-tight">{{ __('welcome.predictions.title') }}</h1>
                <p class="text-gray-600 text-lg leading-relaxed">{{ __('welcome.predictions.description') }}</p>
            </div>
            <div class="countdown-section">
                <div class="mx-auto py-8 flex flex-row text-start">
                    <div>
                        <h2 class="countdown-title">{{ __('welcome.countdown.title') }}</h2>
                        <p class="countdown-description">{{ __('welcome.countdown.description') }}</p>
                    </div>
                    <div class="countdown-timer">
                        <div class="countdown-item">
                            <div class="countdown-value" id="days">01</div>
                            <div class="countdown-label">{{ __('welcome.countdown.labels.days') }}</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value" id="hours">15</div>
                            <div class="countdown-label">{{ __('welcome.countdown.labels.hours') }}</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value" id="minutes">19</div>
                            <div class="countdown-label">{{ __('welcome.countdown.labels.minutes') }}</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value text-white" id="seconds">52</div>
                            <div class="countdown-label">{{ __('welcome.countdown.labels.seconds') }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="w-4/5 mx-auto grid grid-cols-3 gap-4">
            <!-- Match Card 1 -->
            <div class="match-card">
                <div class="match-header">
                    <span class="match-league">{{ __('welcome.match.league') }}</span>
                    <div class="match-status">
                        <span class="status-dot"></span>
                        <span class="live-text">{{ __('welcome.match.live') }}</span>
                    </div>
                </div>
                <div class="match-details">
                    <div class="team">
                        <img src="{{ asset('images/manchester-city.png') }}" alt="Manchester City" class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_city') }}</span>
                    </div>
                    <div class="match-score">
                        <span class="score">0 : 0</span>
                        <span class="match-time">{{ __('welcome.match.time') }}</span>
                        <span class="match-time mt-2">/</span>
                    </div>
                    <div class="team">
                        <img src="{{ asset('images/liverpool.png') }}" alt="Liverpool" class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_liverpool') }}</span>
                    </div>
                </div>
            </div>
            <div class="match-card">
                <div class="match-header">
                    <span class="match-league">{{ __('welcome.match.league') }}</span>
                    <div class="match-status">
                        <span class="status-dot"></span>
                        <span class="live-text">{{ __('welcome.match.live') }}</span>
                    </div>
                </div>
                <div class="match-details">
                    <div class="team">
                        <img src="{{ asset('images/manchester-city.png') }}" alt="Manchester City"
                            class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_city') }}</span>
                    </div>
                    <div class="match-score">
                        <span class="score">0 : 0</span>
                        <span class="match-time">{{ __('welcome.match.time') }}</span>
                        <span class="match-time mt-2">/</span>
                    </div>
                    <div class="team">
                        <img src="{{ asset('images/liverpool.png') }}" alt="Liverpool" class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_liverpool') }}</span>
                    </div>
                </div>
            </div>
            <div class="match-card">
                <div class="match-header">
                    <span class="match-league">{{ __('welcome.match.league') }}</span>
                    <div class="match-status">
                        <span class="status-dot"></span>
                        <span class="live-text">{{ __('welcome.match.live') }}</span>
                    </div>
                </div>
                <div class="match-details">
                    <div class="team">
                        <img src="{{ asset('images/manchester-city.png') }}" alt="Manchester City"
                            class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_city') }}</span>
                    </div>
                    <div class="match-score">
                        <span class="score">0 : 0</span>
                        <span class="match-time">{{ __('welcome.match.time') }}</span>
                        <span class="match-time mt-2">/</span>
                    </div>
                    <div class="team">
                        <img src="{{ asset('images/liverpool.png') }}" alt="Liverpool" class="team-logo">
                        <span class="team-name mt-2">{{ __('welcome.match.team_liverpool') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="w-4/5 mx-auto py-20">
            <div class="text-center mb-12">
                <span class="text-sm text-[#53b848] font-semibold uppercase tracking-wide font-thin badge">{{ __('welcome.features.badge') }}</span>
                <h2 class="text-4xl font-bold mt-4">{{ __('welcome.features.title') }}</h2>
                <p class="text-gray-600 mt-4 text-lg">{{ __('welcome.features.description') }}</p>
            </div>
            <div class="grid grid-cols-3 gap-8 mt-12">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/field-icon.png') }}" alt="Field Icon">
                    </div>
                    <h3 class="feature-title">{{ __('welcome.features.cards.0.title') }}</h3>
                    <p class="feature-description">{{ __('welcome.features.cards.0.description') }}</p>
                </div>
                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/tournament-icon.png') }}" alt="Tournament Icon">
                    </div>
                    <h3 class="feature-title">{{ __('welcome.features.cards.1.title') }}</h3>
                    <p class="feature-description">{{ __('welcome.features.cards.1.description') }}</p>
                </div>
                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/live-icon.png') }}" alt="Live Icon">
                    </div>
                    <h3 class="feature-title">{{ __('welcome.features.cards.2.title') }}</h3>
                    <p class="feature-description">{{ __('welcome.features.cards.2.description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Download App Section -->
    <div class="download-section">
        <div class="w-4/5 mx-auto  flex items-center gap-12 wi">
            <div class="w-1/2">
                <h2 class="text-4xl font-bold mt-4 leading-tight">{{ __('welcome.download.title') }}</h2>
                <p class="text-gray-400 mt-6 text-lg leading-relaxed">{{ __('welcome.download.description') }}</p>
                <div class="flex gap-4 mt-8">
                    <a href="/download/android" class="download-btn">
                        <img src="{{ asset('images/google-play.png') }}" alt="Get it on Google Play">
                    </a>
                    <a href="/download/ios" class="download-btn">
                        <img src="{{ asset('images/app-store.png') }}" alt="Download on App Store">
                    </a>
                </div>
            </div>
            <div class="w-1/2">
                <img src="{{ asset('images/app-preview.png') }}" alt="App Preview" class="w-full">
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="testimonials-section">
        <div class="w-4/5 mx-auto py-20">
            <div class="text-center mb-12">
                <span class="text-sm text-[#53b848] font-semibold uppercase tracking-wide font-thin badge">{{ __('welcome.testimonials.badge') }}</span>
                <h2 class="text-4xl font-bold mt-4 opacity-75">{{ __('welcome.testimonials.title') }}</h2>
                <p class="text-gray-600 mt-4 text-lg">{{ __('welcome.testimonials.description') }}</p>
            </div>
            <div class="grid grid-cols-3 gap-8 mt-12">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar">A</div>
                        <div>
                            <h4 class="testimonial-name">{{ __('welcome.testimonials.items.0.name') }}</h4>
                            <div class="stars">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">{{ __('welcome.testimonials.items.0.text') }}</p>
                </div>
                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar">A</div>
                        <div>
                            <h4 class="testimonial-name">{{ __('welcome.testimonials.items.1.name') }}</h4>
                            <div class="stars">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">{{ __('welcome.testimonials.items.1.text') }}</p>
                </div>
                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="avatar">A</div>
                        <div>
                            <h4 class="testimonial-name">{{ __('welcome.testimonials.items.2.name') }}</h4>
                            <div class="stars">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">{{ __('welcome.testimonials.items.2.text') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Beatem Logo">
            </div>
            <p class="footer-description">{{ __('welcome.footer.description') }}</p>
            <div class="footer-download">
                <a href="/download/android"><img src="{{ asset('images/google-play.png') }}" alt="Google Play"></a>
                <a href="/download/ios"><img src="{{ asset('images/app-store.png') }}" alt="App Store"></a>
            </div>
            <div class="flex justify-between items-center gap-4 border-t border-gray-700 mt-4 align-center">
                <p class="footer-copyright">{{ __('welcome.footer.copyright') }}</p>

                <div class="footer-social">
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
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
        <script>
            const localeSwitchUrlTemplate = @json(route('locale.switch', ['locale' => '__LOCALE__']));

            function changeLanguage(locale) {
                window.location.href = localeSwitchUrlTemplate.replace('__LOCALE__', locale);
            }

            // Countdown Timer
            function updateCountdown() {
                // Set target date (you can change this to any future date)
                const targetDate = new Date();
                targetDate.setDate(targetDate.getDate() + 1); // 1 day from now
                targetDate.setHours(targetDate.getHours() + 15); // +15 hours
                targetDate.setMinutes(targetDate.getMinutes() + 19); // +19 minutes
                targetDate.setSeconds(targetDate.getSeconds() + 52); // +52 seconds

                function update() {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    if (distance < 0) {
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('days').textContent = String(days).padStart(2, '0');
                    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
                }

                update();
                setInterval(update, 1000);
            }

            updateCountdown();
        </script>
</body>

</html>
