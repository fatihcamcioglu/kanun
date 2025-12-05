# Sistem İşleyiş Dokümantasyonu

## Genel Sistem Mimarisi

Kanun-i platformu, hukuki soru-cevap sistemi üzerine kurulu bir Laravel tabanlı web uygulamasıdır. Sistem üç ana kullanıcı rolü ile çalışır:

1. **Müşteri (CUSTOMER)**: Hukuki soru soran kullanıcılar
2. **Avukat (LAWYER)**: Sorulara cevap veren avukatlar
3. **Admin (ADMIN)**: Sistem yönetimi yapan kullanıcılar

## Kullanıcı Rolleri ve Yetkileri

### Müşteri (CUSTOMER)

**Yetkiler:**
- Kayıt olma ve giriş yapma
- Paket satın alma
- Hukuki soru sorma (yazılı, sesli, dosya ekleyerek)
- Sorularının durumunu takip etme
- Avukatlardan gelen cevapları görüntüleme
- Cevap değerlendirme (puanlama)
- İkinci görüş talep etme

**Panel Erişimi:**
- `/customer/dashboard` - Müşteri paneli
- `/customer/packages` - Paket listesi
- `/customer/questions` - Soru listesi
- `/customer/questions/create` - Yeni soru sorma

### Avukat (LAWYER)

**Yetkiler:**
- Giriş yapma
- Atanan soruları görüntüleme
- Sorulara cevap verme
- Müşterilerle mesajlaşma
- Profil yönetimi

**Panel Erişimi:**
- `/lawyer` - Filament Lawyer Panel

### Admin (ADMIN)

**Yetkiler:**
- Tüm sistem yönetimi
- Kullanıcı yönetimi
- Soru yönetimi ve atama
- Paket yönetimi
- FAQ yönetimi
- Video yönetimi
- İstatistik ve raporlama

**Panel Erişimi:**
- `/admin` - Filament Admin Panel

## Hukuki Soru İşleyiş Akışı

### 1. Soru Oluşturma

**Route:** `POST /customer/questions`

**Controller:** `App\Http\Controllers\Customer\QuestionController@store`

**İşlem Adımları:**

1. **Validasyon**
   ```php
   - category_id: required
   - title: required
   - question_body: nullable (yazılı soru)
   - voice_file: nullable (sesli soru)
   - files.*: nullable (maksimum 4 dosya, 10MB)
   - Validasyon: En az bir içerik olmalı (yazı, ses veya dosya)
   ```

2. **Ses Dosyası İşleme** (varsa)
   - Dosya `storage/app/public/legal-questions/voices/` klasörüne kaydedilir
   - Dosya yolu `voice_path` olarak kaydedilir

3. **Ek Dosya İşleme** (varsa)
   - Her dosya için:
     - Dosya türü belirlenir (image, pdf, document)
     - `storage/app/public/legal-questions/files/` klasörüne kaydedilir
     - `question_files` tablosuna kayıt oluşturulur
     - Dosya bilgileri (original_name, mime_type, file_size) saklanır

4. **Soru Kaydı Oluşturma**
   ```php
   - user_id: Giriş yapan kullanıcı
   - category_id: Seçilen kategori
   - title: Soru başlığı
   - question_body: Yazılı soru içeriği (varsa)
   - voice_path: Ses dosyası yolu (varsa)
   - status: 'waiting_assignment'
   - asked_at: Şu anki zaman
   ```

### 2. Soru Durumları (Status)

**Durumlar:**
- `waiting_assignment`: Atama bekliyor
- `waiting_lawyer_answer`: Avukat cevabı bekliyor
- `answered`: Cevaplandı
- `closed`: Kapatıldı

**Durum Geçişleri:**

```
waiting_assignment 
    ↓ (Admin atama yapar)
waiting_lawyer_answer 
    ↓ (Avukat cevap verir)
answered 
    ↓ (Müşteri memnun olursa)
closed
```

### 3. Soru Atama Süreci

**Admin Paneli Üzerinden:**
1. Admin, soruları görüntüler
2. Uygun avukatı seçer
3. Soruyu avukata atar
4. Durum `waiting_lawyer_answer` olarak güncellenir
5. Avukat bildirim alır

### 4. Avukat Cevap Verme

