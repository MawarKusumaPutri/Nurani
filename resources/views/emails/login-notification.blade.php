<x-mail::message>
# 🔔 Notifikasi Login Berhasil

Halo **{{ $user->name }}**,

Anda baru saja berhasil login ke sistem **{{ config('app.name') }}**.

## 📋 Detail Login:

**👤 Nama:** {{ $user->name }}  
**📧 Email:** {{ $user->email }}  
**👔 Role:** {{ ucfirst(str_replace('_', ' ', $user->role)) }}  
**🕐 Waktu Login:** {{ $loginTime->format('d F Y, H:i:s') }} WIB  
**🌐 IP Address:** {{ $ipAddress }}  
**💻 Device:** {{ \Illuminate\Support\Str::limit($userAgent, 100) }}

---

<x-mail::panel>
**⚠️ Keamanan Akun Anda:**

Jika Anda tidak melakukan login ini, segera:
- Ubah password akun Anda
- Hubungi administrator sistem
- Laporkan aktivitas mencurigakan
</x-mail::panel>

<x-mail::button :url="route('guru.dashboard')" color="success">
Masuk ke Dashboard
</x-mail::button>

Terima kasih,<br>
**{{ config('app.name') }}**  
*Sistem Manajemen Sekolah*

---

<small style="color: #666;">
Email ini dikirim secara otomatis oleh sistem. Mohon jangan membalas email ini.
</small>
</x-mail::message>
