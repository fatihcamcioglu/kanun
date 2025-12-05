# Kanun-i Mobil Uygulama - Expo Kurulum Rehberi

## 🚀 Hızlı Başlangıç

### 1. Ön Gereksinimler
- Node.js >= 18.x kurulu olmalı
- npm veya yarn paket yöneticisi

Kontrol etmek için:
```bash
node --version
npm --version
```

### 2. Bağımlılıkları Yükle
```bash
cd mobile-app
npm install
```

### 3. Uygulamayı Başlat
```bash
npx expo start
```

## 📱 Cihazda Test Etme (Expo Go)

### Telefonunuza Expo Go Uygulamasını İndirin:
- **Android:** [Google Play Store](https://play.google.com/store/apps/details?id=host.exp.exponent)
- **iOS:** [App Store](https://apps.apple.com/app/expo-go/id982107779)

### Uygulamayı Başlatın:
```bash
npx expo start
```

### QR Kodu Tarayın:
Terminal'de görünen QR kodu telefonunuzla tarayın. Uygulama anında açılacak!

## 💻 Geliştirme Seçenekleri

### Web'de Çalıştır:
```bash
npx expo start --web
```

### Android Emulator'da Çalıştır:
```bash
npx expo start --android
```

### iOS Simulator'da Çalıştır (sadece macOS):
```bash
npx expo start --ios
```

## 📁 Proje Yapısı

```
mobile-app/
├── App.tsx                 # Ana uygulama bileşeni
├── app.json               # Expo yapılandırması
├── package.json           # Bağımlılıklar
├── babel.config.js        # Babel yapılandırması
├── tsconfig.json          # TypeScript yapılandırması
├── assets/                # Görsel kaynaklar
│   ├── icon.png          # Uygulama ikonu
│   ├── splash.png        # Açılış ekranı
│   ├── adaptive-icon.png # Android adaptive icon
│   └── fonts/            # Font dosyaları
└── src/
    ├── components/       # Yeniden kullanılabilir bileşenler
    ├── screens/          # Ekran bileşenleri
    ├── navigation/       # Navigasyon yapılandırması
    ├── services/         # API servisleri
    ├── theme/            # Tema ve stiller
    └── utils/            # Yardımcı fonksiyonlar
```

## 🔧 Yapılandırma

### API Base URL
`src/services/api.ts` dosyasında API URL'ini güncelleyin:
```typescript
const API_BASE_URL = __DEV__
  ? 'http://YOUR_LOCAL_IP:8000/api' // Development
  : 'https://kanun.test/api';       // Production
```

### Font Dosyaları
Aşağıdaki font dosyalarını `assets/fonts/` klasörüne ekleyin:
- Poppins-Regular.ttf
- Poppins-SemiBold.ttf
- Poppins-Bold.ttf
- PlayfairDisplay-Bold.ttf

Font dosyalarını Google Fonts'tan indirebilirsiniz:
- [Poppins](https://fonts.google.com/specimen/Poppins)
- [Playfair Display](https://fonts.google.com/specimen/Playfair+Display)

## 📦 Production Build

### EAS Build Kurulumu (İlk seferlik):
```bash
npm install -g eas-cli
eas login
eas build:configure
```

### Android APK/AAB Build:
```bash
eas build --platform android --profile preview  # APK
eas build --platform android --profile production  # AAB (Play Store için)
```

### iOS Build (Apple Developer Account gerekli):
```bash
eas build --platform ios --profile production
```

## 🔄 Over-the-Air Updates

Expo'nun en güçlü özelliklerinden biri OTA güncellemeler:
```bash
eas update --branch production --message "Bug fix"
```

## 🛠️ Sorun Giderme

### Metro Cache Temizleme:
```bash
npx expo start --clear
```

### Bağımlılık Sorunları:
```bash
rm -rf node_modules
npm install
```

### Expo Doctor:
```bash
npx expo-doctor
```

## 📚 Faydalı Komutlar

| Komut | Açıklama |
|-------|----------|
| `npx expo start` | Development server başlat |
| `npx expo start --clear` | Cache temizleyerek başlat |
| `npx expo start --web` | Web'de çalıştır |
| `npx expo-doctor` | Proje sağlık kontrolü |
| `eas build --platform all` | iOS ve Android build |
| `eas update` | OTA güncelleme yayınla |

## 🔗 Faydalı Linkler

- [Expo Dokümantasyonu](https://docs.expo.dev/)
- [React Navigation](https://reactnavigation.org/docs/getting-started)
- [Expo SDK API](https://docs.expo.dev/versions/latest/)
- [EAS Build](https://docs.expo.dev/build/introduction/)

## 📞 Destek

Sorunlarınız için: support@kanuni.com