**İşlem:**
1. Avukat atanan soruyu görüntüler
2. Cevap yazar
3. Cevap `legal_messages` tablosuna kaydedilir
4. Soru durumu `answered` olarak güncellenir
5. Müşteriye bildirim gönderilir

### 5. Müşteri Değerlendirme

**Puanlama:**
- Müşteri cevabı görüntüler
- 1-5 arası puan verir
- Düşük puan durumunda ikinci görüş talep edebilir

## Paket ve Kredi Sistemi

### Paket Yapısı

**Model:** `App\Models\Package`

**Alanlar:**
- `name`: Paket adı
- `description`: Paket açıklaması
- `question_credit`: Soru kredisi
- `voice_credit`: Ses kredisi
- `price`: Paket fiyatı

### Sipariş İşleme

**Route:** `POST /customer/packages/{package}/order`

**Controller:** `App\Http\Controllers\Customer\OrderController@store`

**İşlem Akışı:**

1. **Paket Seçimi**
   - Müşteri bir paket seçer
   - Paket detaylarını görüntüler

2. **Sipariş Oluşturma**
   ```php
   - user_id: Giriş yapan kullanıcı
   - package_id: Seçilen paket
   - total_amount: Paket fiyatı
   - status: 'pending'
   ```

3. **Ödeme İşlemi**
   - Ödeme entegrasyonu (gelecek geliştirme)
   - Şu an için otomatik onaylanıyor

4. **Kredi Aktarımı**
   - Paket kredileri kullanıcıya aktarılır
   - Sipariş durumu `completed` olur

### Kredi Kullanımı

**Soru Sorma:**
- Her yazılı soru: 1 kredi
- Her sesli soru: Ses kredisi kullanılır

**Kontrol:**
- Soru oluşturma sırasında kredi kontrolü yapılır
- Yetersiz kredi durumunda hata mesajı gösterilir

## Mesajlaşma Sistemi

### Mesaj Modeli

**Model:** `App\Models\LegalMessage`

**İlişkiler:**
- `question()`: Hangi soruya ait
- `sender()`: Gönderen kullanıcı

**Alanlar:**
- `legal_question_id`: Soru ID
- `sender_id`: Gönderen kullanıcı ID
- `message`: Mesaj içeriği
- `rating`: Puan (1-5)

### Mesaj Akışı

1. **Avukat Cevap Verir**
   - İlk mesaj avukat tarafından yazılır
   - Soru durumu güncellenir

2. **Müşteri Soru Sorar veya Cevap Yazar**
   - Müşteri ek mesaj yazabilir
   - Durum `waiting_lawyer_answer` olur

3. **Puanlama**
   - Müşteri avukat cevabını puanlar
   - Puan `rating` alanına kaydedilir

## Dosya Yönetimi

### Dosya Türleri

