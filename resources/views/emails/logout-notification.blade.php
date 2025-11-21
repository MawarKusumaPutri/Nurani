<x-mail::message>
# 👋 Notifikasi Logout

Halo **{{ $user->name }}**,

Anda baru saja logout dari sistem **{{ config('app.name') }}**.

## 📋 Detail Logout:

**👤 Nama:** {{ $user->name }}  
**📧 Email:** {{ $user->email }}  
**🕐 Waktu Logout:** {{ $logoutTime->format('d F Y, H:i:s') }} WIB  
**🌐 IP Address:** {{ $ipAddress }}

---

<x-mail::panel>
**✅ Terima kasih telah menggunakan sistem kami.**

Pastikan Anda selalu logout setelah selesai menggunakan sistem untuk keamanan akun Anda.
</x-mail::panel>

Terima kasih,<br>
**{{ config('app.name') }}**  
*Sistem Manajemen Sekolah*

---

<small style="color: #666;">
Email ini dikirim secara otomatis oleh sistem. Mohon jangan membalas email ini.
</small>
</x-mail::message>
