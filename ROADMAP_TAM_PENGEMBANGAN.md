# ROADMAP EVALUATION TAM - TMS NURANI
## Terintegrasi dengan 4 Tahap Pengembangan Sistem

---

## 📊 OVERVIEW INTEGRASI TAM DENGAN PENGEMBANGAN

```
TAHAP 1: PERSIAPAN & ANALISIS (Minggu 1-4)
    ↓ TAM: Baseline & External Variables Assessment
    
TAHAP 2: PENGEMBANGAN SISTEM (Minggu 5-12)
    ↓ TAM: Iterative Usability Testing (PEOU Focus)
    
TAHAP 3: UJI SISTEM & VALIDASI (Minggu 13-14)
    ↓ TAM: Pre-Implementation TAM Survey
    
TAHAP 4: DEPLOYMENT & GO LIVE (Minggu 15-16)
    ↓ TAM: Full TAM Evaluation (All Constructs)
    
POST GO LIVE: EVALUASI BERKELANJUTAN (Minggu 17+)
    ↓ TAM: Sustained Usage & Impact Assessment
```

---

## 🎯 TAHAP 1: PERSIAPAN DAN ANALISIS (Minggu 1-4)

### **Aktivitas Pengembangan:**
- ✅ Wawancara stakeholder (Kepala Sekolah, Guru, TU)
- ✅ Empathy Map untuk identifikasi kebutuhan
- ✅ Fishbone Diagram untuk analisis masalah
- ✅ Desain awal dengan Balsamiq

### **🔍 EVALUASI TAM: BASELINE ASSESSMENT**

#### **Tujuan TAM:**
Mengukur kondisi awal dan faktor-faktor yang akan mempengaruhi penerimaan sistem

#### **Fokus Konstruk TAM:**
**EXTERNAL VARIABLES** - Mengidentifikasi faktor eksternal yang mempengaruhi adopsi

---

### **A. EXTERNAL VARIABLES ASSESSMENT**

#### **1. USER CHARACTERISTICS (Karakteristik Pengguna)**

**Metode Pengumpulan Data:**
- Kuesioner demografis
- Wawancara terstruktur
- Observasi

**Data yang Dikumpulkan:**

| Aspek | Indikator | Metode |
|-------|-----------|--------|
| **Usia & Pendidikan** | Distribusi usia, tingkat pendidikan | Kuesioner |
| **Computer Self-Efficacy** | Tingkat kemampuan teknologi (1-5) | Kuesioner + Observasi |
| **Prior Experience** | Pengalaman sistem digital sebelumnya | Wawancara |
| **Technology Anxiety** | Tingkat kecemasan terhadap teknologi | Kuesioner |
| **Attitude Toward Change** | Keterbukaan terhadap perubahan | Wawancara |

**Contoh Pertanyaan Kuesioner:**
1. Seberapa sering Anda menggunakan komputer/laptop untuk pekerjaan? (1-5)
2. Apakah Anda pernah menggunakan sistem digital untuk manajemen pembelajaran? (Ya/Tidak)
3. Seberapa nyaman Anda belajar teknologi baru? (1-5)
4. Apakah Anda merasa cemas ketika harus menggunakan sistem baru? (1-5)

**Output:**
- Profil pengguna per role (Guru, TU, Kepsek)
- Identifikasi early adopters vs laggards
- Tingkat kesiapan teknologi organisasi

---

#### **2. ORGANIZATIONAL FACTORS (Faktor Organisasi)**

**Data yang Dikumpulkan:**

| Aspek | Indikator | Metode |
|-------|-----------|--------|
| **Management Support** | Dukungan Kepala Sekolah terhadap digitalisasi | Wawancara Kepsek |
| **Infrastructure** | Ketersediaan komputer, internet, perangkat | Observasi + Dokumentasi |
| **Culture** | Budaya organisasi terhadap inovasi | Wawancara + Observasi |
| **Resources** | Budget, waktu, SDM untuk implementasi | Wawancara Kepsek + TU |

