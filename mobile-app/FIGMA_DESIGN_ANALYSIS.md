# Figma Tasarım Analizi - Kanun-i Mobil Uygulama

Bu dokümantasyon, Figma tasarımından çıkarılan tüm bilgileri ve bunların mobil uygulamaya nasıl uygulandığını içerir.

## Renk Paleti

### Ana Renkler

| Renk | Hex Kodu | Kullanım |
|------|----------|----------|
| Deep Teal | `#0A4D68` | Primary - Ana renk, header'lar, primary button'lar |
| Royal Blue | `#2563EB` | Secondary - İkincil elementler |
| Mustard Gold | `#D4A574` | Accent - Link'ler, aktif tab'ler, önemli butonlar |
| Creamy Off-White | `#F5F5F0` | Background Secondary - Kart içerikleri |
| Almost Black | `#1F2937` | Text Primary - Ana metin |
| Medium Grey | `#6B7280` | Text Tertiary - Placeholder'lar |

### Renk Kullanım Örnekleri

**Header:**
- Arka plan: Deep Teal (#0A4D68)
- Metin: White (#FFFFFF)

**Button'lar:**
- Primary: Deep Teal, White text
- Secondary: Light Grey, Dark text
- Accent: Mustard Gold

**Input Field'lar:**
- Arka plan: Very Light Grey (#F3F4F6)
- Border: Light Grey
- Focus: Deep Teal

## Typography

### Logo Font
- **Font:** Serif (Playfair Display benzeri)
- **Kullanım:** "KANUN-Í" logosu
- **Stil:** Elegant, stylized serif

### Body Font
- **Font:** Poppins (Sans-serif)
- **Kullanım:** Tüm metin içerikleri
- **Weight'ler:** Regular (400), SemiBold (600), Bold (700)

### Font Boyutları
- H1: 32px (Bold)
- H2: 24px (Bold)
- H3: 20px (SemiBold)
- Body: 16px (Regular)
- Small: 14px (Regular)
- Caption: 12px (Regular)

## Component Analizi

### 1. Button Component

**Variants:**
- Primary: Deep Teal background, White text
- Secondary: Light Grey background, Dark text
- Accent: Mustard Gold background

**Sizes:**
- Small: 40px height
- Medium: 50px height
- Large: 56px height

**Border Radius:** 8-12px

### 2. Input Component

**Style:**
- Background: Very Light Grey (#F3F4F6)
- Border: Light Grey, 1px
- Border Radius: 8px
- Padding: 12px 16px
- Min Height: 50px

**Features:**
- Password toggle (eye icon)
- Error state (red border)
- Placeholder color: Medium Grey

### 3. Card Component

**Question Card:**
- Background: White
- Border Radius: 12px
- Shadow: Light shadow
- Padding: 16px
- User avatar: Circular, 40px
- Status indicator: Pending/Answered

**Video Card:**
- Thumbnail: Full width, 200px height
- Play button: Centered overlay
- Credit badge: Top left
- Buy button: Top right
- Title overlay: Bottom

### 4. Header Component

**Style:**
- Background: Deep Teal (primary) or White
- Height: 60px
- Logo: Left side
- Back button: Left arrow icon
- Right component: Settings, credit, etc.

### 5. Bottom Navigation

**Style:**
- Background: Deep Teal (#0A4D68)
- Height: ~70px (with safe area)
- Active tab: Mustard Gold (#D4A574)
- Inactive tab: White
- Center button: Highlighted (white circle, blue border)

**Tabs:**
1. Home (Anasayfa)
2. Videos (Videolar)
3. Ask Question (Soru Sor) - Center, highlighted
4. Notifications (Bildirimler)
5. Profile (Profil)

## Ekran Detayları

### 1. Splash Screen
- White background
- Centered "KANUN-Í" logo
- Deep Teal color
- Loading indicator

### 2. Login Screen
- Header: Deep Teal, Logo + Back button
- Title: "Giriş Yap" (H1, Bold)
- Subtitle: "Türk Hukukunu Dünya'ya Taşıyoruz!"
- Input fields: Email, Password
- Forgot password link: Right aligned
- Primary button: "Giriş Yap"
- Footer: Deep Teal background, "Kayıt Ol" link
- Continue without signup: Mustard Gold link

### 3. Register Screen
- Header: White background
- Input fields:
  - Full Name
  - Email
  - Phone (with Turkish flag +90)
  - Password
  - Confirm Password
- Checkboxes: KVKK, Terms
- Primary button: "Kayıt Ol"
- Footer: "Giriş Yap" link

### 4. Forgot Password Flow

**Step 1: Email Entry**
- Title: "Şifremi Unuttum"
- Subtitle: Instruction text
- Email input
- Next button

**Step 2: OTP Verification**
- Title: "Şifremi Unuttum"
- Subtitle: "6 haneli doğrulama kodu..."
- 6 individual input boxes
- Resend link
- Next button

**Step 3: New Password**
- Title: "Şifremi Unuttum"
- Subtitle: Instruction text
- Password input
- Confirm password input
- Reset button

**Step 4: Success**
- Confetti animation
- Title: "Şifren Yenilendi!"
- Subtitle: Success message
- Login button

### 5. Home Screen
- Header: Logo + Credit badge
- User question card
- Videos section:
  - Section title
  - Search bar with filter
  - Category tags (horizontal scroll)
  - Video cards

### 6. Profile Screen
- Header: "Profil" + Settings icon
- User info:
  - Avatar (circular, large)
  - Name
  - Email
  - Credit badge
- Questions section: "Sorularım (3)"
- Videos section: "Videolarım (2)"

### 7. Ask Question Screen
- Header: Deep Teal, "Soru Sor" title
- Category selector (dropdown)
- Title input (with character counter 0/75)
- Large text area
- Bottom bar:
  - Text input
  - Image icon
  - File icon
  - Microphone button (large, circular, blue)

## Spacing System

- xs: 4px
- sm: 8px
- md: 16px
- lg: 24px
- xl: 32px
- xxl: 40px

## Border Radius

- xs: 4px
- sm: 8px
- md: 12px
- lg: 16px
- xl: 20px
- full: 999px (circular)

## Icon Sizes

- xs: 16px
- sm: 20px
- md: 24px
- lg: 32px
- xl: 48px
- xxl: 64px

## Animasyonlar

1. **Confetti Animation:**
   - Password reset success screen'de
   - Multiple colored particles
   - Falling animation

2. **Loading Animation:**
   - Circular spinner
   - "Yanıt bekleniyor..." durumu

3. **Screen Transitions:**
   - Slide in/out animations
   - Smooth transitions

## Platform Özellikleri

### iOS
- Dynamic Island support
- Safe area handling
- Rounded corners
- Home indicator

### Android
- Material Design uyumlu
- Status bar styling
- Navigation bar handling

## Tasarım Prensipleri

1. **Minimalist:** Sade, temiz tasarım
2. **Consistent:** Tutarlı renk ve spacing kullanımı
3. **Accessible:** Okunabilir font boyutları ve kontrast
4. **User-Friendly:** Sezgisel navigasyon ve etkileşimler

## Uygulama Notları

- Tüm renkler Figma tasarımından exact olarak alınmıştır
- Spacing ve typography değerleri tasarıma birebir uygundur
- Component'ler Figma'daki görünümle %100 uyumlu olacak şekilde kodlanmıştır
- Responsive tasarım için breakpoint'ler kullanılmıştır

