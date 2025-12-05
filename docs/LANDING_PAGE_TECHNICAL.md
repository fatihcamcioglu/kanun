# Landing Page Teknik Dokümantasyon

## Genel Bakış

Kanun-i projesinin landing page'i, kullanıcıların hizmetleri tanıdığı, kayıt olduğu ve giriş yaptığı ana giriş noktasıdır. Bootstrap 5.3.2 ve Laravel Blade templating kullanılarak geliştirilmiştir.

## Dosya Yapısı

```
resources/views/landing/
├── index.blade.php          # Ana landing page
├── login.blade.php          # Giriş sayfası
└── register.blade.php       # Kayıt sayfası

app/Http/Controllers/
├── LandingController.php    # Landing page controller
└── Auth/
    └── RegisterController.php  # Kayıt işlemleri controller

public/
├── css/
│   └── landing.css         # Landing page özel CSS dosyası
└── images/
    ├── hero-image.png      # Hero section görseli
    ├── app-store.png       # App Store butonu
    └── google-play.png     # Google Play butonu
```

## Route Yapısı

### Public Routes (routes/web.php)

```php
// Ana sayfa
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Kayıt
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Giriş
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
```

### Route Akışı

1. **Ana Sayfa (`/`)**
   - `LandingController@index` metodunu çağırır
   - Aktif FAQ'ları veritabanından çeker
   - `resources/views/landing/index.blade.php` view'ını render eder

2. **Kayıt (`/register`)**
   - GET: `RegisterController@showRegisterForm` - Kayıt formunu gösterir
   - POST: `RegisterController@register` - Kayıt işlemini gerçekleştirir

3. **Giriş (`/login`)**
   - GET: `LoginController@showLoginForm` - Giriş formunu gösterir
   - POST: `LoginController@login` - Giriş işlemini gerçekleştirir

## Controller Detayları

### LandingController

**Konum:** `app/Http/Controllers/LandingController.php`

**Sorumluluklar:**
- Ana landing page'i görüntüleme
- Aktif FAQ'ları veritabanından çekme

**Metodlar:**

```php
public function index()
{
    $faqs = Faq::where('is_active', true)
        ->orderBy('order', 'asc')
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();

    return view('landing.index', compact('faqs'));
}
```

**Özellikler:**
- Sadece aktif FAQ'ları gösterir (`is_active = true`)
- Önce `order` sütununa göre, sonra oluşturulma tarihine göre sıralar
- Maksimum 4 FAQ gösterir

### RegisterController

**Konum:** `app/Http/Controllers/Auth/RegisterController.php`

**Sorumluluklar:**
- Kayıt formunu gösterme
- Kullanıcı kayıt işlemini gerçekleştirme
- Otomatik giriş yapma

**Metodlar:**

#### `showRegisterForm()`
- Eğer kullanıcı zaten giriş yapmışsa dashboard'a yönlendirir
- Kayıt formunu gösterir

#### `register(Request $request)`
**Validasyon Kuralları:**
```php
[
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed', Password::defaults()],
    'phone' => ['nullable', 'string', 'max:255'],
]
```

**İşlem Akışı:**
1. Form verilerini validate eder
2. Yeni kullanıcı oluşturur:
   - `role`: 'CUSTOMER'
   - `status`: 'active'
   - Şifre hash'lenir
3. Kullanıcıyı otomatik giriş yapar
4. Dashboard'a yönlendirir

### LoginController

**Konum:** `app/Http/Controllers/Customer/Auth/LoginController.php`

**Sorumluluklar:**
- Giriş formunu gösterme
- Kullanıcı giriş işlemini gerçekleştirme
- Rol kontrolü yapma

**Metodlar:**

#### `showLoginForm()`
- Eğer kullanıcı zaten giriş yapmışsa dashboard'a yönlendirir
- Giriş formunu gösterir

#### `login(Request $request)`
**Validasyon:**
```php
[
    'email' => ['required', 'email'],
    'password' => ['required'],
]
```

**İşlem Akışı:**
1. Credentials ile giriş denemesi yapar
2. "Beni hatırla" seçeneğini kontrol eder
3. Session'ı yeniler
4. Kullanıcının rolünü kontrol eder:
   - Eğer CUSTOMER değilse, çıkış yapar ve hata döner
   - CUSTOMER ise dashboard'a yönlendirir

#### `logout(Request $request)`
- Kullanıcıyı çıkış yapar
- Session'ı geçersiz kılar
- Token'ı yeniler
- Giriş sayfasına yönlendirir

## View Yapısı

### Landing Page (index.blade.php)

**Bölümler:**

