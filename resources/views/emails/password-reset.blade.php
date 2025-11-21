<x-mail::message>
# 🔑 Reset Password

Halo **{{ $user->name }}**,

Anda telah meminta untuk mereset password akun Anda di sistem **{{ config('app.name') }}**.

## 📋 Informasi:

**👤 Nama:** {{ $user->name }}  
**📧 Email:** {{ $user->email }}  
**👔 Role:** {{ ucfirst(str_replace('_', ' ', $user->role)) }}

---

<x-mail::panel>
**⚠️ Keamanan:**

Jika Anda tidak meminta reset password ini, abaikan email ini. Password Anda tidak akan berubah.
</x-mail::panel>

<x-mail::button :url="$resetUrl" color="primary">
Reset Password
</x-mail::button>

**Atau copy link berikut ke browser:**
{{ $resetUrl }}

**⚠️ Link ini akan kadaluarsa dalam 60 menit.**

---

Terima kasih,<br>
**{{ config('app.name') }}**  
*Sistem Manajemen Sekolah*

---

<small style="color: #666;">
Email ini dikirim secara otomatis oleh sistem. Mohon jangan membalas email ini.
</small>
</x-mail::message>

