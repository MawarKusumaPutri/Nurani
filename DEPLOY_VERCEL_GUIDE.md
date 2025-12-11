# Panduan Deploy Frontend ke Vercel

## Catatan Penting
- **Vercel** cocok untuk: Static sites, React, Vue, Next.js, Angular, Svelte, dll
- **Laravel (PHP)** biasanya **TIDAK** di-deploy ke Vercel
- Jika aplikasi ini adalah Laravel full-stack, pertimbangkan alternatif seperti:
  - **Backend Laravel**: Railway, Render, DigitalOcean, atau VPS
  - **Frontend terpisah**: Vercel (jika ada frontend framework terpisah)

---

## Langkah-langkah Deploy Frontend ke Vercel

### 1. Persiapan

#### A. Install Vercel CLI (Opsional)
```bash
npm install -g vercel
```

#### B. Pastikan Project Siap
- Pastikan ada `package.json` dengan script build
- Pastikan ada build output folder (biasanya `dist`, `build`, atau `.next`)

---

### 2. Deploy via Vercel Dashboard (Recommended)

#### Langkah 1: Buat Akun Vercel
1. Kunjungi [vercel.com](https://vercel.com)
2. Sign up dengan GitHub, GitLab, atau Bitbucket
3. Verifikasi email

#### Langkah 2: Import Project
1. Login ke Vercel Dashboard
2. Klik **"Add New..."** → **"Project"**
3. Pilih repository dari GitHub/GitLab/Bitbucket
4. Atau drag & drop folder project

#### Langkah 3: Konfigurasi Project

**Untuk React/Vue/Angular:**
```json
{
  "buildCommand": "npm run build",
  "outputDirectory": "dist",
  "installCommand": "npm install"
}
```

**Untuk Next.js:**
- Vercel otomatis detect Next.js
- Tidak perlu konfigurasi tambahan

**Untuk Static HTML:**
```json
{
  "outputDirectory": "public"
}
```

#### Langkah 4: Environment Variables (jika perlu)
1. Di project settings → **Environment Variables**
2. Tambahkan variables:
   - `VITE_API_URL` atau `REACT_APP_API_URL`
   - `API_BASE_URL`
   - dll

#### Langkah 5: Deploy
1. Klik **"Deploy"**
2. Tunggu proses build selesai
3. Dapatkan URL: `https://your-project.vercel.app`

---

### 3. Deploy via Vercel CLI

#### Langkah 1: Login
```bash
vercel login
```

#### Langkah 2: Deploy
```bash
# Deploy ke production
vercel

# Deploy ke preview
vercel --prod
```

#### Langkah 3: Follow Prompts
- Set up and deploy? **Yes**
- Which scope? Pilih akun/organisasi
- Link to existing project? **No** (untuk pertama kali)
- Project name? Masukkan nama project
- Directory? `.` (current directory)
- Override settings? **No**

---

### 4. Konfigurasi Khusus

#### A. File `vercel.json` (Opsional)

**Untuk SPA (Single Page Application):**
```json
{
  "version": 2,
  "builds": [
    {
      "src": "package.json",
      "use": "@vercel/static-build",
      "config": {
        "distDir": "dist"
      }
    }
  ],
  "routes": [
    {
      "src": "/(.*)",
      "dest": "/index.html"
    }
  ]
}
```

**Untuk Next.js:**
```json
{
  "version": 2,
  "buildCommand": "npm run build",
  "devCommand": "npm run dev",
  "installCommand": "npm install",
  "framework": "nextjs"
}
```

#### B. Environment Variables
Buat file `.env.production` atau set di Vercel Dashboard:
```
VITE_API_URL=https://your-api.com
REACT_APP_API_URL=https://your-api.com
```

---

### 5. Custom Domain (Opsional)

1. Di Vercel Dashboard → Project → **Settings** → **Domains**
2. Tambahkan domain: `yourdomain.com`
3. Follow instruksi untuk setup DNS:
   - Tambahkan CNAME record: `@` → `cname.vercel-dns.com`
   - Atau A record: `@` → IP Vercel

---

### 6. Continuous Deployment

Vercel otomatis deploy setiap kali:
- Push ke branch `main` → Production
- Push ke branch lain → Preview deployment
- Pull Request → Preview deployment

---

## Contoh untuk Framework Populer

### React + Vite
```bash
# Build command
npm run build

# Output directory
dist
```

### Vue.js
```bash
# Build command
npm run build

# Output directory
dist
```

### Next.js
```bash
# Build command (otomatis)
npm run build

# Output directory (otomatis)
.next
```

### Angular
```bash
# Build command
ng build --prod

# Output directory
dist/your-app-name
```

---

## Troubleshooting

### Error: Build Failed
- Cek `package.json` script build
- Pastikan semua dependencies terinstall
- Cek build logs di Vercel Dashboard

### Error: 404 Not Found (SPA)
- Tambahkan `vercel.json` dengan rewrite rules
- Pastikan semua routes redirect ke `index.html`

### Error: Environment Variables
- Pastikan set di Vercel Dashboard
- Restart deployment setelah menambah variables

### Error: API Connection
- Pastikan API URL benar
- Cek CORS settings di backend
- Gunakan environment variables untuk API URL

---

## Tips

1. **Preview Deployments**: Setiap PR mendapat preview URL
2. **Analytics**: Aktifkan di Vercel Dashboard untuk monitoring
3. **Speed Insights**: Aktifkan untuk performance monitoring
4. **Edge Functions**: Gunakan untuk serverless functions
5. **Image Optimization**: Vercel otomatis optimize images

---

## Alternatif untuk Laravel Backend

Jika Anda perlu deploy Laravel backend:

1. **Railway** (railway.app)
   - Support PHP/Laravel
   - Auto-deploy dari GitHub
   - Free tier available

2. **Render** (render.com)
   - Support PHP/Laravel
   - Auto-deploy
   - Free tier available

3. **DigitalOcean App Platform**
   - Support PHP/Laravel
   - Auto-scaling
   - Paid (mulai $5/bulan)

4. **VPS** (DigitalOcean, Linode, dll)
   - Full control
   - Install manual
   - Lebih kompleks

---

## Next Steps

1. ✅ Buat akun Vercel
2. ✅ Import project
3. ✅ Konfigurasi build settings
4. ✅ Set environment variables
5. ✅ Deploy
6. ✅ Test di production URL
7. ✅ Setup custom domain (opsional)

---

**Need Help?**
- Vercel Docs: https://vercel.com/docs
- Vercel Support: support@vercel.com
- Community: https://github.com/vercel/vercel/discussions

