# Kanun-i Proje Geliştirme Dokümantasyonu

## 📋 İçindekiler

1. [Proje Genel Bakış](#proje-genel-bakış)
2. [Geliştirme Aşamaları](#geliştirme-aşamaları)
3. [Eklenen Özellikler](#eklenen-özellikler)
4. [Çalışan Sistemler](#çalışan-sistemler)
5. [Teknik Detaylar](#teknik-detaylar)
6. [Veritabanı Yapısı](#veritabanı-yapısı)
7. [E-posta Bildirimleri](#e-posta-bildirimleri)
8. [Admin Panel Özellikleri](#admin-panel-özellikleri)
9. [Müşteri Panel Özellikleri](#müşteri-panel-özellikleri)
10. [Avukat Panel Özellikleri](#avukat-panel-özellikleri)
11. [Önemli Notlar](#önemli-notlar)

---

## Proje Genel Bakış

**Kanun-i**, online hukuki danışmanlık platformudur. Müşteriler avukatlara soru sorabilir, paket satın alabilir ve video içeriklerine erişebilirler. Platform üç ana kullanıcı rolü ile çalışır:

- **MÜŞTERİ (CUSTOMER)**: Hukuki soru soran, paket satın alan kullanıcılar
- **AVUKAT (LAWYER)**: Sorulara cevap veren avukatlar
- **ADMIN**: Tüm sistem yönetimini yapan yöneticiler

### Teknoloji Stack

- **Backend**: PHP 8.3+, Laravel 12
- **Admin Panel**: Filament Admin v4
- **Veritabanı**: MySQL 8 / MariaDB
- **Frontend**: Blade Templates, Tailwind CSS, Bootstrap 5
- **E-posta**: Laravel Mail (SMTP - Gmail)
- **Dosya Depolama**: Laravel Storage (Public Disk)

---

## Geliştirme Aşamaları

### Aşama 1: Temel Altyapı ve Sistem Kurulumu ✅

**Tamamlanan İşler:**
- Laravel 12 proje kurulumu
- Filament Admin v4 entegrasyonu
- Veritabanı yapısı oluşturuldu
- Kullanıcı rolleri ve yetkilendirme sistemi
- Authentication sistemi

**Oluşturulan Modeller:**
- `User` (Roller: ADMIN, LAWYER, CUSTOMER)
- `LegalCategory` (Hukuki kategoriler)
- `LegalQuestion` (Hukuki sorular)
- `LegalMessage` (Mesajlaşma sistemi)
- `Package` (Paketler)
- `CustomerPackageOrder` (Siparişler)
- `LawyerProfile` (Avukat profilleri)
- `QuestionFile` (Soru ek dosyaları)

### Aşama 2: FAQ (Sıkça Sorulan Sorular) Sistemi ✅

**Eklenen Özellikler:**
- Admin panelinden FAQ yönetimi
- Müşteri panelinde FAQ görüntüleme
- FAQ sıralama ve aktif/pasif durumu

**Oluşturulan Dosyalar:**
- `database/migrations/2025_12_01_222324_create_faqs_table.php`
- `app/Models/Faq.php`
- `app/Filament/Resources/FaqResource.php`
- `app/Policies/FaqPolicy.php`
- `app/Http/Controllers/Customer/FaqController.php`
- `resources/views/customer/faqs/index.blade.php`
- Route: `/customer/faqs`

**Admin Panel Özellikleri:**
- FAQ ekleme/düzenleme/silme
- Soru ve cevap alanları
- Sıralama (order) alanı
- Aktif/Pasif toggle

**Müşteri Panel Özellikleri:**
- Tüm aktif FAQ'ları listeleme
- Sıralamaya göre görüntüleme
- Navigasyon menüsüne "SSS" linki eklendi

### Aşama 3: E-posta Bildirimleri Sistemi ✅

**Eklenen Özellikler:**
- Soru avukata atandığında avukata e-posta gönderimi
- Avukat atandığında müşteriye e-posta gönderimi
- Soru cevaplandığında müşteriye e-posta gönderimi

**Oluşturulan Bildirimler:**
- `app/Notifications/QuestionAssignedToLawyer.php`
- `app/Notifications/LawyerAssignedToCustomer.php`
- `app/Notifications/QuestionAnswered.php`

**SMTP Yapılandırması:**
- Google Workspace SMTP entegrasyonu
- `info@kanun-i.com` e-posta adresi kullanımı
- Uygulama şifresi ile güvenli bağlantı
- Yapılandırma dosyası: `SMTP_AYARLARI.md`

**Bildirim Tetikleme Noktaları:**
1. **Avukat Atama:**
   - `app/Filament/Resources/LegalQuestionResource.php` - `assign_lawyer` action
   - `app/Filament/Widgets/PendingQuestionsWidget.php` - Dashboard widget

2. **Soru Cevaplama:**
   - `app/Filament/Lawyer/Resources/AssignedQuestionResource/RelationManagers/MessagesRelationManager.php`
   - `app/Filament/Lawyer/Resources/AssignedQuestionResource/Pages/ViewAssignedQuestion.php`

**E-posta Şablonları:**
- Logo entegrasyonu (PNG formatında)
- Laravel Mail template özelleştirmesi
- `resources/views/vendor/mail/html/header.blade.php` - Logo gösterimi
- `resources/views/vendor/mail/html/message.blade.php` - Mesaj şablonu

### Aşama 4: Video Yönetim Sistemi ✅

**Eklenen Özellikler:**
- Video kategorileri yönetimi
- Video ekleme/düzenleme/silme
- Vimeo entegrasyonu
- Kapak resmi yükleme
- Müşteri panelinde video görüntüleme

**Oluşturulan Modeller:**
- `app/Models/VideoCategory.php`
- `app/Models/Video.php`

**Migration Dosyaları:**
- `database/migrations/2025_12_01_225130_create_video_categories_table.php`
- `database/migrations/2025_12_01_225132_create_videos_table.php`

**Admin Panel Özellikleri:**
- `app/Filament/Resources/VideoCategoryResource.php`
  - Kategori adı, slug (otomatik), açıklama
  - Sıralama ve aktif/pasif durumu
  - Slug otomatik oluşturma (name alanından)

- `app/Filament/Resources/VideoResource.php`
  - Video başlığı, kısa açıklama
  - Kapak resmi yükleme (16:9 aspect ratio)
  - Vimeo linki
  - Sıralama ve aktif/pasif durumu
  - Kategori seçimi

**Müşteri Panel Özellikleri:**
- `app/Http/Controllers/Customer/VideoController.php`
- Video listesi sayfası (`/customer/videos`)
- Video detay sayfası (`/customer/videos/{video}`)
- Kategori filtreleme
- Vimeo embed oynatıcı
- İlgili videolar önerisi
- Navigasyon menüsüne "Videolar" linki eklendi

**Video Özellikleri:**
- Vimeo URL'lerinden video ID çıkarma
- Embed URL otomatik oluşturma
- Kapak resmi URL accessor (`getCoverImageUrlAttribute()`)
- Placeholder görsel desteği

### Aşama 5: Hata Düzeltmeleri ve İyileştirmeler ✅

**Düzeltilen Hatalar:**

1. **TypeError - VideoCategoryResource Slug Oluşturma**
   - **Sorun:** Filament v4'te `Forms\Set` tipi değişmiş
   - **Çözüm:** Tip tanımı kaldırıldı, `live(onBlur: true)` kullanıldı
   - **Dosya:** `app/Filament/Resources/VideoCategoryResource.php`

2. **Video Kapak Resmi Yüklenmiyor**
   - **Sorun:** Resim yolları yanlış oluşturuluyordu
   - **Çözüm:** `Video` modelinde `cover_image_url` accessor eklendi
   - **Dosya:** `app/Models/Video.php`, `resources/views/customer/videos/*.blade.php`

3. **RouteNotFoundException - Login Route**
   - **Sorun:** Müşteri paneli için authentication hatası
   - **Çözüm:** Exception handler özelleştirildi
   - **Dosya:** `bootstrap/app.php`

4. **E-posta Logo Görünmüyor**
   - **Sorun:** Logo base64 veya URL olarak yüklenemiyordu
   - **Çözüm:** Logo PNG dosyası `public/logo.png` olarak eklendi, direkt URL kullanımı
   - **Dosyalar:** 
     - `resources/views/vendor/mail/html/header.blade.php`
     - `resources/views/vendor/mail/html/message.blade.php`

5. **Filament v4 Uyumluluk Sorunları**
   - `Forms\Components\View` kaldırıldı (Filament v4'te yok)
   - `Section` component namespace düzeltildi
   - `infolist` method signature güncellendi

---

## Eklenen Özellikler

### 1. FAQ Sistemi ✅

**Admin Panel:**
- FAQ CRUD işlemleri
- Sıralama desteği
- Aktif/Pasif durumu
- Policy ile yetkilendirme (sadece ADMIN)

**Müşteri Panel:**
- Aktif FAQ listesi
- Sıralamaya göre görüntüleme
- Responsive tasarım

### 2. E-posta Bildirimleri ✅

**Bildirim Tipleri:**
1. **Avukata Soru Atandığında**
   - Konu: "Yeni Bir Soru Size Atandı - Kanun-i"
   - İçerik: Soru başlığı, kategori, müşteri bilgisi
   - Link: Avukat paneli soru detay sayfası

2. **Müşteriye Avukat Atandığında**
   - Konu: "Sorunuza Avukat Atandı - Kanun-i"
   - İçerik: Avukat bilgisi, kategori
   - Link: Müşteri paneli soru detay sayfası

3. **Müşteriye Soru Cevaplandığında**
   - Konu: "Sorunuza Cevap Verildi - Kanun-i"
   - İçerik: Avukat bilgisi, kategori
   - Link: Müşteri paneli soru detay sayfası

**E-posta Özellikleri:**
- Logo gösterimi (PNG formatında)
- Profesyonel tasarım
- Responsive e-posta şablonu
- Laravel Mail template özelleştirmesi

### 3. Video Yönetim Sistemi ✅

**Video Kategorileri:**
- Kategori ekleme/düzenleme/silme
- Otomatik slug oluşturma
- Açıklama alanı
- Sıralama ve aktif/pasif durumu

**Videolar:**
- Video ekleme/düzenleme/silme
- Kapak resmi yükleme (16:9 aspect ratio, 2MB max)
- Vimeo linki entegrasyonu
- Başlık ve kısa açıklama
- Sıralama ve aktif/pasif durumu
- Kategoriye göre filtreleme

**Müşteri Panel:**
- Tüm videoları listeleme
- Kategori filtreleme
- Video detay sayfası
- Vimeo embed oynatıcı
- İlgili videolar önerisi

---

## Çalışan Sistemler

### ✅ Tamamen Çalışan Sistemler

1. **Kullanıcı Yönetimi**
   - Kayıt ve giriş sistemi
   - Rol tabanlı yetkilendirme (ADMIN, LAWYER, CUSTOMER)
   - Şifre hashleme ve güvenlik

2. **Hukuki Soru Sistemi**
   - Soru oluşturma (yazılı, sesli, dosya ekli)
   - Soru listeleme ve filtreleme
   - Durum yönetimi (waiting_assignment, waiting_lawyer_answer, answered, closed)
   - Mesajlaşma sistemi
   - Dosya yükleme desteği

3. **Paket ve Sipariş Sistemi**
   - Paket CRUD işlemleri
   - Paket satın alma
   - Sipariş yönetimi
   - Havale onaylama

4. **Admin Panel (Filament v4)**
   - Kullanıcı yönetimi
   - Paket yönetimi
   - Kategori yönetimi
   - Soru yönetimi ve avukat atama
   - Sipariş yönetimi
   - Avukat profil yönetimi
   - FAQ yönetimi
   - Video yönetimi
   - Bildirim logları

5. **Avukat Panel (Filament v4)**
   - Atanan sorular listesi
   - Soru detay görüntüleme
   - Soru cevaplama
   - Mesajlaşma

6. **Müşteri Panel (Frontend)**
   - Dashboard
   - Paket görüntüleme ve satın alma
   - Soru sorma ve listeleme
   - Mesajlaşma
   - FAQ görüntüleme
   - Video görüntüleme

7. **E-posta Bildirimleri**
   - SMTP entegrasyonu (Gmail)
   - Otomatik bildirimler
   - Logo entegrasyonu

8. **Dosya Yönetimi**
   - Dosya yükleme (storage/app/public)
   - Storage link
   - Güvenli dosya erişimi

### ⚠️ Kısmen Çalışan / Geliştirme Aşamasında

1. **SMS Bildirimleri**
   - Mock servis mevcut
   - Gerçek SMS provider entegrasyonu yapılacak
   - Dosya: `app/Services/SMSService.php`

2. **Ödeme Entegrasyonları**
   - Mock servis mevcut
   - Gerçek ödeme gateway entegrasyonu yapılacak
   - Dosya: `app/Services/PaymentService.php`

---

## Teknik Detaylar

### Filament v4 Özellikleri

**Kullanılan Component'ler:**
- `Filament\Schemas\Components\Section`
- `Filament\Forms\Components\TextInput`
- `Filament\Forms\Components\Textarea`
- `Filament\Forms\Components\Toggle`
- `Filament\Forms\Components\Select`
- `Filament\Forms\Components\FileUpload`
- `Filament\Tables\Columns\ImageColumn`
- `Filament\Tables\Columns\TextColumn`
- `Filament\Tables\Columns\IconColumn`
- `Filament\Forms\Components\DateTimePicker`
- `Filament\Forms\Components\TagsInput`

**Önemli Notlar:**
- `Forms\Components\View` component'i Filament v4'te mevcut değil
- `Section` için namespace: `Filament\Schemas\Components\Section`
- `infolist` method'u `Filament\Schemas\Schema` tipinde parametre alır
- `afterStateUpdated` closure'larında tip tanımı kullanılmamalı

### Laravel 12 Özellikleri

**Kullanılan Özellikler:**
- Laravel Notification System
- Laravel Mail
- Eloquent Relationships
- Accessors ve Mutators
- Storage Facade
- Policy sınıfları
- Exception Handling

### Veritabanı İlişkileri

```
User (1) ──┬── (N) LegalQuestion (user_id)
           ├── (N) CustomerPackageOrder
           └── (N) LegalMessage (sender_id)

LegalQuestion (1) ──┬── (N) LegalMessage
                    ├── (N) QuestionFile
                    ├── (1) Category
                    └── (1) User (assigned_lawyer_id)

Package (1) ── (N) CustomerPackageOrder

VideoCategory (1) ── (N) Video
```

---

## Veritabanı Yapısı

### Yeni Eklenen Tablolar

#### `faqs` Tablosu
```php
- id (bigint)
- question (text) - Soru metni
- answer (text) - Cevap metni
- order (integer) - Sıralama
- is_active (boolean) - Aktif/Pasif
- created_at, updated_at
```

#### `video_categories` Tablosu
```php
- id (bigint)
- name (string) - Kategori adı
- slug (string, unique) - URL slug
- description (text, nullable) - Açıklama
- order (integer) - Sıralama
- is_active (boolean) - Aktif/Pasif
- created_at, updated_at
```

#### `videos` Tablosu
```php
- id (bigint)
- video_category_id (foreign key) - Kategori ID
- title (string) - Video başlığı
- short_description (text, nullable) - Kısa açıklama
- cover_image_path (string, nullable) - Kapak resmi yolu
- vimeo_link (string) - Vimeo linki
- order (integer) - Sıralama
- is_active (boolean) - Aktif/Pasif
- created_at, updated_at
```

---

## E-posta Bildirimleri

### SMTP Yapılandırması

**Gerekli .env Ayarları:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@kanun-i.com
MAIL_PASSWORD="uygulama_sifresi"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@kanun-i.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Not:** Google Workspace kullanıldığı için uygulama şifresi oluşturulmalı.

### Bildirim Akışı

1. **Soru Oluşturulduğunda:**
   - Durum: `waiting_assignment`
   - Henüz bildirim gönderilmez

2. **Avukat Atandığında:**
   - Avukata bildirim: `QuestionAssignedToLawyer`
   - Müşteriye bildirim: `LawyerAssignedToCustomer`
   - Durum: `waiting_lawyer_answer`

3. **Soru Cevaplandığında:**
   - Müşteriye bildirim: `QuestionAnswered`
   - Durum: `answered`
   - `answered_at` alanı doldurulur

### E-posta Şablonları

**Özelleştirilen Dosyalar:**
- `resources/views/vendor/mail/html/header.blade.php` - Logo gösterimi
- `resources/views/vendor/mail/html/message.blade.php` - Mesaj şablonu

**Logo:**
- Dosya: `public/logo.png`
- URL: `https://kanun.test/logo.png`
- Direkt URL olarak kullanılır (base64 değil)

---

## Admin Panel Özellikleri

### Filament Resources

1. **UserResource** - Kullanıcı yönetimi
2. **PackageResource** - Paket yönetimi
3. **LegalCategoryResource** - Kategori yönetimi
4. **LegalQuestionResource** - Soru yönetimi ve avukat atama
5. **CustomerPackageOrderResource** - Sipariş yönetimi
6. **LawyerProfileResource** - Avukat profil yönetimi
7. **FaqResource** - FAQ yönetimi ✨ YENİ
8. **VideoCategoryResource** - Video kategori yönetimi ✨ YENİ
9. **VideoResource** - Video yönetimi ✨ YENİ
10. **NotificationLogResource** - Bildirim logları

### Dashboard Widgets

- Bekleyen sorular widget'ı
- İstatistik widget'ları
- Grafik ve raporlar

---

## Müşteri Panel Özellikleri

### Route'lar

```
/customer/dashboard - Dashboard
/customer/packages - Paket listesi
/customer/packages/{id} - Paket detayı
/customer/questions - Soru listesi
/customer/questions/create - Soru oluşturma
/customer/questions/{id} - Soru detayı
/customer/faqs - FAQ listesi ✨ YENİ
/customer/videos - Video listesi ✨ YENİ
/customer/videos/{video} - Video detay ✨ YENİ
```

### Navigasyon Menüsü

- Dashboard
- Paketlerim
- Sorularım
- SSS (FAQ) ✨ YENİ
- Videolar ✨ YENİ

---

## Avukat Panel Özellikleri

### Filament Resources

1. **AssignedQuestionResource** - Atanan sorular

### Özellikler

- Atanan soruları listeleme
- Soru detay görüntüleme
- Soru cevaplama
- Mesajlaşma
- Sesli soru dinleme
- Dosya görüntüleme

---

## Önemli Notlar

### Dosya Yolları ve Storage

**Public Storage:**
- Ses dosyaları: `storage/app/public/legal-questions/voices/`
- Ek dosyalar: `storage/app/public/legal-questions/files/`
- Video kapak resimleri: `storage/app/public/videos/cover/`
- Logo: `public/logo.png`

**Storage Link:**
```bash
php artisan storage:link
```

### Güvenlik

- Policy sınıfları ile yetkilendirme
- CSRF koruması
- Dosya türü validasyonu
- Dosya boyutu limitleri
- Password hashing (bcrypt)

### Performans

- Eager loading kullanımı (relationships)
- Query optimization
- Cache kullanımı
- View caching

### Hata Yönetimi

- Exception handler özelleştirmesi (`bootstrap/app.php`)
- Müşteri paneli için özel authentication yönlendirmesi
- Log kayıtları

### Filament v4 Uyumluluk

- Component namespace'leri güncellendi
- Method signature'lar güncellendi
- Kaldırılan component'ler için alternatif çözümler

---

## Geliştirme Geçmişi

### Son Yapılan İşler

1. ✅ FAQ sistemi eklendi
2. ✅ E-posta bildirimleri entegre edildi
3. ✅ Video yönetim sistemi eklendi
4. ✅ Logo e-posta şablonlarına eklendi
5. ✅ Hata düzeltmeleri yapıldı
6. ✅ Filament v4 uyumluluğu sağlandı

### Gelecek Geliştirmeler (TODO)

- [ ] SMS bildirimleri (gerçek provider entegrasyonu)
- [ ] Ödeme entegrasyonları (gerçek gateway entegrasyonu)
- [ ] API geliştirmeleri
- [ ] Mobil uygulama backend'i
- [ ] Gelişmiş raporlama
- [ ] Çoklu dil desteği

---

## Kullanım Kılavuzu

### Admin Olarak Giriş

1. `/admin` adresine gidin
2. Email: `admin@kanun-i.com`
3. Şifre: `password`

### FAQ Ekleme

1. Admin panel → FAQ → Yeni Ekle
2. Soru ve cevap girin
3. Sıralama numarası verin
4. Aktif durumunu seçin
5. Kaydet

### Video Kategorisi Oluşturma

1. Admin panel → Video Kategorileri → Yeni Ekle
2. Kategori adı girin (slug otomatik oluşur)
3. Açıklama ekleyin (isteğe bağlı)
4. Sıralama ve aktif durumunu ayarlayın
5. Kaydet

### Video Ekleme

1. Admin panel → Videolar → Yeni Ekle
2. Kategori seçin
3. Başlık ve açıklama girin
4. Kapak resmi yükleyin (16:9 oranında)
5. Vimeo linkini girin
6. Sıralama ve aktif durumunu ayarlayın
7. Kaydet

### E-posta Bildirimlerini Test Etme

1. Bir soru oluşturun
2. Admin panelden avukat atayın
3. Avukat soruyu cevaplasın
4. E-posta'ları kontrol edin

---

## Sorun Giderme

### Video Kapak Resmi Görünmüyor

**Çözüm:**
```bash
php artisan storage:link
php artisan optimize:clear
```

### E-posta Gönderilmiyor

**Kontrol Listesi:**
1. `.env` dosyasında SMTP ayarları doğru mu?
2. Google Workspace uygulama şifresi doğru mu?
3. `MAIL_PASSWORD` çift tırnak içinde mi?
4. Mail log'larını kontrol edin

### Slug Oluşturulmuyor

**Çözüm:**
- Video kategori oluştururken "Kategori Adı" alanına tıklayıp çıkın (onBlur)
- Slug otomatik oluşacaktır

---

## İletişim ve Destek

Proje dokümantasyonu için:
- `docs/` klasöründeki diğer dokümantasyonlara bakın
- `SMTP_AYARLARI.md` - E-posta yapılandırması
- `docs/SYSTEM_WORKFLOW.md` - Sistem işleyişi
- `docs/LANDING_PAGE_TECHNICAL.md` - Landing page detayları

---

**Son Güncelleme:** 2025-01-27
**Versiyon:** 1.0.0
