@extends('layouts.tu')

@section('title', 'Kalender - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kalender Akademik</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Event
                        </a>
                        <a href="{{ route('tu.kalender.list') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-list"></i> Daftar Event
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Kategori Event</label>
                                    <select class="form-select" id="filter-kategori">
                                        <option value="">Semua Kategori</option>
                                        <option value="akademik">Akademik</option>
                                        <option value="ujian">Ujian</option>
                                        <option value="libur">Libur</option>
                                        <option value="rapat">Rapat</option>
                                        <option value="pelatihan">Pelatihan</option>
                                        <option value="kegiatan">Kegiatan</option>
                                        <option value="pengumuman">Pengumuman</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar View -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="background: transparent; border: none; box-shadow: none;">
                        <div class="card-body p-0">
                            <!-- Dark Theme Calendar Widget -->
                            <div id="calendar-widget" class="calendar-widget-dark">
                                <div class="calendar-header-dark">
                                    <div class="selected-date-display-dark">
                                        <button type="button" class="nav-btn-dark prev-month-btn" id="prev-month-btn">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <span id="selected-date-text">Pilih Tanggal</span>
                                        <button type="button" class="nav-btn-dark next-month-btn" id="next-month-btn">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="calendar-body-dark">
                                    <div class="calendar-weekdays-dark">
                                        <div class="weekday-dark">Minggu</div>
                                        <div class="weekday-dark">Senin</div>
                                        <div class="weekday-dark">Selasa</div>
                                        <div class="weekday-dark">Rabu</div>
                                        <div class="weekday-dark">Kamis</div>
                                        <div class="weekday-dark">Jumat</div>
                                        <div class="weekday-dark">Sabtu</div>
                                    </div>
                                    <div class="calendar-days-dark" id="calendar-days-dark">
                                        <!-- Days will be generated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events List -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list"></i> Daftar Event Bulan Ini
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(isset($eventsThisMonth) && $eventsThisMonth->count() > 0)
                                <div class="row">
                                    @foreach($eventsThisMonth as $event)
                                        @php
                                            $kategori = strtolower($event->kategori_event ?? 'lainnya');
                                            
                                            // Mapping warna border dan badge berdasarkan kategori
                                            $kategoriConfig = [
                                                'ujian' => ['border' => '#dc3545', 'badge' => 'bg-danger', 'label' => 'Ujian'],
                                                'akademik' => ['border' => '#007bff', 'badge' => 'bg-primary', 'label' => 'Akademik'],
                                                'libur' => ['border' => '#ffc107', 'badge' => 'bg-warning', 'label' => 'Libur'],
                                                'rapat' => ['border' => '#17a2b8', 'badge' => 'bg-info', 'label' => 'Rapat'],
                                                'pelatihan' => ['border' => '#9c27b0', 'badge' => 'bg-secondary', 'label' => 'Pelatihan'],
                                                'kegiatan' => ['border' => '#fd7e14', 'badge' => 'bg-warning', 'label' => 'Kegiatan'],
                                                'pengumuman' => ['border' => '#D2B48C', 'badge' => 'bg-secondary', 'label' => 'Pengumuman'],
                                                'lainnya' => ['border' => '#6c757d', 'badge' => 'bg-secondary', 'label' => 'Lainnya'],
                                            ];
                                            
                                            $config = $kategoriConfig[$kategori] ?? $kategoriConfig['lainnya'];
                                            
                                            // Format tanggal
                                            $tanggalMulai = \Carbon\Carbon::parse($event->tanggal_mulai);
                                            $tanggalSelesai = $event->tanggal_selesai ? \Carbon\Carbon::parse($event->tanggal_selesai) : null;
                                            
                                            // Format tanggal display
                                            if ($tanggalSelesai && $tanggalSelesai->format('Y-m-d') != $tanggalMulai->format('Y-m-d')) {
                                                $tanggalDisplay = $tanggalMulai->format('d') . '-' . $tanggalSelesai->format('d M Y');
                                            } else {
                                                $tanggalDisplay = $tanggalMulai->format('d M Y');
                                            }
                                            
                                            // Tambahkan waktu jika ada
                                            if ($event->waktu_mulai) {
                                                $waktu = \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i');
                                                $tanggalDisplay .= ', ' . $waktu;
                                            }
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="event-item mb-3 p-3 border rounded" style="border-left: 4px solid {{ $config['border'] }};">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $event->judul_event }}</h6>
                                                        <p class="text-muted mb-1">{{ $tanggalDisplay }}</p>
                                                        <small class="text-muted">Kategori: {{ ucfirst($kategori) }}</small>
                                                    </div>
                                                    <span class="badge {{ $config['badge'] }}">{{ $config['label'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada event untuk bulan ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    /* Attractive Calendar Widget Styles */
    .calendar-widget-dark {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(76, 175, 80, 0.4);
        color: white;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }

    .calendar-header-dark {
        padding: 20px 24px;
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .selected-date-display-dark {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #selected-date-text {
        font-size: 18px;
        font-weight: 600;
        color: white;
        flex: 1;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .nav-btn-dark {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 16px;
        backdrop-filter: blur(10px);
    }

    .nav-btn-dark:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: scale(1.05);
    }

    .calendar-body-dark {
        padding: 24px;
        background: #F0F4F0;
        backdrop-filter: blur(10px);
    }

    .calendar-weekdays-dark {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }

    .weekday-dark {
        text-align: center;
        font-size: 13px;
        font-weight: 700;
        color: #2E7D32;
        padding: 10px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-days-dark {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }

    .calendar-day-dark {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s;
        background: #F0F4F0;
        color: #2E7D32;
        border: 2px solid transparent;
        padding: 0;
        position: relative;
        min-height: 60px;
    }

    .calendar-day-dark:hover {
        background: #E8F5E9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);
    }

    .calendar-day-dark.other-month {
        color: rgba(46, 125, 50, 0.4);
        background: #F0F4F0;
    }

    .calendar-day-dark.selected {
        background: #4CAF50;
        color: white;
        font-weight: 700;
        border: 2px solid #2E7D32;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
    }

    .calendar-day-dark.today {
        border: 2px solid #4CAF50;
        background: #E8F5E9;
        font-weight: 700;
        color: #2E7D32;
    }

    .calendar-day-dark.today.selected {
        border: 2px solid #2E7D32;
        background: #4CAF50;
        color: white;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.5);
    }

    .calendar-day-dark.has-event {
        /* Background will be set dynamically via inline style */
        color: white !important;
        font-weight: 600;
        padding: 4px;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .calendar-day-dark.has-event .day-number {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 3px;
        width: 100%;
    }

    .calendar-day-dark.has-event .event-text {
        font-size: 10px;
        line-height: 1.2;
        text-align: left;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        padding: 0 3px;
        font-weight: 500;
    }

    .calendar-day-dark.has-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        opacity: 0.9;
    }

    .calendar-day-dark.has-event.selected {
        border: 2px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    }
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar functionality
    let currentDate = new Date();
    let selectedDate = null;
    
    // Events data from server
    const allEvents = @json($events ?? []);
    let filteredEvents = [...allEvents]; // Copy untuk filtering
    
    // Debug: Log events to console
    console.log('Total events loaded:', allEvents.length);
    console.log('Events data:', allEvents);
    
    // Log events by category untuk debugging
    const eventsByCategory = {};
    allEvents.forEach(event => {
        const kategori = event.kategori || 'Unknown';
        if (!eventsByCategory[kategori]) {
            eventsByCategory[kategori] = [];
        }
        eventsByCategory[kategori].push(event);
    });
    console.log('Events by category:', eventsByCategory);
    
    // Filter events berdasarkan kategori
    function filterEventsByKategori() {
        const filterKategori = document.getElementById('filter-kategori');
        const selectedKategori = filterKategori ? filterKategori.value : '';
        
        if (selectedKategori === '') {
            filteredEvents = [...allEvents];
        } else {
            filteredEvents = allEvents.filter(event => {
                const eventKategori = event.kategori ? event.kategori.toLowerCase() : '';
                return eventKategori === selectedKategori.toLowerCase();
            });
        }
        
        console.log('Filtered events:', filteredEvents.length, 'for kategori:', selectedKategori || 'All');
        renderCalendar();
    }
    
    // Setup filter event listener
    const filterKategoriSelect = document.getElementById('filter-kategori');
    if (filterKategoriSelect) {
        filterKategoriSelect.addEventListener('change', filterEventsByKategori);
    }
    
    const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    // Function to darken color for gradient
    function darkenColor(color, percent) {
        // Convert hex to RGB
        const num = parseInt(color.replace("#", ""), 16);
        const r = Math.max(0, Math.floor((num >> 16) * (100 - percent) / 100));
        const g = Math.max(0, Math.floor(((num >> 8) & 0x00FF) * (100 - percent) / 100));
        const b = Math.max(0, Math.floor((num & 0x0000FF) * (100 - percent) / 100));
        return "#" + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
    }
    
    // Function to get events for a specific date
    function getEventsForDate(date) {
        const dateStr = date.toISOString().split('T')[0];
        
        return filteredEvents.filter(event => {
            if (!event.tanggal) {
                console.warn('Event missing tanggal:', event);
                return false;
            }
            
            // Parse tanggal event (handle both string and date formats)
            let eventDateStr;
            if (event.tanggal instanceof Date) {
                eventDateStr = event.tanggal.toISOString().split('T')[0];
            } else if (typeof event.tanggal === 'string') {
                // Handle Y-m-d format
                eventDateStr = event.tanggal.split(' ')[0]; // Remove time if present
            } else {
                eventDateStr = new Date(event.tanggal).toISOString().split('T')[0];
            }
            
            // Check if event is on this date
            if (eventDateStr === dateStr) {
                return true;
            }
            
            // Check if event has tanggal_selesai (multi-day event)
            if (event.tanggal_selesai) {
                let startDate, endDate;
                
                if (event.tanggal instanceof Date) {
                    startDate = event.tanggal;
                } else {
                    startDate = new Date(event.tanggal);
                }
                
                if (event.tanggal_selesai instanceof Date) {
                    endDate = event.tanggal_selesai;
                } else {
                    endDate = new Date(event.tanggal_selesai);
                }
                
                const checkDate = new Date(dateStr);
                
                // Check if date is between start and end date
                if (checkDate >= startDate && checkDate <= endDate) {
                    return true;
                }
            }
            
            return false;
        });
    }
    
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update selected date display
        document.getElementById('selected-date-text').textContent = 
            `${bulanNama[month]} ${year}`;
        
        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();
        
        // Clear calendar days
        const calendarDays = document.getElementById('calendar-days-dark');
        calendarDays.innerHTML = '';
        
        // Add empty cells for days before month starts
        const prevMonth = month === 0 ? 11 : month - 1;
        const prevYear = month === 0 ? year - 1 : year;
        const daysInPrevMonth = new Date(prevYear, prevMonth + 1, 0).getDate();
        
        for (let i = startingDayOfWeek - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            const dayElement = document.createElement('button');
            dayElement.className = 'calendar-day-dark other-month';
            dayElement.textContent = day;
            dayElement.type = 'button';
            calendarDays.appendChild(dayElement);
        }
        
        // Add days of current month
        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDate = new Date(year, month, day);
            const dayElement = document.createElement('button');
            dayElement.className = 'calendar-day-dark';
            dayElement.type = 'button';
            dayElement.dataset.date = dayDate.toISOString().split('T')[0];
            
            // Check if has event
            const dayEvents = getEventsForDate(dayDate);
            
            if (dayEvents.length > 0) {
                dayElement.classList.add('has-event');
                
                // SELALU gunakan warna berdasarkan kategori untuk konsistensi
                // Ini memastikan event "kegiatan" selalu menggunakan warna orange
                const kategoriColorMap = {
                    'libur': '#ffc107',
                    'ujian': '#dc3545',
                    'akademik': '#007bff',
                    'rapat': '#17a2b8',
                    'pelatihan': '#9c27b0',
                    'kegiatan': '#fd7e14',  // Orange untuk kegiatan
                    'pengumuman': '#D2B48C',
                    'lainnya': '#6c757d'
                };
                
                // PRIORITAS: Gunakan warna dari data event jika tersedia
                // Khusus untuk libur nasional/internasional (ID >= 1000 atau warna #2E7D32), 
                // SELALU gunakan warna hijau tua #2E7D32 dan jangan di-override
                let eventColor = dayEvents[0].warna;
                
                // Jika event adalah libur nasional/internasional (ID >= 1000 atau warna #2E7D32)
                if ((dayEvents[0].id && dayEvents[0].id >= 1000) || eventColor === '#2E7D32') {
                    eventColor = '#2E7D32'; // PERMANEN: Hijau tua untuk libur nasional/internasional
                } else if (!eventColor || !eventColor.startsWith('#')) {
                    // Jika tidak ada warna dari data, gunakan kategoriColorMap
                    const kategori = dayEvents[0].kategori ? dayEvents[0].kategori.toLowerCase() : 'lainnya';
                    eventColor = kategoriColorMap[kategori] || '#dc3545';
                }
                
                // Pastikan warna valid
                if (!eventColor || !eventColor.startsWith('#')) {
                    const kategori = dayEvents[0].kategori ? dayEvents[0].kategori.toLowerCase() : 'lainnya';
                    eventColor = kategoriColorMap[kategori] || '#dc3545';
                }
                
                // Debug log untuk event yang ditemukan
                if (dayEvents[0].judul && (dayEvents[0].judul.toLowerCase().includes('ujian') || dayEvents[0].kategori && dayEvents[0].kategori.toLowerCase() === 'ujian')) {
                    console.log('Ujian event found:', dayEvents[0]);
                    console.log('Event color:', eventColor);
                }
                
                // Debug log untuk event kegiatan
                if (dayEvents[0].kategori && dayEvents[0].kategori.toLowerCase() === 'kegiatan') {
                    console.log('=== KEGIATAN EVENT FOUND ===');
                    console.log('Event data:', dayEvents[0]);
                    console.log('Event color:', eventColor);
                    console.log('Event warna from data:', dayEvents[0].warna);
                    console.log('Event kategori:', dayEvents[0].kategori);
                    console.log('Date:', dayDate.toISOString().split('T')[0]);
                }
                
                // Log semua event untuk debugging
                if (dayEvents.length > 0) {
                    console.log('Event on date ' + dayDate.toISOString().split('T')[0] + ':', {
                        judul: dayEvents[0].judul,
                        kategori: dayEvents[0].kategori,
                        warna: eventColor,
                        tanggal: dayEvents[0].tanggal
                    });
                }
                
                // Pastikan warna valid
                // Khusus untuk libur nasional/internasional (ID >= 1000 atau warna #2E7D32), 
                // SELALU gunakan warna hijau tua #2E7D32
                let validColor = eventColor;
                if ((dayEvents[0].id && dayEvents[0].id >= 1000) || eventColor === '#2E7D32') {
                    validColor = '#2E7D32'; // PERMANEN: Hijau tua untuk libur nasional/internasional
                } else if (!validColor || !validColor.startsWith('#')) {
                    validColor = '#dc3545';
                }
                dayElement.style.background = `linear-gradient(135deg, ${validColor} 0%, ${darkenColor(validColor, 20)} 100%)`;
                
                // Create structure for event display
                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = day;
                
                const eventText = document.createElement('div');
                eventText.className = 'event-text';
                // Show first event title, or multiple if short
                if (dayEvents.length === 1) {
                    eventText.textContent = dayEvents[0].judul || 'Event';
                } else {
                    eventText.textContent = (dayEvents[0].judul || 'Event') + ' (+' + (dayEvents.length - 1) + ')';
                }
                
                dayElement.appendChild(dayNumber);
                dayElement.appendChild(eventText);
            } else {
                dayElement.textContent = day;
            }
            
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
            dayElement.className = 'calendar-day-dark other-month';
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
        const year = selectedDate.getFullYear();
        
        // Get events for selected date
        const dayEvents = getEventsForDate(selectedDate);
        
        if (dayEvents.length > 0) {
            const firstEvent = dayEvents[0].judul;
            const eventCount = dayEvents.length > 1 ? ` (+${dayEvents.length - 1} event)` : '';
            document.getElementById('selected-date-text').textContent = 
                `${dayName}, ${dayNumber.toString().padStart(2, '0')} ${monthName} - ${firstEvent}${eventCount}`;
        } else {
            document.getElementById('selected-date-text').textContent = 
                `${dayName}, ${dayNumber.toString().padStart(2, '0')} ${monthName}`;
        }
        
        // Re-render calendar to update selected state
        renderCalendar();
        
        // You can add logic here to show events for selected date
        console.log('Selected date:', selectedDate.toISOString().split('T')[0]);
        console.log('Events:', dayEvents);
    }
    
    // Navigation buttons
    document.getElementById('prev-month-btn').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    
    document.getElementById('next-month-btn').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Initialize calendar
    renderCalendar();
});
</script>
@endsection
