# .env Dosyası Mail Ayarları Düzenleme

Google Workspace uygulama şifresi boşluk içerdiği için `.env` dosyanızda şu şekilde düzenlemeniz gerekiyor:

## Adım 1: .env Dosyasını Açın

`.env` dosyanızı bir metin editörü ile açın (Notepad++, VS Code, vb.)

## Adım 2: Mail Ayarlarını Bulun veya Ekleyin

`.env` dosyasında aşağıdaki satırları bulun veya ekleyin:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@kanun-i.com
MAIL_PASSWORD="uejn jwlv cnhd xbuq"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@kanun-i.com
MAIL_FROM_NAME="Kanun-i"
```

## ÖNEMLİ: Şifreyi Tırnak İçine Alın!

**MAIL_PASSWORD** satırında şifreyi **çift tırnak içine almalısınız** çünkü boşluk içeriyor:

✅ **DOĞRU:**
```
MAIL_PASSWORD="uejn jwlv cnhd xbuq"
```

❌ **YANLIŞ:**
```
MAIL_PASSWORD=uejn jwlv cnhd xbuq
```

## Alternatif: Boşluksuz Şifre

Eğer tırnak kullanmak istemezseniz, şifredeki boşlukları kaldırabilirsiniz:

```
MAIL_PASSWORD=uejnjwlvcnhdxbuq
```

## Adım 3: Dosyayı Kaydedin

Dosyayı kaydedin ve kapatın.

## Adım 4: Config'i Temizleyin

Terminal'de şu komutu çalıştırın:

```bash
php artisan config:clear
```

## Test

Artık mail gönderimi çalışmalı! Test etmek için bir avukat ataması yapın veya bir soru cevaplayın.

