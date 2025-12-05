# Proje Standartları - kanun-i.com

## Genel Kurallar

### Kod Standartları
- PSR-12 kod standartlarına uygun kod yazılacak
- Tüm kod, class ve değişken isimleri İngilizce olacak
- Türkçe sadece kullanıcı arayüzünde (Blade templates, Filament labels) kullanılacak

### Mimari Prensipler
- **Thin Controllers**: Controller'lar ince olacak, business logic Service sınıflarında toplanacak
- **FormRequest Validation**: Tüm form validasyonları FormRequest sınıfları ile yapılacak
- **Repository Pattern**: Gerekli durumlarda Repository pattern kullanılabilir
- **Service Layer**: Tüm business logic Service sınıflarında olacak

### Dosya Organizasyonu
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controller'ları
│   │   ├── Customer/       # Müşteri controller'ları
│   │   └── Lawyer/         # Avukat controller'ları
│   ├── Requests/           # FormRequest sınıfları
│   └── Middleware/
├── Models/
├── Services/               # Business logic servisleri
├── Policies/               # Authorization policies
└── Notifications/          # Laravel Notification sınıfları
```

### Database Standartları
- Migration dosyaları düzenli ve açıklayıcı isimlerle oluşturulacak
- Her model için Factory ve Seeder yazılacak
- Foreign key'ler migration'larda tanımlanacak
- Soft deletes gerektiğinde kullanılacak

### Filament Standartları
- Her resource için Model + Migration + Factory + Policy + Filament Resource oluşturulacak
- Filament Resource'lar `app/Filament/Resources/` altında olacak
- Custom actions ve form components düzenli organize edilecek

### Frontend Standartları
- Tailwind CSS veya Bootstrap kullanılacak (karıştırılmayacak)
- Inline style kullanılmayacak, tüm CSS `style.css` veya Tailwind class'ları ile yapılacak
- Google Poppins font kullanılacak
- Blade template'ler `resources/views/` altında organize edilecek

### Güvenlik
- Tüm input'lar validate edilecek
- Authorization Policy'ler kullanılacak
- SQL injection'a karşı Eloquent ORM kullanılacak
- XSS koruması için Blade escaping kullanılacak

### Test Standartları
- Unit testler yazılacak (mümkün olduğunca)
- Feature testler kritik akışlar için yazılacak

### Naming Conventions
- **Models**: PascalCase, tekil (User, LegalQuestion)
- **Controllers**: PascalCase, çoğul (UsersController, LegalQuestionsController)
- **Services**: PascalCase, Service suffix (PaymentService, SMSService)
- **Policies**: PascalCase, Policy suffix (UserPolicy, LegalQuestionPolicy)
- **Migrations**: snake_case, timestamp prefix
- **Routes**: kebab-case veya resource routes

### Git Standartları
- Commit mesajları açıklayıcı olacak
- Feature branch'ler kullanılacak
- .env dosyası commit edilmeyecek

### Dokümantasyon
- Kod içi yorumlar İngilizce olacak
- README.md güncel tutulacak
- API dokümantasyonu (ileride) yazılacak

