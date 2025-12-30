import os
import re

# Daftar file yang perlu diperbaiki
files_to_fix = [
    "evaluasi/rubrik/index.blade.php",
    "evaluasi/rubrik/edit.blade.php",
    "evaluasi/rubrik/create.blade.php",
    "evaluasi/rekap/index.blade.php",
    "evaluasi/nilai/show.blade.php",
    "evaluasi/nilai/index.blade.php",
    "evaluasi/nilai/edit.blade.php",
    "evaluasi/nilai/create.blade.php",
    "evaluasi/lembar/index.blade.php",
    "evaluasi/lembar/edit.blade.php",
    "evaluasi/lembar/create.blade.php",
    "evaluasi/index.blade.php",
    "jadwal/index.blade.php"
]

base_path = r"d:\Praktikum DWBI\xampp\htdocs\nurani\resources\views\guru"
updated_count = 0
skipped_count = 0
error_count = 0

for file_rel_path in files_to_fix:
    file_path = os.path.join(base_path, file_rel_path)
    
    try:
        # Baca file
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Cek apakah sudah dikomentari
        if "/* Layout CSS - DISABLED" in content:
            print(f"Sudah dikomentari: {file_rel_path}")
            skipped_count += 1
            continue
        
        # Cek apakah ada pattern yang bermasalah
        if "Layout - sama seperti presensi" not in content:
            print(f"Tidak ada pattern bermasalah: {file_rel_path}")
            skipped_count += 1
            continue
        
        # Komentari CSS inline
        # Cari start pattern
        content = content.replace(
            "/* Layout - sama seperti presensi",
            "/* Layout CSS - DISABLED - Menggunakan CSS Global dari guru-fixed-layout.blade.php */\n        /*\n        /* Layout - sama seperti presensi"
        )
        
        # Cari end pattern dan tambahkan penutup komentar
        content = content.replace(
            "/* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */",
            "*/\n        \n        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - DISABLED */\n        /*\n        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */"
        )
        
        # Tambahkan penutup komentar sebelum </style>
        # Cari pattern terakhir sebelum </style>
        pattern = r"(\s+)\}\s+\}\s+</style>"
        replacement = r"\1        }\n        }\n        */\n    </style>"
        content = re.sub(pattern, replacement, content)
        
        # Simpan file
        with open(file_path, 'w', encoding='utf-8', newline='') as f:
            f.write(content)
        
        print(f"✓ Updated: {file_rel_path}")
        updated_count += 1
        
    except Exception as e:
        print(f"✗ Error processing {file_rel_path}: {e}")
        error_count += 1

print("\n" + "="*50)
print("SUMMARY")
print("="*50)
print(f"Updated: {updated_count} files")
print(f"Skipped: {skipped_count} files")
print(f"Errors: {error_count} files")
print("="*50)
