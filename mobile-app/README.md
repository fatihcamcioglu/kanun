# Kanun-Í Mobil Uygulama

Kanun-Í platformunun React Native ile geliştirilmiş mobil uygulaması. Figma tasarımına birebir uyumlu, modern ve kullanıcı dostu bir mobil deneyim sunar.

## 🚀 Özellikler

### Authentication (Kimlik Doğrulama)
- ✅ Splash Screen
- ✅ Login (Giriş)
- ✅ Register (Kayıt)
- ✅ Forgot Password (Şifremi Unuttum)
  - Email/Telefon doğrulama
  - 6 haneli OTP doğrulama
  - Yeni şifre belirleme
  - Başarı ekranı (Confetti animasyonu)

### Ana Uygulama
- ✅ Home Screen (Ana Sayfa)
  - Kullanıcı soruları
  - Video bölümü
  - Kategori filtreleme
  - Kredi gösterimi
- ✅ Profile Screen (Profil)
  - Kullanıcı bilgileri
  - Sorularım listesi
  - Videolarım listesi
- ✅ Ask Question (Soru Sor)
  - Kategori seçimi
  - Soru başlığı (75 karakter sınırı)
  - Soru içeriği
  - Dosya ekleme (resim, döküman)
  - Sesli soru kaydetme

### Tasarım Sistemi
- ✅ Figma tasarımına birebir uyumlu renk paleti
- ✅ Poppins font ailesi (web ile uyumlu)
- ✅ Tutarlı spacing ve border radius sistemi
- ✅ Responsive component'ler
- ✅ Dark/Light theme desteği için hazır yapı

## 📁 Proje Yapısı

```
mobile-app/
├── src/
│   ├── components/          # Reusable component'ler
│   │   ├── Button/
│   │   ├── Input/
│   │   ├── Card/
│   │   ├── Header/
│   │   ├── BottomNav/
│   │   └── OTPInput/
│   ├── screens/             # Ekranlar
│   │   ├── Auth/           # Authentication ekranları
│   │   ├── Home/
│   │   ├── Profile/
│   │   └── AskQuestion/
│   ├── navigation/          # Navigation yapısı
│   ├── services/           # API servisleri
│   ├── theme/              # Tema dosyaları
│   │   ├── colors.ts
│   │   ├── typography.ts
│   │   └── spacing.ts
│   └── utils/              # Yardımcı fonksiyonlar
├── App.tsx                  # Ana uygulama dosyası
├── package.json
└── README.md
```

## 🛠️ Kurulum

### Gereksinimler
- Node.js >= 18
- React Native CLI
- Android Studio (Android için)
- Xcode (iOS için)

### Adımlar

1. **Projeyi klonlayın:**
```bash
cd mobile-app
```

2. **Bağımlılıkları yükleyin:**
```bash
npm install
# veya
yarn install
```

3. **iOS için pod'ları yükleyin (sadece iOS):**
```bash
cd ios && pod install && cd ..
```

4. **Android için:**
   - Android Studio'yu açın
   - Emulator veya fiziksel cihaz başlatın

5. **Uygulamayı çalıştırın:**

**iOS:**
```bash
npm run ios
```

**Android:**
```bash
npm run android
```

**Metro Bundler:**
```bash
npm start
```

## 🎨 Tema ve Tasarım

### Renk Paleti

Uygulama, Figma tasarımından çıkarılan renk paletini kullanır:

- **Primary:** `#0A4D68` (Deep Teal)
- **Secondary:** `#2563EB` (Royal Blue)
- **Accent:** `#D4A574` (Mustard Gold)
- **Background:** `#FFFFFF` (White)
- **Text Primary:** `#1F2937` (Almost Black)

Detaylı renk paleti için: `src/theme/colors.ts`

### Typography

- **Logo:** Playfair Display (Serif)
- **Headings & Body:** Poppins (Sans-serif)

Detaylı typography için: `src/theme/typography.ts`

## 📱 Ekranlar

### Authentication Flow
1. **Splash Screen** - Uygulama başlangıcı
2. **Login** - Kullanıcı girişi
3. **Register** - Yeni kullanıcı kaydı
4. **Forgot Password** - Şifre sıfırlama akışı
   - Email/Telefon girişi
   - OTP doğrulama (6 haneli)
   - Yeni şifre belirleme
   - Başarı ekranı

### Main App Flow
1. **Home** - Ana sayfa (sorular, videolar)
2. **Profile** - Kullanıcı profili
3. **Ask Question** - Soru sorma ekranı

## 🔧 Geliştirme

### Component Kullanımı

```tsx
import {Button} from '@components/Button';
import {Input} from '@components/Input';
import {theme} from '@theme';

<Button
  title="Giriş Yap"
  onPress={handleLogin}
  variant="primary"
  fullWidth
/>

<Input
  placeholder="E-posta"
  value={email}
  onChangeText={setEmail}
  showPasswordToggle
/>
```

### API Kullanımı

```tsx
import apiService from '@services/api';

// Login
const response = await apiService.login(email, password);

// Get questions
const questions = await apiService.getQuestions();

// Create question
const question = await apiService.createQuestion({
  category_id: 1,
  title: 'Soru başlığı',
  body: 'Soru içeriği',
});
```

## 📦 Kullanılan Paketler

### Core
- `react` & `react-native`
- `@react-navigation/native` - Navigation
- `react-native-gesture-handler` - Gesture handling
- `react-native-safe-area-context` - Safe area

### UI Components
- `react-native-vector-icons` - Iconlar
- `react-native-confetti-cannon` - Confetti animasyonu
- `react-native-otp-inputs` - OTP input

### Media
- `react-native-image-picker` - Resim seçme
- `react-native-document-picker` - Dosya seçme
- `react-native-audio-recorder-player` - Ses kaydı
- `react-native-video` - Video oynatma

### Utilities
- `axios` - HTTP client
- `@react-native-async-storage/async-storage` - Local storage

## 🔐 API Entegrasyonu

API base URL'i `src/services/api.ts` dosyasında tanımlanmıştır:

```typescript
const API_BASE_URL = __DEV__
  ? 'http://localhost:8000/api' // Development
  : 'https://kanun.test/api';   // Production
```

Token yönetimi otomatik olarak yapılmaktadır. Login sonrası token AsyncStorage'da saklanır ve her API isteğinde header'a eklenir.

## 🚦 Durum Yönetimi

Şu anda basit state management kullanılmaktadır. Gerekirse Redux veya Zustand eklenebilir.

## 📝 TODO

- [ ] Font dosyalarını ekle (Playfair Display, Poppins)
- [ ] Video player ekranı
- [ ] Notification ekranı
- [ ] Settings ekranı
- [ ] Push notification entegrasyonu
- [ ] Deep linking
- [ ] Offline support
- [ ] Unit testler
- [ ] E2E testler

## 🐛 Bilinen Sorunlar

- OTP input component'i henüz tam optimize edilmedi
- Voice recording henüz implement edilmedi
- Video player henüz tam entegre değil

## 📄 Lisans

Bu proje Kanun-Í platformu için özel olarak geliştirilmiştir.

## 👥 Geliştirici

Kanun-Í Development Team

## 📞 İletişim

Sorularınız için: support@kanuni.com

---

**Not:** Bu uygulama Figma tasarımından birebir uyarlanmıştır. Tüm component'ler ve ekranlar tasarım spesifikasyonlarına göre geliştirilmiştir.