**Contoh Pertanyaan Wawancara:**
- Bagaimana dukungan pimpinan terhadap penggunaan sistem digital?
- Apakah ada kebijakan sekolah yang mendukung digitalisasi?
- Bagaimana kesiapan infrastruktur teknologi di sekolah?

**Output:**
- Assessment kesiapan organisasi
- Identifikasi enablers & barriers
- Rekomendasi support yang dibutuhkan

---

#### **3. TASK CHARACTERISTICS (Karakteristik Tugas)**

**Metode:** Empathy Map + Fishbone Diagram

**Data yang Dikumpulkan:**

**GURU:**
- Kompleksitas tugas mengajar saat ini
- Pain points dalam manajemen materi & kuis
- Waktu yang dihabiskan untuk administrasi
- Kebutuhan spesifik per mata pelajaran

**TU:**
- Kompleksitas manajemen data siswa/guru
- Proses manual yang memakan waktu
- Frekuensi update data
- Kebutuhan reporting

**KEPALA SEKOLAH:**
- Kebutuhan monitoring & supervisi
- Jenis laporan yang dibutuhkan
- Frekuensi review data

**Output:**
- Task analysis per role
- Identifikasi task-technology fit
- Prioritas fitur berdasarkan kebutuhan

---

#### **4. SYSTEM CHARACTERISTICS (Karakteristik Sistem - Ekspektasi)**

**Metode:** Desain Balsamiq + Feedback Session

**Data yang Dikumpulkan:**

| Aspek | Pertanyaan | Metode |
|-------|-----------|--------|
| **Expected Usefulness** | Fitur apa yang paling dibutuhkan? | Wawancara + Empathy Map |
| **Expected Ease of Use** | Seperti apa sistem yang mudah menurut Anda? | Balsamiq Review |
| **Interface Preference** | Preferensi tampilan (simple vs rich features) | Balsamiq Review |
| **Feature Priority** | Fitur mana yang paling penting? | Ranking Exercise |

**Output:**
- Ekspektasi PU & PEOU (baseline)
- Prioritas fitur
- Design requirements

---

### **📋 DELIVERABLES TAHAP 1:**

1. **Baseline TAM Report:**
   - User profiling (demographics, tech readiness)
   - Organizational readiness assessment
   - Task-technology fit analysis
   - Expected PU & PEOU scores

2. **External Variables Dashboard:**
   - Visualisasi karakteristik pengguna
   - Readiness score per user group
   - Risk factors identification

3. **Design Requirements Document:**
   - Prioritized features berdasarkan kebutuhan
   - UI/UX guidelines berdasarkan user preference
   - Accessibility requirements

---

## 🛠️ TAHAP 2: PENGEMBANGAN SISTEM (Minggu 5-12)

### **Aktivitas Pengembangan:**
- Minggu 5: Setup Foundation + Figma Design
- Minggu 6: Prototype Figma
- Minggu 7-9: Development Kepala Sekolah Module
- Minggu 8-9: Development Guru Module
- Minggu 10: Development TU Module
- Minggu 11-12: Fitur Umum (Notifikasi, Profil, Email)

### **🔍 EVALUASI TAM: ITERATIVE USABILITY TESTING**

#### **Tujuan TAM:**
Memastikan sistem yang dikembangkan mudah digunakan (PEOU) dan berguna (PU)

#### **Fokus Konstruk TAM:**
**PERCEIVED EASE OF USE (PEOU)** - Evaluasi kemudahan penggunaan di setiap iterasi

---

### **EVALUASI PER MINGGU:**

#### **MINGGU 6: PROTOTYPE FIGMA TESTING**

**Metode:** Think-Aloud Protocol + Usability Testing

**Aktivitas:**
1. **Rekrut 2-3 user per role** untuk testing
2. **Berikan task scenarios:**
   - Guru: "Coba upload materi pembelajaran"
   - TU: "Coba tambah data siswa baru"
   - Kepsek: "Coba lihat laporan aktivitas guru"
3. **Observasi & catat:**
   - Waktu menyelesaikan task
   - Jumlah error/kesulitan
   - Feedback verbal
   - Ekspresi frustasi/kepuasan

