# SMTP Mail Ayarları

Google Workspace kullandığınız için uygulama şifresi boşluk içeriyor. `.env` dosyanızda aşağıdaki satırları **manuel olarak** kontrol edin ve düzenleyin:

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

**ÖNEMLİ:** 
- Google Workspace uygulama şifresi boşluk içerdiği için `MAIL_PASSWORD` değerini **çift tırnak içine almalısınız**
- Alternatif olarak şifredeki boşlukları kaldırabilirsiniz: `uejnjwlvcnhdxbuq`

Doğru format örnekleri:

**Seçenek 1 (Tırnak içinde - ÖNERİLEN):**
```
MAIL_PASSWORD="uejn jwlv cnhd xbuq"
```

**Seçenek 2 (Boşluksuz):**
```
MAIL_PASSWORD=uejnjwlvcnhdxbuq
```

Ayarlandıktan sonra:
1. `php artisan config:clear` komutunu çalıştırın
2. Mail gönderimini test edin

**Not:** Eğer hala hata alıyorsanız, `.env` dosyasında `MAIL_PASSWORD` satırını silip yeniden ekleyin.