1. **Navigation Bar**
   - Logo
   - Menü linkleri (Özellikler, Nasıl Çalışır, SSS)
   - Giriş/Kayıt butonları veya Panel linki (auth durumuna göre)
   - Bootstrap navbar component kullanır

2. **Hero Section**
   - Başlık ve alt başlık
   - App Store ve Google Play indirme butonları
   - Hero görseli
   - Gradient arka plan

3. **Feature Highlights**
   - 3 özellik kartı (KVKK, Avukat Ağı, SLA)
   - Bootstrap grid (`col-md-4`)

4. **Nasıl Çalışır**
   - 4 adımlı süreç açıklaması
   - Bootstrap grid (`col-md-6 col-lg-3`)

5. **Neleri Sağlıyoruz**
   - 6 özellik kartı
   - Bootstrap grid (`col-md-6 col-lg-4`)

6. **SSS (FAQ)**
   - Accordion yapısı
   - Veritabanından dinamik çekilir
   - Bootstrap grid (`col-lg-8`)

7. **CTA Section**
   - Call-to-action başlığı
   - Kayıt/Giriş butonları
   - App Store ve Google Play butonları

8. **Footer**
   - Copyright bilgisi
   - Yasal linkler (Kullanım Koşulları, Gizlilik & KVKK, İade Politikası)
   - İletişim bilgileri
   - Avukat girişi linki
   - Bootstrap grid (`col-md-4`)

### Login Page (login.blade.php)

**Özellikler:**
- Bootstrap 5.3.2 entegrasyonu
- Responsive tasarım
- Form validasyonu
- Hata mesajları gösterimi
- "Beni hatırla" seçeneği
- Ana sayfaya dönüş linki
- Mobil görünümde padding: 15px

**Form Alanları:**
- E-posta (required)
- Şifre (required)
- Beni hatırla (checkbox)

### Register Page (register.blade.php)

**Özellikler:**
- Bootstrap 5.3.2 entegrasyonu
- Responsive tasarım
- Form validasyonu
- Hata mesajları gösterimi
- Email ve telefon yan yana (Bootstrap grid)
- Mobil görünümde padding: 15px

**Form Alanları:**
- Ad Soyad (required)
- E-posta (required, unique)
- Telefon (optional)
- Şifre (required, min 8 karakter)
- Şifre Tekrar (required, password confirmation)

## CSS Yapısı

### landing.css

**Konum:** `public/css/landing.css`

**Ana Bölümler:**
- Bootstrap uyumluluk ayarları
- Header/Navbar stilleri
- Hero section stilleri
- Feature highlights
- How it works section
- Features section
- FAQ section
- CTA section
- Footer stilleri
- Responsive media queries

**Responsive Breakpoints:**
- `@media (max-width: 1024px)` - Tablet görünümü
- `@media (max-width: 768px)` - Mobil görünümü

**Önemli Özellikler:**
- Poppins font kullanımı
- Gradient arka planlar
- Hover efektleri
- Smooth transitions
- Shadow efektleri

## Bootstrap Entegrasyonu

### Kullanılan Bootstrap Bileşenleri

1. **Navbar**
   - `navbar`, `navbar-expand-lg`, `navbar-light`
   - `container` ile sınırlandırılmış
   - Responsive toggle butonu

2. **Grid System**
   - Feature Highlights: `col-md-4`
   - How It Works: `col-md-6 col-lg-3`
   - Features: `col-md-6 col-lg-4`
   - FAQ: `col-lg-8`
   - Footer: `col-md-4`

3. **Form Components**
   - Bootstrap form input'ları
   - Validation states
   - Button components

4. **Utilities**
   - Spacing (`py-5`, `mb-3`, `g-4`)
   - Text alignment (`text-center`, `text-md-start`)
   - Display utilities (`d-flex`, `d-none`)

## Veritabanı Entegrasyonu

### FAQ Modeli

**Kullanım:**
```php
$faqs = Faq::where('is_active', true)
    ->orderBy('order', 'asc')
    ->orderBy('created_at', 'desc')
    ->limit(4)
    ->get();
```

**Gereksinimler:**
- `is_active` sütunu (boolean)
- `order` sütunu (integer)
- `question` sütunu (text)
- `answer` sütunu (text/html)

## Authentication Akışı

### Kayıt Akışı

```
1. Kullanıcı /register sayfasına gelir
2. Formu doldurur (ad, email, telefon, şifre)
3. Form submit edilir
4. Validasyon yapılır
5. Yeni User kaydı oluşturulur (role: CUSTOMER, status: active)
6. Kullanıcı otomatik giriş yapar
7. /customer/dashboard'a yönlendirilir
```

### Giriş Akışı