**Metrik PEOU:**
- Task completion rate (%)
- Time on task (detik)
- Error rate (jumlah kesalahan)
- Subjective ease rating (1-5)

**Output:**
- Usability issues list
- UI/UX improvement recommendations
- Revised prototype

---

#### **MINGGU 7-10: DEVELOPMENT TESTING (Per Module)**

**Setiap module selesai → Mini Usability Test**

**Contoh: Minggu 7 - Dashboard Kepala Sekolah**

**Test Scenarios:**
1. Login ke sistem
2. Lihat statistik overview
3. Klik chart untuk detail
4. Akses quick menu
5. Baca notifikasi

**Metrik PEOU:**
| Metrik | Target | Actual | Status |
|--------|--------|--------|--------|
| Task completion | ≥90% | ___ | ___ |
| Avg time per task | <30s | ___ | ___ |
| Error rate | <10% | ___ | ___ |
| Ease rating | ≥4/5 | ___ | ___ |

**Quick Survey (5 pertanyaan):**
1. Dashboard mudah dipahami (1-5)
2. Navigasi jelas (1-5)
3. Informasi yang ditampilkan berguna (1-5)
4. Saya bisa menyelesaikan task dengan mudah (1-5)
5. Saya puas dengan tampilan dashboard (1-5)

**Output per Module:**
- PEOU score per module
- Bug list & fixes
- Feature refinement

---

#### **MINGGU 11-12: INTEGRATION TESTING**

**Tujuan:** Test keseluruhan sistem dengan real user flow

**Metode:** End-to-End Testing dengan 5-7 users

**Skenario Lengkap:**

**GURU:**
1. Login → Dashboard
2. Cek jadwal hari ini
3. Upload materi baru (file + video)
4. Buat kuis pilihan ganda
5. Lihat notifikasi
6. Edit profil

**TU:**
1. Login → Dashboard
2. Tambah data siswa baru
3. Upload foto siswa
4. Edit data guru
5. Export data siswa ke Excel
6. Lihat statistik

**KEPALA SEKOLAH:**
1. Login → Dashboard
2. Lihat laporan aktivitas guru
3. Filter laporan per periode
4. Export laporan PDF
5. Lihat detail profil guru

**Metrik PEOU (Comprehensive):**
- System Usability Scale (SUS) score (target ≥70)
- Task success rate (target ≥85%)
- User satisfaction (target ≥4/5)

**Kuesioner PEOU (10 item):**
1. TMS mudah dipelajari
2. Navigasi TMS jelas
3. Saya cepat terampil menggunakan TMS
4. TMS mudah digunakan
5. Interaksi dengan TMS mudah dimengerti
6. Fitur-fitur mudah ditemukan
7. Tidak perlu bantuan untuk menggunakan TMS
8. Tidak ada kebingungan saat menggunakan TMS
9. Saya percaya diri menggunakan TMS
10. TMS tidak memerlukan banyak usaha mental

---

### **📋 DELIVERABLES TAHAP 2:**

1. **Usability Test Reports (per module):**
   - PEOU scores per module
   - Issues & resolutions
   - Improvement changelog

2. **System Usability Scale (SUS) Report:**
   - Overall SUS score
   - Benchmark comparison
   - Usability grade

3. **Iterative Improvement Log:**
   - Before-after comparisons
   - Design decisions rationale
   - User feedback integration

---

## ✅ TAHAP 3: UJI SISTEM DAN VALIDASI (Minggu 13-14)

### **Aktivitas Pengembangan:**
- Pengujian fungsional sistem
- Validasi dengan stakeholder
- Bug fixing & refinement

### **🔍 EVALUASI TAM: PRE-IMPLEMENTATION SURVEY**

#### **Tujuan TAM:**
Mengukur ekspektasi pengguna sebelum go live (PU, PEOU, ATU, BI)

#### **Fokus Konstruk TAM:**
**SEMUA KONSTRUK** - Baseline sebelum implementasi penuh

---

### **MINGGU 13: COMPREHENSIVE TAM SURVEY**

**Metode:** Online Questionnaire (Google Form) + Wawancara