1. **Görsel Dosyalar** (image)
   - Formatlar: jpg, jpeg, png, gif, webp
   - MIME: image/*

2. **PDF Dosyaları** (pdf)
   - Format: pdf
   - MIME: application/pdf

3. **Döküman Dosyaları** (document)
   - Formatlar: doc, docx
   - MIME: application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document

### Dosya Depolama

**Yol Yapısı:**
```
storage/app/public/
├── legal-questions/
│   ├── voices/          # Ses dosyaları
│   └── files/           # Ek dosyalar
```

**Erişim:**
- Public disk kullanılır
- URL: `Storage::disk('public')->url($filePath)`
- Symbolic link: `php artisan storage:link`

### Dosya İşlemleri

**Upload:**
- Maksimum dosya sayısı: 4
- Maksimum dosya boyutu: 10MB
- Validasyon: MIME type ve extension kontrolü

**Görüntüleme:**
- Görseller: Modal içinde görüntülenir
- PDF: iframe içinde görüntülenir
- Dökümanlar: İndirilebilir

**İndirme:**
- Tüm dosyalar indirilebilir
- Orijinal dosya adı korunur

## Bildirim Sistemi

### Bildirim Tipleri

1. **Email Bildirimleri**
   - Soru atandığında avukata
   - Cevap verildiğinde müşteriye
   - Durum değişikliklerinde

2. **Push Bildirimleri** (gelecek geliştirme)
   - Mobil uygulama için

### Bildirim Logları

**Model:** `App\Models\NotificationLog`

**Alanlar:**
- `user_id`: Kullanıcı
- `type`: Bildirim tipi
- `title`: Başlık
- `message`: Mesaj
- `read_at`: Okunma zamanı

## Veritabanı Şeması

### Ana Tablolar

1. **users**
   - Kullanıcı bilgileri
   - Rol tabanlı erişim

2. **legal_questions**
   - Hukuki sorular
   - Durum takibi

3. **legal_messages**
   - Soru-cevap mesajları
   - Puanlama bilgileri

4. **question_files**
   - Soru ek dosyaları
   - Dosya metadata

5. **packages**
   - Paket tanımları

6. **customer_package_orders**
   - Sipariş kayıtları

7. **faqs**
   - Sıkça sorulan sorular

8. **videos**
   - Video içerikleri

### İlişkiler

```
User (1) ──┬── (N) LegalQuestion (user_id)
           ├── (N) CustomerPackageOrder
           └── (N) LegalMessage (sender_id)

LegalQuestion (1) ──┬── (N) LegalMessage
                    ├── (N) QuestionFile
                    ├── (1) Category
                    └── (1) User (assigned_lawyer_id)

Package (1) ── (N) CustomerPackageOrder
```

## API ve Route Yapısı

### Müşteri Route'ları

```
/customer/dashboard          - Dashboard
/customer/packages           - Paket listesi
/customer/packages/{id}      - Paket detayı
/customer/questions          - Soru listesi
/customer/questions/create   - Soru oluşturma
/customer/questions/{id}     - Soru detayı
/customer/faqs               - FAQ listesi
/customer/videos             - Video listesi
```

### Admin Route'ları

```
/admin                       - Filament Admin Panel
/admin/legal-questions       - Soru yönetimi
/admin/users                 - Kullanıcı yönetimi
/admin/packages              - Paket yönetimi
```

### Avukat Route'ları

```
/lawyer                      - Filament Lawyer Panel
```

## Güvenlik Özellikleri

### Authentication

- Laravel Sanctum/Default Auth
- Session tabanlı authentication
- "Beni hatırla" özelliği
- Password hashing (bcrypt)

### Authorization

- Role-based access control
- Policy sınıfları ile yetkilendirme
- Route middleware kontrolü

### Validation

- FormRequest sınıfları
- Client-side ve server-side validasyon
- CSRF token koruması

### File Security

- Dosya türü validasyonu
- Dosya boyutu limiti
- Güvenli dosya depolama
- Public erişim kontrolü

## Performans Optimizasyonları

### Database

- Eager loading (relationships)
- Query optimization
- Index kullanımı

### Caching

- View caching
- Route caching
- Config caching

### Assets

- CSS/JS minification
- Image optimization
- CDN entegrasyonu (gelecek)

## Deployment ve Bakım

### Environment Ayarları

- `.env` dosyası yapılandırması
- Database bağlantı ayarları
- Storage disk yapılandırması

### Gerekli Komutlar

```bash
# Storage link oluştur
php artisan storage:link

# Migration çalıştır
php artisan migrate

# Cache temizle
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Optimize
php artisan optimize
```

### Bakım Modu

```bash
php artisan down
php artisan up
```

## Sorun Giderme

### Yaygın Sorunlar

1. **Dosyalar görünmüyor**
   - `php artisan storage:link` çalıştırın
   - Storage permissions kontrol edin

2. **Route bulunamıyor**
   - `php artisan route:clear` çalıştırın
   - Route cache temizleyin

3. **View bulunamıyor**
   - `php artisan view:clear` çalıştırın
   - View cache temizleyin

4. **Permission hatası**
   - Storage klasörü izinlerini kontrol edin
   - `chmod -R 775 storage` komutu çalıştırın

## Gelecek Geliştirmeler

1. **Ödeme Entegrasyonu**
   - İyzico, PayTR gibi gateway'ler

2. **Push Bildirimleri**
   - Firebase Cloud Messaging

3. **Real-time Chat**
   - Laravel Echo + Pusher/WebSockets

4. **Mobil Uygulama**
   - API geliştirme
   - React Native veya Flutter

5. **Analytics**
   - Google Analytics
   - Custom dashboard

6. **SEO**
   - Meta tag yönetimi
   - Sitemap generation
   - Structured data

