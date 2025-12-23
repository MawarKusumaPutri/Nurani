-- ============================================
-- IMPORT JADWAL LENGKAP
-- Paste SQL ini di phpMyAdmin → Database nurani → Tab SQL
-- ============================================

-- CATATAN PENTING:
-- 1. Pastikan MySQL sudah running di XAMPP
-- 2. Ganti ID guru sesuai dengan database Anda
-- 3. Cek ID guru dulu dengan query: SELECT g.id, u.name FROM gurus g JOIN users u ON g.user_id = u.id;

-- ============================================
-- HAPUS JADWAL LAMA (OPSIONAL)
-- Uncomment jika ingin hapus jadwal lama
-- ============================================
-- DELETE FROM jadwal;

-- ============================================
-- CEK ID GURU
-- Jalankan query ini dulu untuk tahu ID guru
-- ============================================
-- SELECT g.id, u.name, g.mata_pelajaran 
-- FROM gurus g 
-- JOIN users u ON g.user_id = u.id 
-- WHERE g.status = 'aktif';

-- ============================================
-- ASUMSI ID GURU (SESUAIKAN DENGAN DATABASE ANDA!)
-- ============================================
-- ID 1 = Nurhadi, S.Pd
-- ID 2 = Maman Suparman, A.K.S
-- ID 3 = Lola Nurlaelis, S.Pd.I
-- ID 4 = Siti Mundari, S.Ag
-- ID 5 = Fadli
-- ID 6 = Tintin Martini

-- ============================================
-- JADWAL SENIN
-- ============================================

-- Kelas 7 - Senin
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('ipa', 1, '7', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('ips', 1, '7', 'senin', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('lainnya', 3, '7', 'senin', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '7', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('seni_budaya', 1, '7', 'senin', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '7', 'senin', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW());

-- Kelas 8 - Senin
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('bahasa_indonesia', 2, '8', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('ipa', 1, '8', 'senin', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('ipa', 1, '8', 'senin', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('matematika', 1, '8', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('matematika', 1, '8', 'senin', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('matematika', 1, '8', 'senin', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW());

-- Kelas 9 - Senin
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('bahasa_indonesia', 2, '9', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW()),
('matematika', 1, '9', 'senin', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW()),
('matematika', 1, '9', 'senin', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW()),
('matematika', 1, '9', 'senin', '09:00:00', '09:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW()),
('matematika', 1, '9', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW()),
('seni_budaya', 1, '9', 'senin', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW());

-- ============================================
-- JADWAL KAMIS (Contoh untuk Penjaskes)
-- ============================================

-- Kelas 7 - Kamis
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, is_lapangan, ruang, created_by, created_at, updated_at) VALUES
('pendidikan_agama', 4, '7', 'kamis', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 7', 1, NOW(), NOW()),
('pendidikan_agama', 4, '7', 'kamis', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '7', 'kamis', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '7', 'kamis', '09:00:00', '09:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 7', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '7', 'kamis', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '7', 'kamis', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '7', 'kamis', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW());

-- Kelas 8 - Kamis
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, is_lapangan, ruang, created_by, created_at, updated_at) VALUES
('pendidikan_agama', 4, '8', 'kamis', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 8', 1, NOW(), NOW()),
('bahasa_indonesia', 2, '8', 'kamis', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 8', 1, NOW(), NOW()),
('pendidikan_agama', 4, '8', 'kamis', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 8', 1, NOW(), NOW()),
('matematika', 1, '8', 'kamis', '09:00:00', '09:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 8', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '8', 'kamis', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '8', 'kamis', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '8', 'kamis', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW());

-- Kelas 9 - Kamis
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, is_lapangan, ruang, created_by, created_at, updated_at) VALUES
('bahasa_indonesia', 2, '9', 'kamis', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW()),
('bahasa_indonesia', 2, '9', 'kamis', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW()),
('bahasa_indonesia', 2, '9', 'kamis', '08:20:00', '09:00:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW()),
('bahasa_indonesia', 2, '9', 'kamis', '09:00:00', '09:40:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW()),
('pendidikan_jasmani', 5, '9', 'kamis', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 1, 'Lapangan', 1, NOW(), NOW()),
('ips', 1, '9', 'kamis', '10:40:00', '11:20:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW()),
('ips', 1, '9', 'kamis', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 0, 'Ruang 9', 1, NOW(), NOW());

-- ============================================
-- VERIFIKASI
-- Jalankan query ini untuk cek hasil import
-- ============================================
-- SELECT j.*, u.name as nama_guru, j.kelas, j.hari, j.jam_mulai, j.jam_selesai
-- FROM jadwal j
-- JOIN gurus g ON j.guru_id = g.id
-- JOIN users u ON g.user_id = u.id
-- ORDER BY j.hari, j.jam_mulai;

-- ============================================
-- CEK JADWAL PER GURU
-- ============================================
-- SELECT u.name, COUNT(*) as jumlah_jadwal
-- FROM jadwal j
-- JOIN gurus g ON j.guru_id = g.id
-- JOIN users u ON g.user_id = u.id
-- GROUP BY u.name;