**Responden:** SEMUA calon pengguna (100% target)
- Semua Guru (~20-30 orang)
- Semua TU (~2-3 orang)
- Kepala Sekolah (1 orang)

**Kuesioner TAM Lengkap (25 item):**

#### **A. PERCEIVED USEFULNESS (5 item)**
1. TMS akan meningkatkan efisiensi pekerjaan saya
2. TMS akan memudahkan saya menyelesaikan tugas
3. TMS akan bermanfaat untuk pekerjaan saya
4. TMS akan meningkatkan produktivitas saya
5. TMS akan membantu saya bekerja lebih cepat

#### **B. PERCEIVED EASE OF USE (5 item)**
1. TMS mudah dipelajari
2. Navigasi TMS jelas dan mudah dipahami
3. Saya mudah menjadi terampil menggunakan TMS
4. TMS mudah digunakan
5. Interaksi dengan TMS jelas dan mudah dimengerti

#### **C. ATTITUDE TOWARD USING (5 item)**
1. Menggunakan TMS adalah ide yang baik
2. Saya senang akan menggunakan TMS
3. Bekerja dengan TMS akan menyenangkan
4. Saya merasa nyaman akan menggunakan TMS
5. Saya puas dengan TMS yang telah dikembangkan

#### **D. BEHAVIORAL INTENTION (5 item)**
1. Saya berniat menggunakan TMS setelah go live
2. Saya akan merekomendasikan TMS kepada rekan kerja
3. Saya berencana menggunakan TMS secara rutin
4. Saya akan menggunakan semua fitur TMS
5. Saya berkomitmen menggunakan TMS jangka panjang

#### **E. EXTERNAL VARIABLES (5 item)**
1. Saya mendapat training yang cukup tentang TMS
2. Dukungan teknis tersedia jika saya butuh bantuan
3. Kepala Sekolah mendukung penggunaan TMS
4. Rekan kerja saya juga akan menggunakan TMS
5. Infrastruktur (komputer, internet) memadai

**Skala:** 1 = Sangat Tidak Setuju, 5 = Sangat Setuju

---

### **MINGGU 14: WAWANCARA MENDALAM & FGD**

**Wawancara (30-45 menit per orang):**
- 5 Guru (representatif berbagai mata pelajaran)
- 2 TU
- 1 Kepala Sekolah

**Pertanyaan Kunci:**
1. Apa ekspektasi Anda terhadap TMS?
2. Fitur apa yang paling Anda nantikan?
3. Apa kekhawatiran Anda tentang penggunaan TMS?
4. Apakah Anda merasa siap menggunakan TMS?
5. Apa yang bisa membuat Anda lebih yakin menggunakan TMS?

**Focus Group Discussion (2 jam):**
- FGD Guru (8-10 peserta)
- Diskusi ekspektasi, concerns, dan suggestions

---

### **📊 ANALISIS DATA TAHAP 3:**

**1. Descriptive Statistics:**
- Mean, median, std dev untuk setiap konstruk
- Distribusi frekuensi per item
- Persentase agreement (setuju + sangat setuju)

**2. Reliability Analysis:**
- Cronbach's Alpha per konstruk (target ≥0.7)

**3. Correlation Analysis:**
- Korelasi PEOU ↔ PU
- Korelasi PU ↔ ATU
- Korelasi PEOU ↔ ATU
- Korelasi ATU ↔ BI

**4. Comparative Analysis:**
- Perbandingan antar user groups (Guru vs TU vs Kepsek)
- Identifikasi group dengan ekspektasi tertinggi/terendah

---

### **📋 DELIVERABLES TAHAP 3:**

1. **Pre-Implementation TAM Report:**
   - Baseline TAM scores (PU, PEOU, ATU, BI)
   - Statistical analysis
   - User segmentation
   - Readiness assessment

2. **Concerns & Barriers Report:**
   - List of user concerns
   - Identified barriers to adoption
   - Mitigation strategies

3. **Go/No-Go Recommendation:**
   - Readiness score
   - Risk assessment
   - Go-live decision support

---

## 🚀 TAHAP 4: DEPLOYMENT & GO LIVE (Minggu 15-16)