```
1. Kullanıcı /login sayfasına gelir
2. Email ve şifre girer
3. Form submit edilir
4. Laravel Auth::attempt() ile doğrulama yapılır
5. Rol kontrolü yapılır (CUSTOMER olmalı)
6. Session yenilenir
7. /customer/dashboard'a yönlendirilir
```

### Çıkış Akışı

```
1. Kullanıcı logout butonuna tıklar
2. Session temizlenir
3. CSRF token yenilenir
4. /login sayfasına yönlendirilir
```

## Güvenlik Özellikleri

1. **CSRF Koruması**
   - Tüm formlarda `@csrf` token kullanılır

2. **Password Hashing**
   - Laravel'in `Hash::make()` fonksiyonu kullanılır
   - Bcrypt algoritması

3. **Validation**
   - Tüm input'lar validate edilir
   - Email unique kontrolü
   - Password confirmation kontrolü

4. **Role-Based Access**
   - Sadece CUSTOMER rolündeki kullanıcılar giriş yapabilir
   - Diğer rollere sahip kullanıcılar reddedilir

5. **Session Security**
   - Session regenerate edilir
   - Remember token kullanımı

## Responsive Tasarım

### Mobil Görünüm (< 768px)

- Navbar: Toggle butonu ile menü
- Hero: Tek sütun, görsel altında
- Grid: Tüm bölümler tek sütun
- Form: Email ve telefon alt alta
- Padding: Auth-box padding 15px

### Tablet Görünüm (768px - 1024px)

- Navbar: Tam menü görünür
- Grid: 2 sütunlu yapı
- Form: Email ve telefon yan yana

### Desktop Görünüm (> 1024px)

- Navbar: Tam genişlik menü
- Grid: 3-4 sütunlu yapı
- Form: Email ve telefon yan yana
- Container: Maksimum genişlik sınırlaması

## Kullanılan Teknolojiler

- **Laravel**: Backend framework
- **Blade**: Template engine
- **Bootstrap 5.3.2**: CSS framework
- **Poppins Font**: Google Fonts
- **Laravel Eloquent**: ORM

## Performans Optimizasyonları

1. **View Caching**
   - Blade view'lar cache'lenir
   - `php artisan view:clear` ile temizlenebilir

2. **CSS/JS Minification**
   - Production'da CSS ve JS dosyaları minify edilebilir

3. **Image Optimization**
   - Görseller optimize edilmiş boyutlarda
   - `img-fluid` class ile responsive görseller

4. **Database Query Optimization**
   - FAQ sorgusu limit edilmiş (4 adet)
   - Sadece aktif kayıtlar çekilir

## Bakım ve Güncelleme

### Yeni FAQ Ekleme

1. Admin panelinden veya veritabanından FAQ ekleyin
2. `is_active = true` olarak işaretleyin
3. `order` değerini ayarlayın
4. Landing page otomatik olarak güncellenecektir

### Stil Değişiklikleri

- Ana CSS dosyası: `public/css/landing.css`
- Inline style kullanılmamalı (proje standardı)
- Responsive değişiklikler için media query kullanın

### Yeni Bölüm Ekleme

1. `resources/views/landing/index.blade.php` dosyasına yeni section ekleyin
2. Bootstrap grid sistemini kullanın
3. `public/css/landing.css` dosyasına stilleri ekleyin
4. Responsive görünümü test edin

## Sorun Giderme

### FAQ'lar Görünmüyor

- Veritabanında `is_active = true` olan FAQ var mı kontrol edin
- FAQ modeli import edilmiş mi kontrol edin (`use App\Models\Faq;`)
- Veritabanı bağlantısı çalışıyor mu kontrol edin

### Form Validasyon Hataları

- Validation mesajları `@error` direktifi ile gösterilir
- Form action route'ları doğru mu kontrol edin
- CSRF token eksik olabilir

### Responsive Görünüm Bozuk

- Bootstrap CSS dosyası yüklenmiş mi kontrol edin
- Viewport meta tag var mı kontrol edin
- Media query'ler doğru mu kontrol edin

## Gelecek Geliştirmeler

1. **Çoklu Dil Desteği**
   - Laravel localization kullanılabilir
   - Route prefix ile dil değişimi

2. **A/B Testing**
   - Farklı hero section varyasyonları test edilebilir

3. **Analytics Entegrasyonu**
   - Google Analytics veya benzeri servisler eklenebilir
   - Conversion tracking

4. **SEO Optimizasyonu**
   - Meta tags dinamikleştirilebilir
   - Open Graph tags eklenebilir
   - Structured data (Schema.org)

5. **Performance Monitoring**
   - Lighthouse skorları takip edilebilir
   - Core Web Vitals ölçümleri

## Referanslar

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
- [Blade Template Documentation](https://laravel.com/docs/blade)
- [Laravel Authentication](https://laravel.com/docs/authentication)

