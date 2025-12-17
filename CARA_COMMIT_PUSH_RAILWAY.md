# 🚀 Cara Commit & Push untuk Deploy Migrations ke Railway

## 📍 Lokasi: PowerShell (Terminal di VS Code/Cursor)

### Langkah-Langkah:

1. **Buka PowerShell di Cursor/VS Code:**
   - Tekan `Ctrl + `` (backtick) untuk buka terminal
   - Atau klik menu **Terminal** → **New Terminal**
   - Pastikan PowerShell sudah terpilih (bukan Command Prompt)

2. **Pastikan Anda di Folder Project:**
   ```powershell
   cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
   ```

3. **Cek Status Git:**
   ```powershell
   git status
   ```
   - Harus muncul `railway.json` sebagai file yang modified

4. **Add File ke Staging:**
   ```powershell
   git add railway.json
   ```

5. **Commit Perubahan:**
   ```powershell
   git commit -m "Add migrations to start command"
   ```

6. **Push ke GitHub:**
   ```powershell
   git push
   ```

7. **Tunggu Railway Auto-Deploy:**
   - Railway akan otomatis detect perubahan
   - Auto rebuild dan restart
   - Migrations akan jalan saat start
   - Cek tab **"Deployments"** di Railway untuk lihat progress

---

## ✅ Contoh Output yang Benar:

```powershell
PS D:\Praktikum DWBI\xampp\htdocs\nurani> git status
On branch master
Changes not staged for commit:
  modified:   railway.json

PS D:\Praktikum DWBI\xampp\htdocs\nurani> git add railway.json

PS D:\Praktikum DWBI\xampp\htdocs\nurani> git commit -m "Add migrations to start command"
[master abc1234] Add migrations to start command
 1 file changed, 1 insertion(+), 1 deletion(-)

PS D:\Praktikum DWBI\xampp\htdocs\nurani> git push
Enumerating objects: 5, done.
Counting objects: 100% (5/5), done.
Writing objects: 100% (3/3), 312 bytes | 312.00 KiB/s, done.
To https://github.com/username/repo.git
   abc1234..def5678  master -> master
```

---

## ⚠️ Jika Ada Error:

### Error: "fatal: not a git repository"
**Solusi:**
```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
```

### Error: "Please tell me who you are"
**Solusi:**
```powershell
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
```

### Error: "Authentication failed"
**Solusi:**
- Pastikan sudah login ke GitHub
- Atau gunakan Personal Access Token

---

## 🎯 Setelah Push Selesai:

1. **Buka Railway Dashboard**
2. **Klik service "web"** → tab **"Deployments"**
3. **Tunggu deployment baru muncul** (akan otomatis trigger)
4. **Cek logs** untuk lihat migrations berjalan
5. **Setelah migrations selesai**, edit `railway.json` lagi untuk hapus migrations dari start command

---

**Jalankan perintah di PowerShell! 🚀**