### **Aktivitas Pengembangan:**
- Deployment ke production (Railway)
- Training pengguna
- Soft launch → Full launch
- Support & monitoring

### **🔍 EVALUASI TAM: POST-IMPLEMENTATION EVALUATION**

#### **Tujuan TAM:**
Mengukur penerimaan aktual setelah penggunaan sistem (semua konstruk + ASU)

#### **Fokus Konstruk TAM:**
**SEMUA KONSTRUK + ACTUAL SYSTEM USE**

---

### **MINGGU 15: GO LIVE & EARLY MONITORING**

**Hari H (Go Live Day):**

**Morning (07:00-12:00):**
- Soft launch dengan pilot users (5 guru + 1 TU + 1 Kepsek)
- Real-time monitoring login & usage
- Quick feedback collection

**Afternoon (13:00-17:00):**
- Expand ke semua pengguna
- Continuous monitoring
- Support standby

**End of Day:**
- Quick survey (3 pertanyaan):
  1. Seberapa mudah menggunakan TMS hari ini? (1-5)
  2. Apakah TMS membantu pekerjaan Anda hari ini? (1-5)
  3. Masalah apa yang Anda hadapi? (open-ended)

**Metrik ASU (Actual System Use) - Day 1:**
- Login rate: ___% dari total user
- Avg session duration: ___ menit
- Feature usage: Fitur apa yang paling banyak digunakan
- Error rate: Jumlah error yang dilaporkan

---

**Hari 2-7 (Minggu 15):**

**Daily Monitoring ASU:**
| Hari | Login Rate | Avg Session | Top Features | Issues |
|------|-----------|-------------|--------------|--------|
| H+1 | ___% | ___ min | ___ | ___ |
| H+2 | ___% | ___ min | ___ | ___ |
| H+3 | ___% | ___ min | ___ | ___ |
| H+4 | ___% | ___ min | ___ | ___ |
| H+5 | ___% | ___ min | ___ | ___ |

**Daily Quick Survey (2 pertanyaan):**
- Kemudahan hari ini (1-5)
- Masalah yang dihadapi (open)

**Target Minggu 15:**
- Login rate ≥60%
- Avg PEOU score ≥3.0
- Avg PU score ≥3.0
- Critical bugs = 0

---

### **MINGGU 16: FULL TAM EVALUATION**

**Metode:** Comprehensive Survey + Wawancara + Analytics

#### **A. KUESIONER TAM POST-IMPLEMENTATION (30 item)**

**PERCEIVED USEFULNESS (5 item):**
1. TMS meningkatkan efisiensi pekerjaan saya ✅
2. TMS memudahkan saya menyelesaikan tugas ✅
3. TMS bermanfaat untuk pekerjaan saya ✅
4. TMS meningkatkan produktivitas saya ✅
5. TMS membantu saya bekerja lebih cepat ✅

**PERCEIVED EASE OF USE (5 item):**
1. TMS mudah dipelajari ✅
2. Navigasi TMS jelas dan mudah dipahami ✅
3. Saya mudah menjadi terampil menggunakan TMS ✅
4. TMS mudah digunakan ✅
5. Interaksi dengan TMS jelas dan mudah dimengerti ✅

**ATTITUDE TOWARD USING (5 item):**
1. Menggunakan TMS adalah ide yang baik ✅
2. Saya senang menggunakan TMS ✅
3. Bekerja dengan TMS menyenangkan ✅
4. Saya merasa nyaman menggunakan TMS ✅
5. Saya puas dengan TMS ✅

**BEHAVIORAL INTENTION (5 item):**
1. Saya berniat terus menggunakan TMS ✅
2. Saya akan merekomendasikan TMS kepada rekan kerja ✅
3. Saya berencana menggunakan TMS secara rutin ✅
4. Saya akan menggunakan lebih banyak fitur TMS ✅
5. Saya berkomitmen menggunakan TMS jangka panjang ✅

