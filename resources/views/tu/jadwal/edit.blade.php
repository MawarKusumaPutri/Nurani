@extends('layouts.tu')

@section('title', 'Edit Jadwal - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Jadwal Pelajaran</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.jadwal.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Jadwal Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Edit Jadwal Pelajaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Validation Errors -->
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('tu.jadwal.update', $jadwal->id) }}" id="jadwal-form">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mataPelajaranList as $mataPelajaran)
                                                    <option value="{{ $mataPelajaran }}" {{ $jadwal->mata_pelajaran == $mataPelajaran ? 'selected' : '' }}>{{ $mataPelajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="guru" class="form-label">Guru Pengajar <span class="text-danger">*</span></label>
                                            <select class="form-select" id="guru" name="guru" required>
                                                <option value="">Pilih Guru</option>
                                                @foreach($gurus as $guru)
                                                    <option value="{{ $guru->id }}" {{ $jadwal->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kelas" name="kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="7" {{ $jadwal->kelas == '7' ? 'selected' : '' }}>7</option>
                                                <option value="8" {{ $jadwal->kelas == '8' ? 'selected' : '' }}>8</option>
                                                <option value="9" {{ $jadwal->kelas == '9' ? 'selected' : '' }}>9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Info Kelas</label>
                                            <div class="alert alert-info mb-0 py-2">
                                                <small>
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Pilih kelas yang sesuai dengan jadwal pelajaran
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Hari & Tanggal <span class="text-danger">*</span></label>
                                            <!-- Calendar Widget -->
                                            <div id="calendar-widget" class="calendar-widget">
                                                <div class="calendar-header">
                                                    <div class="selected-date-display" id="selected-date-display">
                                                        <span id="selected-day-name">{{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : ($jadwal->hari_nama ?? 'Pilih Tanggal') }}</span>
                                                        <button type="button" class="date-dropdown-btn" id="date-dropdown-btn">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="calendar-body" id="calendar-body">
                                                    <div class="calendar-nav">
                                                        <div class="month-year-display">
                                                            <span id="current-month-year">November 2025</span>
                                                            <div class="nav-buttons">
                                                                <button type="button" class="nav-btn" id="prev-month">
                                                                    <i class="fas fa-chevron-up"></i>
                                                                </button>
                                                                <button type="button" class="nav-btn" id="next-month">
                                                                    <i class="fas fa-chevron-down"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calendar-grid">
                                                        <div class="calendar-weekdays">
                                                            <div class="weekday">Su</div>
                                                            <div class="weekday">Mo</div>
                                                            <div class="weekday">Tu</div>
                                                            <div class="weekday">We</div>
                                                            <div class="weekday">Th</div>
                                                            <div class="weekday">Fr</div>
                                                            <div class="weekday">Sa</div>
                                                        </div>
                                                        <div class="calendar-days" id="calendar-days">
                                                            <!-- Days will be generated by JavaScript -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Hidden inputs for form submission -->
                                                <input type="hidden" id="hari" name="hari" value="{{ $jadwal->hari }}" required>
                                                <input type="hidden" id="tanggal" name="tanggal" value="{{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jam_mulai" name="jam_mulai" required>
                                                <option value="">Pilih Jam Mulai</option>
                                                @php
                                                    $jamOptions = ['07:00', '07:45', '08:30', '09:15', '10:00', '10:45', '11:30', '12:15', '13:00', '13:45', '14:30', '15:15'];
                                                    $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                                                @endphp
                                                @foreach($jamOptions as $jam)
                                                    <option value="{{ $jam }}" {{ $jamMulai == $jam ? 'selected' : '' }}>{{ $jam }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jam_selesai" name="jam_selesai" required>
                                                <option value="">Pilih Jam Selesai</option>
                                                @php
                                                    $jamSelesaiOptions = ['07:45', '08:30', '09:15', '10:00', '10:45', '11:30', '12:15', '13:00', '13:45', '14:30', '15:15', '16:00'];
                                                    $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
                                                @endphp
                                                @foreach($jamSelesaiOptions as $jam)
                                                    <option value="{{ $jam }}" {{ $jamSelesai == $jam ? 'selected' : '' }}>{{ $jam }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="1" {{ $jadwal->semester == '1' ? 'selected' : '' }}>Semester 1</option>
                                                <option value="2" {{ $jadwal->semester == '2' ? 'selected' : '' }}>Semester 2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="tahun_ajaran" name="tahun_ajaran" required>
                                                <option value="">Pilih Tahun Ajaran</option>
                                                <option value="2024/2025" {{ $jadwal->tahun_ajaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                                <option value="2025/2026" {{ $jadwal->tahun_ajaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                                                <option value="2026/2027" {{ $jadwal->tahun_ajaran == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status Jadwal</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="aktif" {{ $jadwal->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ $jadwal->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                <option value="sementara" {{ $jadwal->status == 'sementara' ? 'selected' : '' }}>Sementara</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan khusus untuk jadwal ini">{{ $jadwal->keterangan }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_berulang" name="is_berulang" {{ $jadwal->is_berulang ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_berulang">
                                                    Jadwal Tetap 1 Semester
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_lab" name="is_lab" {{ $jadwal->is_lab ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_lab">
                                                    Menggunakan Laboratorium
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_lapangan" name="is_lapangan" {{ $jadwal->is_lapangan ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_lapangan">
                                                    Menggunakan Lapangan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.jadwal.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Guidelines -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Panduan Jadwal
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Mata Pelajaran:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-calculator text-primary"></i> Matematika</li>
                                <li><i class="fas fa-book text-success"></i> Bahasa Indonesia</li>
                                <li><i class="fas fa-globe text-info"></i> Bahasa Inggris</li>
                                <li><i class="fas fa-flask text-warning"></i> IPA</li>
                                <li><i class="fas fa-chart-line text-danger"></i> IPS</li>
                                <li><i class="fas fa-mosque text-secondary"></i> Pendidikan Agama</li>
                            </ul>
                            
                            <h6 class="mt-3">Jam Pelajaran:</h6>
                            <ul class="small text-muted">
                                <li>1 jam = 45 menit</li>
                                <li>Istirahat: 10 menit</li>
                                <li>Jam masuk: 07:00</li>
                                <li>Jam pulang: 16:00</li>
                            </ul>
                            
                            <h6 class="mt-3">Tips Jadwal:</h6>
                            <ul class="small text-muted">
                                <li>Pastikan tidak ada konflik waktu</li>
                                <li>Gunakan lab untuk praktikum</li>
                                <li>Set jadwal berulang jika perlu</li>
                                <li>Pilih guru yang sesuai dengan mata pelajaran</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Jadwal Preview -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Preview Jadwal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="jadwal-preview" class="p-3 border rounded bg-light">
                                <div class="text-center text-muted">
                                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                    <p class="mb-0">Preview jadwal akan muncul setelah Anda mengisi form</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Schedules -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Jadwal Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Daftar jadwal terbaru akan muncul di sini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    /* Calendar Widget Styles - Light Theme */
    .calendar-widget {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        color: #212529;
        font-family: 'Poppins', sans-serif;
        border: 1px solid #ced4da;
    }

    .calendar-header {
        padding: 12px 16px;
        background: white;
        border-bottom: 1px solid #dee2e6;
    }

    .selected-date-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #selected-day-name {
        font-size: 14px;
        font-weight: 500;
        color: #212529;
    }

    .date-dropdown-btn {
        background: white;
        border: 1px solid #ced4da;
        color: #6c757d;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .date-dropdown-btn:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
    }

    .calendar-body {
        padding: 20px;
        background: white;
    }

    .calendar-nav {
        margin-bottom: 20px;
    }

    .month-year-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #current-month-year {
        font-size: 16px;
        font-weight: 600;
        color: #212529;
    }

    .nav-buttons {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-btn {
        background: white;
        border: 1px solid #ced4da;
        color: #6c757d;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 12px;
    }

    .nav-btn:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
    }

    .calendar-grid {
        width: 100%;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 12px;
    }

    .weekday {
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        padding: 8px 0;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        background: transparent;
        color: #212529;
        border: 1px solid transparent;
        padding: 0;
    }

    .calendar-day:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .calendar-day.other-month {
        color: #adb5bd;
    }

    .calendar-day.selected {
        background: #9c27b0;
        color: white;
        font-weight: 600;
        border-color: #9c27b0;
    }

    .calendar-day.today {
        border: 1px solid #9c27b0;
        background: rgba(156, 39, 176, 0.1);
    }

    .calendar-day.today.selected {
        border: 1px solid #9c27b0;
        background: #9c27b0;
        color: white;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar functionality
    let currentDate = new Date();
    let selectedDate = null;
    
    const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const hariNamaEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const bulanNamaEn = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    const hariValueMap = {
        'minggu': 'minggu',
        'senin': 'senin',
        'selasa': 'selasa',
        'rabu': 'rabu',
        'kamis': 'kamis',
        'jumat': 'jumat',
        'sabtu': 'sabtu'
    };
    
    function getHariValue(dayName) {
        const dayIndex = hariNamaEn.indexOf(dayName);
        if (dayIndex === -1) return '';
        const hariValues = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        return hariValues[dayIndex];
    }
    
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update month/year display
        document.getElementById('current-month-year').textContent = 
            `${bulanNama[month]} ${year}`;
        
        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();
        
        // Clear calendar days
        const calendarDays = document.getElementById('calendar-days');
        calendarDays.innerHTML = '';
        
        // Add empty cells for days before month starts
        const prevMonth = month === 0 ? 11 : month - 1;
        const prevYear = month === 0 ? year - 1 : year;
        const daysInPrevMonth = new Date(prevYear, prevMonth + 1, 0).getDate();
        
        for (let i = startingDayOfWeek - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            const dayElement = document.createElement('button');
            dayElement.className = 'calendar-day other-month';
            dayElement.textContent = day;
            dayElement.type = 'button';
            calendarDays.appendChild(dayElement);
        }
        
        // Add days of current month
        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDate = new Date(year, month, day);
            const dayElement = document.createElement('button');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;
            dayElement.type = 'button';
            dayElement.dataset.date = dayDate.toISOString().split('T')[0];
            
            // Check if today
            if (dayDate.toDateString() === today.toDateString()) {
                dayElement.classList.add('today');
            }
            
            // Check if selected
            if (selectedDate && dayDate.toDateString() === selectedDate.toDateString()) {
                dayElement.classList.add('selected');
            }
            
            // Add click event
            dayElement.addEventListener('click', function() {
                selectDate(dayDate);
            });
            
            calendarDays.appendChild(dayElement);
        }
        
        // Add empty cells for days after month ends
        const totalCells = calendarDays.children.length;
        const remainingCells = 42 - totalCells; // 6 weeks * 7 days
        for (let day = 1; day <= remainingCells && day <= 14; day++) {
            const dayElement = document.createElement('button');
            dayElement.className = 'calendar-day other-month';
            dayElement.textContent = day;
            dayElement.type = 'button';
            calendarDays.appendChild(dayElement);
        }
    }
    
    function selectDate(date) {
        selectedDate = new Date(date);
        
        // Update selected date display
        const dayName = hariNama[selectedDate.getDay()];
        const dayNumber = selectedDate.getDate();
        const monthName = bulanNama[selectedDate.getMonth()];
        document.getElementById('selected-day-name').textContent = 
            `${dayName}, ${dayNumber.toString().padStart(2, '0')} ${monthName}`;
        
        // Update hidden inputs with timezone adjustment
        const hariValue = getHariValue(hariNamaEn[selectedDate.getDay()]);
        document.getElementById('hari').value = hariValue;
        
        // Adjust for timezone offset to prevent date shift on UTC server
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
        const day = String(selectedDate.getDate()).padStart(2, '0');
        document.getElementById('tanggal').value = `${year}-${month}-${day}`;
        
        // Re-render calendar to update selected state
        renderCalendar();
        
        // Update preview
        updatePreview();
    }
    
    // Navigation buttons
    document.getElementById('prev-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    
    document.getElementById('next-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Toggle calendar visibility (for dropdown button)
    let calendarVisible = true;
    document.getElementById('date-dropdown-btn').addEventListener('click', function() {
        const calendarBody = document.getElementById('calendar-body');
        calendarVisible = !calendarVisible;
        calendarBody.style.display = calendarVisible ? 'block' : 'none';
    });
    
    // Initialize calendar
    renderCalendar();
    
    // Pre-select date if exists
    @if($jadwal->tanggal)
        const existingDateStr = '{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') }}';
        if (existingDateStr) {
            const existingDate = new Date(existingDateStr + 'T00:00:00');
            if (!isNaN(existingDate.getTime())) {
                currentDate = new Date(existingDate);
                renderCalendar();
                setTimeout(() => {
                    selectDate(existingDate);
                }, 100);
            }
        }
    @elseif($jadwal->hari)
        // If no date but has hari, set hari value
        document.getElementById('hari').value = '{{ $jadwal->hari }}';
        const hariNamaEdit = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const hariValueEdit = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        const hariIndexEdit = hariValueEdit.indexOf('{{ $jadwal->hari }}');
        if (hariIndexEdit >= 0) {
            document.getElementById('selected-day-name').textContent = hariNamaEdit[hariIndexEdit];
        }
    @endif
    
    // Auto-generate jam selesai based on jam mulai
    const jamMulai = document.getElementById('jam_mulai');
    const jamSelesai = document.getElementById('jam_selesai');
    
    jamMulai.addEventListener('change', function() {
        if (this.value) {
            // Parse jam mulai and add 45 minutes
            const [hours, minutes] = this.value.split(':').map(Number);
            const startTime = new Date();
            startTime.setHours(hours, minutes, 0, 0);
            
            // Add 45 minutes
            const endTime = new Date(startTime.getTime() + 45 * 60000);
            
            // Format to HH:MM
            const endTimeString = endTime.toTimeString().slice(0, 5);
            
            // Set jam selesai
            jamSelesai.value = endTimeString;
            
            // Update preview
            updatePreview();
        }
    });
    
    // Update preview when form changes
    function updatePreview() {
        const mataPelajaran = document.getElementById('mata_pelajaran').value;
        const guru = document.getElementById('guru').options[document.getElementById('guru').selectedIndex].text;
        const kelas = document.getElementById('kelas').value;
        const hari = document.getElementById('hari').value;
        const tanggal = document.getElementById('tanggal').value;
        const jamMulai = document.getElementById('jam_mulai').value;
        const jamSelesai = document.getElementById('jam_selesai').value;
        
        if (mataPelajaran && guru && kelas && hari && jamMulai && jamSelesai) {
            const preview = document.getElementById('jadwal-preview');
            const hariIndex = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'].indexOf(hari);
            const hariDisplay = hariIndex >= 0 ? hariNama[hariIndex] : hari.charAt(0).toUpperCase() + hari.slice(1);
            
            let previewHTML = `
                <div class="text-center">
                    <h6 class="mb-2">${mataPelajaran}</h6>
                    <p class="mb-1"><strong>Guru:</strong> ${guru}</p>
                    <p class="mb-1"><strong>Kelas:</strong> ${kelas}</p>
                    <p class="mb-1"><strong>Hari:</strong> ${hariDisplay}</p>
            `;
            
            if (tanggal) {
                const dateObj = new Date(tanggal);
                const tanggalDisplay = `${dateObj.getDate().toString().padStart(2, '0')} ${bulanNama[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
                previewHTML += `<p class="mb-1"><strong>Tanggal:</strong> ${tanggalDisplay}</p>`;
            }
            
            previewHTML += `
                    <p class="mb-0"><strong>Waktu:</strong> ${jamMulai} - ${jamSelesai}</p>
                </div>
            `;
            
            preview.innerHTML = previewHTML;
        }
    }
    
    // Add event listeners for preview updates
    ['mata_pelajaran', 'guru', 'kelas', 'hari', 'tanggal', 'jam_mulai', 'jam_selesai'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', updatePreview);
        }
    });

    // Form validation before submit
    const form = document.getElementById('jadwal-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validate required fields
            const mataPelajaran = document.getElementById('mata_pelajaran').value;
            const guru = document.getElementById('guru').value;
            const kelas = document.getElementById('kelas').value;
            const hari = document.getElementById('hari').value;
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;
            const semester = document.getElementById('semester').value;
            const tahunAjaran = document.getElementById('tahun_ajaran').value;

            if (!mataPelajaran || !guru || !kelas || !hari || !jamMulai || !jamSelesai || !semester || !tahunAjaran) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return false;
            }

            // Log form data for debugging
            console.log('Form Data:', {
                mata_pelajaran: mataPelajaran,
                guru: guru,
                kelas: kelas,
                hari: hari,
                tanggal: document.getElementById('tanggal').value,
                jam_mulai: jamMulai,
                jam_selesai: jamSelesai,
                semester: semester,
                tahun_ajaran: tahunAjaran,
                is_berulang: document.getElementById('is_berulang').checked,
                is_lab: document.getElementById('is_lab').checked
            });

            // Show loading state
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            }
            
            // Allow form to submit
            return true;
        });
    }
});
</script>
@endsection
