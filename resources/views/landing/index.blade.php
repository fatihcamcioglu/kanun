<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANUN-I - Hukuki Sorularınıza Hızlı ve Güvenli Yanıt</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(135deg, #0a4d68 0%, #0d6b8f 100%); padding: 1rem 0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                <img src="{{ asset('logo.png') }}" alt="Kanun-i Logo" class="logo-img" style="max-height: 50px; margin-right: 10px;">
      
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Özellikler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Nasıl Çalışır</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">SSS</a>
                    </li>
                    @auth
                        <li class="nav-item ms-2">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-light">Panel</a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-danger me-2">Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-warning text-dark fw-semibold">Kayıt Ol</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header Section -->
    <header class="header-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    Hukuki sorularınıza <span class="highlight">hızlı ve güvenli</span> yanıt.
                </h1>
                <p class="hero-subtitle">
                    Yazılı, sesli biçimde sorunuzu iletin; kimliği doğrulanmış avukatlardan kısa sürede yanıt alın.
                </p>
                <div class="app-buttons">
                    <a href="#" class="app-btn app-store">
                       <img src="{{ asset('images/app-store.png') }}" alt="App Store" class="img-fluid" style="max-height: 70px;">
                    </a>
                    <a href="#" class="app-btn google-play">
                        <img src="{{ asset('images/google-play.png') }}" alt="Google Play" class="img-fluid" style="max-height: 70px;">
                    </a>
                </div>
                <p class="disclaimer">
                    *Kanun-i bir platformdur; avukat-müvekkil ilişkisi ilgili avukat ile aranızda kurulur. Detaylar için Kullanım Koşulları ve Aydınlatma Metni'ni inceleyiniz.
                </p>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero/10.png') }}" alt="Kanun-i Hero Image" class="img-fluid" style="max-height: 70vh;">
            </div>
        </div>
        

    </header>
    <section class="how-it-works-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="highlight-item">
                        <span class="highlight-icon">🔒</span>
                        <span>KVKK uyumlu veri işleme & uçtan uca şifreleme</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="highlight-item">
                        <span class="highlight-icon">✅</span>
                        <span>Kimliği doğrulanmış avukat ağı</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="highlight-item">
                        <span class="highlight-icon">⚡</span>
                        <span>Hızlı yanıt SLA'sı & müşteri memnuniyeti</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works py-5">
        <div class="container">
            <h2 class="section-title mb-5">Nasıl çalışır?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Paket seçin</h3>
                        <p class="step-description">İhtiyacınıza uygun soru/konuşma hakları belirlenir.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h3 class="step-title">Sorunuzu iletin</h3>
                        <p class="step-description">Yazı veya ses kaydı yükleyin; belgeleri ekleyin.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Avukat cevaplasın</h3>
                        <p class="step-description">Kimliği doğrulanmış avukatlardan SLA içinde yanıt alın.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <h3 class="step-title">Değerlendirin</h3>
                        <p class="step-description">Cevabı puanlayın; gerekirse ikinci görüş/iade talep edin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Provide Section -->
    <section id="features" class="features-section py-5">
        <div class="container">
            <h2 class="section-title mb-5">Neleri sağlıyoruz?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">💬</div>
                        <h3 class="feature-title">2 formatta danışma</h3>
                        <p class="feature-text">Yazılı, sesli mesaj ile sorunuzu iletin.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">📦</div>
                        <h3 class="feature-title">Paket bazlı esneklik</h3>
                        <p class="feature-text">Kredi sistemiyle soru ve ses hakları sizde.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">⭐</div>
                        <h3 class="feature-title">Kalite puanlama</h3>
                        <p class="feature-text">Yanıtları puanlayın, düşük puanda ikinci görüş/iade akışı.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">🛡️</div>
                        <h3 class="feature-title">KVKK & güvenlik</h3>
                        <p class="feature-text">TLS, denetim izi, saklama politikaları ve anonimleştirme.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">🔔</div>
                        <h3 class="feature-title">Bildirim ve takip</h3>
                        <p class="feature-text">Push/e-posta bildirimleri, durum takibi ve SLA zamanlayıcıları.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon">🏢</div>
                        <h3 class="feature-title">Kurumsal kullanım</h3>
                        <p class="feature-text">Takım lisansları, rol yönetimi ve aylık raporlar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq-section py-5">
        <div class="container">
            <h2 class="section-title mb-5">Sıkça Sorulan Sorular</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-list">
                        @forelse($faqs as $faq)
                            <div class="faq-item mb-3">
                                <div class="faq-question">
                                    {{ $faq->question }}
                                    <span class="faq-toggle">▼</span>
                                </div>
                                <div class="faq-answer">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        @empty
                            <div class="faq-empty text-center">
                                <p>Henüz soru eklenmemiş.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="cta-title mb-3">Hukuki sorununuz mu var?</h2>
                    <p class="cta-subtitle mb-4">Kanun-i'yi indirip hemen paket seçin, sorunuza hızlıca yanıt alın.</p>
                    <div class="cta-buttons mb-4">
                        @auth
                            <a href="{{ route('customer.dashboard') }}" class="cta-btn-primary">Panele Git</a>
                        @else
                            <a href="{{ route('register') }}" class="cta-btn-primary">Hemen Kayıt Ol</a>
                            <a href="{{ route('login') }}" class="cta-btn-secondary">Giriş Yap</a>
                        @endauth
                    </div>
                    <div class="app-buttons">
                        <a href="#" class="app-btn app-store">
                            <img src="{{ asset('images/app-store.png') }}" alt="App Store" class="img-fluid" style="max-height: 70px;">
                        </a>
                        <a href="#" class="app-btn google-play">
                            <img src="{{ asset('images/google-play.png') }}" alt="Google Play" class="img-fluid" style="max-height: 70px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-4 text-center text-md-start">
                    <p class="footer-left mb-0">© 2025 Tüm hakları saklıdır.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="footer-center d-flex justify-content-center flex-wrap gap-3">
                        <a href="#">Kullanım Koşulları</a>
                        <a href="#">Gizlilik & KVKK</a>
                        <a href="#">İade Politikası</a>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <div class="footer-right">
                       
                        <a href="{{ route('filament.lawyer.auth.login') }}" class="lawyer-login-link">Avukat Girişi</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                const isActive = item.classList.contains('active');
                
                // Close all items
                document.querySelectorAll('.faq-item').forEach(faqItem => {
                    faqItem.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