**ACTUAL SYSTEM USE (10 item):**
1. Frekuensi login per minggu: ___ kali
2. Durasi penggunaan per hari: ___ menit
3. Fitur yang paling sering digunakan: ___
4. Fitur yang belum pernah digunakan: ___
5. Tingkat kelengkapan data yang diinput: ___%
6. Apakah Anda masih menggunakan cara manual? (Ya/Tidak)
7. Jika ya, untuk task apa? ___
8. Seberapa sering Anda mengakses TMS dari mobile? (1-5)
9. Seberapa sering Anda membutuhkan bantuan? (1-5)
10. Apakah TMS sudah menjadi bagian rutin pekerjaan? (Ya/Tidak)

---

#### **B. WAWANCARA POST-IMPLEMENTATION**

**Responden:** 7-10 orang (mix early adopters & laggards)

**Pertanyaan:**
1. Bagaimana pengalaman Anda menggunakan TMS selama 2 minggu terakhir?
2. Apa manfaat terbesar yang Anda rasakan?
3. Apa tantangan terbesar yang Anda hadapi?
4. Fitur apa yang paling membantu pekerjaan Anda?
5. Apa yang perlu diperbaiki dari TMS?
6. Apakah Anda akan terus menggunakan TMS? Mengapa?
7. Apakah TMS lebih baik dari cara manual? Mengapa?
8. Apa saran Anda untuk improvement?

---

#### **C. ANALYTICS DATA (dari System Logs)**

**Data yang Dikumpulkan:**

**User Activity:**
- Total users registered
- Active users (login ≥1x dalam 2 minggu)
- Login frequency per user
- Session duration per user
- Last login date per user

**Feature Usage:**
| Fitur | Total Usage | Unique Users | Avg per User |
|-------|-------------|--------------|--------------|
| Dashboard | ___ | ___ | ___ |
| Upload Materi | ___ | ___ | ___ |
| Buat Kuis | ___ | ___ | ___ |
| Lihat Jadwal | ___ | ___ | ___ |
| Manajemen Data Siswa | ___ | ___ | ___ |
| Export Laporan | ___ | ___ | ___ |
| ... | ___ | ___ | ___ |

**Error Logs:**
- Total errors
- Error types
- Error frequency
- Users affected

---

### **📊 ANALISIS DATA TAHAP 4:**

#### **1. TAM Model Validation**

**Regression Analysis:**
- PEOU → PU (β, p-value, R²)
- PEOU → ATU (β, p-value, R²)
- PU → ATU (β, p-value, R²)
- PU → BI (β, p-value, R²)
- ATU → BI (β, p-value, R²)
- BI → ASU (β, p-value, R²)

**Path Analysis:**
- Direct effects
- Indirect effects
- Total effects
- Model fit indices (CFI, TLI, RMSEA)

#### **2. Pre-Post Comparison**

| Konstruk | Pre (Minggu 13) | Post (Minggu 16) | Change | Sig. |
|----------|----------------|------------------|--------|------|
| PU | ___ | ___ | ___ | ___ |
| PEOU | ___ | ___ | ___ | ___ |
| ATU | ___ | ___ | ___ | ___ |
| BI | ___ | ___ | ___ | ___ |

**Analisis:**
- Apakah ekspektasi terpenuhi?
- Konstruk mana yang meningkat/menurun?
- Gap analysis & root cause

#### **3. User Segmentation**

**Berdasarkan ASU (Actual System Use):**
- **Power Users** (login >5x/minggu): ___%
- **Regular Users** (login 2-5x/minggu): ___%
- **Occasional Users** (login 1x/minggu): ___%
- **Non-Users** (tidak login): ___%

**Berdasarkan Adoption Curve:**
- **Innovators & Early Adopters**: ___%
- **Early Majority**: ___%
- **Late Majority**: ___%
- **Laggards**: ___%

---

### **📋 DELIVERABLES TAHAP 4:**

1. **Post-Implementation TAM Report (20-25 halaman):**
   - Executive Summary
   - Metodologi
   - Hasil Kuantitatif (statistik semua konstruk)
   - Hasil Kualitatif (tema dari wawancara)
   - TAM Model Validation
   - Pre-Post Comparison
   - User Segmentation
   - Key Findings & Insights
   - Recommendations

