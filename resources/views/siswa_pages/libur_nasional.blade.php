@extends('layouts.siswa_app')

@section('siswa_content')
<h4 class="mb-3">Libur Nasional Indonesia <span id="current-year"></span></h4>

<div class="row">
    <div class="col-12">
        <div id="loading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat data libur nasional...</p>
        </div>
        
        <div id="holiday-list" style="display: none;">
            <!-- Data libur nasional akan dimuat di sini -->
        </div>
        
        <div id="error-message" class="alert alert-danger" style="display: none;">
            <h5>Gagal memuat data</h5>
            <p>Terjadi kesalahan saat mengambil data libur nasional. Silakan coba lagi nanti.</p>
            <button class="btn btn-outline-danger" onclick="loadHolidays()">
                <i class="fas fa-redo"></i> Coba Lagi
            </button>
        </div>
    </div>
</div>

@endsection

@section('custom-scripts')
<script>
const monthNames = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

const dayNames = [
    'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
];

function formatDate(dateString) {
    const date = new Date(dateString);
    const dayName = dayNames[date.getDay()];
    const day = date.getDate();
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();
    
    return `${dayName}, ${day} ${month} ${year}`;
}

function getHolidayIcon(name) {
    const lowerName = name.toLowerCase();
    
    if (lowerName.includes('tahun baru masehi')) return '<i class="fas fa-calendar-alt text-warning"></i>';
    if (lowerName.includes('imlek')) return '<i class="fas fa-dragon text-danger"></i>';
    if (lowerName.includes('nyepi')) return '<i class="fas fa-calendar-day text-secondary"></i>';
    if (lowerName.includes('idul fitri')) return '<i class="fas fa-star-and-crescent text-success"></i>';
    if (lowerName.includes('idul adha')) return '<i class="fas fa-kaaba text-success"></i>';
    if (lowerName.includes('wafat') || lowerName.includes('kebangkitan') || lowerName.includes('kenaikan')) return '<i class="fas fa-cross text-primary"></i>';
    if (lowerName.includes('buruh')) return '<i class="fas fa-fist-raised text-warning"></i>';
    if (lowerName.includes('waisak')) return '<i class="fas fa-dharmachakra text-orange"></i>';
    if (lowerName.includes('pancasila')) return '<i class="fas fa-flag text-danger"></i>';
    if (lowerName.includes('kemerdekaan')) return '<i class="fas fa-flag-checkered text-danger"></i>';
    if (lowerName.includes('maulid') || lowerName.includes('isra') || lowerName.includes('muharram')) return '<i class="fas fa-moon text-success"></i>';
    if (lowerName.includes('natal')) return '<i class="fas fa-gift text-success"></i>';
    
    return '<i class="fas fa-calendar-day text-secondary"></i>';
}

function getHolidayType(name) {
    const lowerName = name.toLowerCase();
    
    if (lowerName.includes('cuti bersama')) return { type: 'Cuti Bersama', class: 'bg-info' };
    if (lowerName.includes('tahun baru masehi') || lowerName.includes('kemerdekaan') || lowerName.includes('pancasila') || lowerName.includes('buruh')) 
        return { type: 'Libur Nasional', class: 'bg-danger' };
    if (lowerName.includes('islam') || lowerName.includes('idul') || lowerName.includes('maulid') || lowerName.includes('isra') || lowerName.includes('muharram')) 
        return { type: 'Hari Besar Islam', class: 'bg-success' };
    if (lowerName.includes('natal') || lowerName.includes('wafat') || lowerName.includes('kebangkitan') || lowerName.includes('kenaikan')) 
        return { type: 'Hari Besar Kristen', class: 'bg-primary' };
    if (lowerName.includes('waisak')) return { type: 'Hari Besar Buddha', class: 'bg-warning' };
    if (lowerName.includes('nyepi')) return { type: 'Hari Besar Hindu', class: 'bg-info' };
    if (lowerName.includes('imlek')) return { type: 'Hari Besar Tionghoa', class: 'bg-danger' };
    
    return { type: 'Libur Nasional', class: 'bg-secondary' };
}

function getDaysUntil(dateString) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const holidayDate = new Date(dateString);
    holidayDate.setHours(0, 0, 0, 0);
    
    const diffTime = holidayDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays < 0) return 'Sudah berlalu';
    if (diffDays === 0) return 'Hari ini';
    if (diffDays === 1) return 'Besok';
    return `${diffDays} hari lagi`;
}

function displayHolidays(holidays) {
    const holidayListElement = document.getElementById('holiday-list');
    
    let html = `
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Total ada <strong>${holidays.length}</strong> hari libur nasional tahun ini
                </div>
            </div>
        </div>
        <div class="row">
    `;
    
    holidays.forEach((holiday, index) => {
        const holidayType = getHolidayType(holiday.name);
        const icon = getHolidayIcon(holiday.name);
        const formattedDate = formatDate(holiday.date);
        const daysUntil = getDaysUntil(holiday.date);
        const isUpcoming = getDaysUntil(holiday.date) !== 'Sudah berlalu';
        
        html += `
            <div class="col-lg-6 col-xl-4 mb-3">
                <div class="card h-100 ${isUpcoming ? 'border-primary' : ''}" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2">
                            <div class="me-3" style="font-size: 1.5rem;">
                                ${icon}
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1" style="line-height: 1.3;">
                                    ${holiday.name}
                                </h6>
                                <span class="badge ${holidayType.class} text-white mb-2" style="font-size: 0.7rem;">
                                    ${holidayType.type}
                                </span>
                            </div>
                        </div>
                        
                        <div class="border-top pt-2">
                            <p class="card-text mb-1">
                                <i class="fas fa-calendar-alt text-muted me-2"></i>
                                <small class="text-muted">${formattedDate}</small>
                            </p>
                            <p class="card-text mb-0">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <small class="${isUpcoming ? 'text-primary fw-bold' : 'text-muted'}">${daysUntil}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    holidayListElement.innerHTML = html;
}

function loadHolidays() {
    const loadingElement = document.getElementById('loading');
    const holidayListElement = document.getElementById('holiday-list');
    const errorElement = document.getElementById('error-message');
    
    // Show loading
    loadingElement.style.display = 'block';
    holidayListElement.style.display = 'none';
    errorElement.style.display = 'none';

    // Get current year
    const currentYear = new Date().getFullYear();
    document.getElementById('current-year').textContent = currentYear;
    
    const url = `https://libur.deno.dev/api?year=${currentYear}`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(holidays => {
            loadingElement.style.display = 'none';
            
            if (holidays && holidays.length > 0) {
                displayHolidays(holidays);
                holidayListElement.style.display = 'block';
            } else {
                throw new Error('Data libur tidak ditemukan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingElement.style.display = 'none';
            errorElement.style.display = 'block';
        });
}

// Load holidays when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadHolidays();
});
</script>

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

.text-orange {
    color: #ff8c00 !important;
}

.border-primary {
    border-color: #0d6efd !important;
    border-width: 2px !important;
}

.badge {
    font-size: 0.7rem !important;
}

.card-title {
    font-size: 0.95rem;
    font-weight: 600;
}

.alert-info {
    background-color: #e7f3ff;
    border-color: #b8daff;
    color: #004085;
}
</style>
@endsection