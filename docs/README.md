# Kanun-i Teknik Dokümantasyon

Bu klasör, Kanun-i projesinin teknik dokümantasyonlarını içerir.

## Dokümantasyon Listesi

### 1. BASE_PROJECT_STANDARDS.md
Proje standartları ve kodlama kuralları. Tüm geliştirme süreçlerinde uyulması gereken prensipler.

**İçerik:**
- Kod standartları
- Mimari prensipler
- Dosya organizasyonu
- Database standartları
- Güvenlik kuralları
- Naming conventions

### 2. LANDING_PAGE_TECHNICAL.md
Landing page'in teknik dokümantasyonu. Sayfa yapısı, route'lar, controller'lar ve frontend detayları.

**İçerik:**
- Dosya yapısı
- Route yapısı
- Controller detayları
- View yapısı
- CSS yapısı
- Bootstrap entegrasyonu
- Responsive tasarım
- Authentication akışı

### 3. SYSTEM_WORKFLOW.md
Sistem işleyiş dokümantasyonu. Projenin genel mimarisi, kullanıcı rolleri, iş akışları ve veritabanı yapısı.

**İçerik:**
- Genel sistem mimarisi
- Kullanıcı rolleri ve yetkileri
- Hukuki soru işleyiş akışı
- Paket ve kredi sistemi
- Mesajlaşma sistemi
- Dosya yönetimi
- Bildirim sistemi
- Veritabanı şeması
- API ve Route yapısı
- Güvenlik özellikleri

## Hızlı Başlangıç

### Landing Page Geliştirme

1. **Yeni bölüm ekleme:**
   - `resources/views/landing/index.blade.php` dosyasına yeni section ekleyin
   - Bootstrap grid sistemi kullanın
   - `public/css/landing.css` dosyasına stilleri ekleyin

2. **FAQ ekleme:**
   - Admin panelinden veya veritabanından FAQ ekleyin
   - `is_active = true` olarak işaretleyin
   - `order` değerini ayarlayın

### Route Ekleme

```php
// routes/web.php dosyasına ekleyin
Route::get('/example', [ExampleController::class, 'index'])->name('example');
```

### Controller Oluşturma

```bash
php artisan make:controller ExampleController
```

## Önemli Notlar

- Tüm kod İngilizce olmalı
- Türkçe sadece kullanıcı arayüzünde kullanılır
- Inline style kullanılmamalı
- Bootstrap grid sistemi tercih edilmeli
- Tüm form validasyonları yapılmalı

## İletişim

Teknik sorular için: docs klasöründeki ilgili dokümantasyonu inceleyin.