2. **Usage Analytics Dashboard:**
   - Real-time TAM scores
   - Login rate & feature adoption
   - User activity heatmap
   - Trend analysis

3. **Success Stories Documentation:**
   - Case studies dari power users
   - Testimonials
   - Before-after comparisons
   - ROI calculations

4. **Improvement Action Plan:**
   - Prioritized improvements berdasarkan TAM findings
   - Timeline implementasi
   - Responsible parties

---

## 📈 POST GO LIVE: EVALUASI BERKELANJUTAN (Minggu 17+)

### **🔍 EVALUASI TAM: SUSTAINED USAGE & IMPACT**

#### **BULAN 2 (Minggu 21-24):**

**Aktivitas:**
- Survey TAM bulanan (simplified, 15 item)
- Monitoring ASU kontinyu
- Wawancara follow-up dengan 5 users

**Fokus:**
- Apakah BI tetap tinggi?
- Apakah ASU konsisten atau menurun?
- Perubahan ATU dari minggu 16

**Target:**
- Login rate ≥80%
- PU ≥3.5, PEOU ≥3.5, ATU ≥3.5, BI ≥3.5

---

#### **BULAN 3 (Minggu 25-28):**

**Aktivitas:**
- Kuesioner TAM lengkap kedua
- FGD untuk evaluasi 3 bulan
- Impact assessment (ROI, time savings)

**Analisis:**
- Trend TAM scores (Minggu 16 → Bulan 2 → Bulan 3)
- Sustained adoption rate
- Feature usage evolution

**Target:**
- Login rate ≥85%
- PU ≥4.0, PEOU ≥4.0, ATU ≥4.0, BI ≥4.0

---

#### **BULAN 6 (Semester Evaluation):**

**Aktivitas:**
- Comprehensive TAM survey
- Impact study (efisiensi, produktivitas, kepuasan)
- Success celebration & recognition

**Deliverables:**
- Semester TAM Report
- Long-term impact assessment
- System enhancement roadmap

---

## 📊 SUMMARY: TAM EVALUATION TIMELINE

| Tahap | Minggu | Fokus TAM | Metode | Output |
|-------|--------|-----------|--------|--------|
| **TAHAP 1** | 1-4 | External Variables | Kuesioner, Wawancara, Empathy Map | Baseline Report |
| **TAHAP 2** | 5-12 | PEOU (Iterative) | Usability Testing, SUS | Usability Reports |
| **TAHAP 3** | 13-14 | PU, PEOU, ATU, BI (Pre) | Survey, Wawancara, FGD | Pre-Implementation Report |
| **TAHAP 4** | 15-16 | All + ASU (Post) | Survey, Wawancara, Analytics | Post-Implementation Report |
| **POST** | 17+ | Sustained Usage | Monthly Survey, Analytics | Trend Reports |

---

## 🎯 KRITERIA KEBERHASILAN TAM

### **Minggu 16 (Post Go Live):**
✅ PU ≥ 3.5/5.0  
✅ PEOU ≥ 3.5/5.0  
✅ ATU ≥ 3.5/5.0  
✅ BI ≥ 3.5/5.0  
✅ Login rate ≥ 70%  
✅ Feature adoption ≥ 60%  

### **Bulan 3:**
✅ PU ≥ 4.0/5.0  
✅ PEOU ≥ 4.0/5.0  
✅ ATU ≥ 4.0/5.0  
✅ BI ≥ 4.0/5.0  
✅ Login rate ≥ 85%  
✅ Feature adoption ≥ 75%  

### **Bulan 6:**
✅ PU ≥ 4.5/5.0  
✅ PEOU ≥ 4.5/5.0  
✅ ATU ≥ 4.5/5.0  
✅ BI ≥ 4.5/5.0  
✅ Login rate ≥ 90%  
✅ Feature adoption ≥ 85%  
✅ User satisfaction ≥ 90%  

---

**Dokumen ini siap untuk divisualisasikan dalam bentuk diagram Gantt, flowchart, atau infografis timeline.**

**Dibuat:** 31 Desember 2025  
**Versi:** 1.0
