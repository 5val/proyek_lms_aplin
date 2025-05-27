<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mata Pelajaran Guru</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            line-height: 1.2;
            color: #000;
            background: #fff;
        }
        
        .rapor-container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 10mm;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            min-height: 100vh;
        }
        
        .header-rapot {
            border: 2px solid #000;
            padding: 8px;
            margin-bottom: 15px;
        }
        
        .header-top {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            text-align: center;
        }
        
        .school-info {
            flex: 1;
        }
        
        .school-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .school-address {
            font-size: 9px;
            margin-bottom: 1px;
        }
        
        .rapor-title {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            align-self: flex-start;
        }
        
        .student-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 2px;
        }
        
        .info-label {
            width: 130px;
            font-weight: normal;
        }
        
        .info-value {
            flex: 1;
            border-bottom: 1px dotted #000;
            padding-left: 5px;
        }
        
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 10px;
        }
        
        .grades-table th,
        .grades-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        
        .grades-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }
        
        .grades-table td.text-left {
            text-align: left;
        }
        
        .grades-table td.no-col {
            width: 25px;
        }
        
        .grades-table td.subject-col {
            width: 180px;
        }
        
        .grades-table td.grade-col {
            width: 40px;
        }
        
        .summary-section {
            border: 1px solid #000;
            padding: 10px;
            margin: 12px 0;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .summary-item {
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
        }
        
        .summary-label {
            font-size: 9px;
            margin-bottom: 3px;
        }
        
        .summary-value {
            font-size: 12px;
            font-weight: bold;
        }
        
        .footer-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-top: 30px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            height: 60px;
            margin: 20px 0 5px 0;
        }
        
        .keterangan {
            font-size: 12px;
            background-color: #ffffcc;
            padding: 8px;
            border: 1px solid #ccc;
            margin-top: 10px;
        }
        
        @media print {
            body { 
                margin: 0; 
                font-size: 10px;
            }
            .rapor-container { 
                box-shadow: none; 
                margin: 0;
                padding: 8mm;
                min-height: auto;
                page-break-inside: avoid;
            }
            .no-print { display: none !important; }
            
            .header-rapot {
                padding: 6px;
                margin-bottom: 10px;
            }
            
            .student-info {
                margin-bottom: 10px;
            }
            
            .grades-table {
                margin: 8px 0;
                font-size: 9px;
            }
            
            .grades-table th,
            .grades-table td {
                padding: 3px;
            }
            
            .summary-section {
                padding: 8px;
                margin: 8px 0;
            }
            
            .footer-section {
                margin-top: 10px;
            }
            
            .signature-line {
                height: 30px;
                margin: 8px 0 2px 0;
            }
            
            .keterangan {
                font-size: 12px;
                padding: 6px;
                margin-top: 8px;
            }
            
            /* Pastikan tidak ada page break */
            * {
                page-break-inside: avoid;
            }
            
            .rapor-container {
                page-break-inside: avoid;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        .status-info {
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 10px;
        }
        .back-button {
            position: fixed;
            top: 20px;
            right: 190px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak Report</button>
    <button class="back-button no-print" onclick="window.history.back()">Back</button>
    
    <div class="rapor-container">
        <!-- Header Rapor -->
        <div class="header-rapot">
            <div class="header-top">
                <!-- <div class="logo">
                    LOGO<br>SEKOLAH
                </div> -->
                <div class="school-info">
                    <div class="school-name">SMA OENTORO</div>
                    <div class="school-address">Jl. Wijaya Kusuma No. 48, Surabaya 60271</div>
                    <div class="school-address">Telp. (031) 5677394 | Email: sman1sby@education.id</div>
                    <div class="school-address">Website: www.sman1surabaya.sch.id</div>
                </div>
                <div class="rapor-title">Laporan Mata Pelajaran Guru</div>
            </div>
        </div>

        <!-- Informasi Siswa -->
        <div class="student-info">
            <div class="left-info">
                <div class="info-row">
                    <span class="info-label">Nama Guru</span>
                    <span class="info-value"><?= $guru->NAMA_GURU ?? 'NAMA GURU' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">ID</span>
                    <span class="info-value"><?= $guru->ID_GURU ?? 'ID' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Semester / Tahun</span>
                    <span class="info-value"><?= $periode->NAMA_PERIODE ?? 'Periode' ?></span>
                </div>
            </div>
            <div class="right-info">
                <div class="info-row">
                    <span class="info-label">Email Guru</span>
                    <span class="info-value"><?= $guru->EMAIL_GURU ?? 'EMAIL_GURU' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat Guru</span>
                    <span class="info-value"><?= $guru->ALAMAT_GURU ?? 'Alamat Guru' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon Guru</span>
                    <span class="info-value"><?= $guru->NO_TELPON_GURU ?? '081234567890' ?></span>
                </div>
            </div>
        </div>

        <!-- Tabel Nilai -->
        <table class="grades-table">
            <thead>
                <tr>
                    <th class="no-col">No.</th>
                    <th class="subject-col">Mata Pelajaran</th>
                    <th class="grade-col">Kelas</th>
                    <th class="grade-col">Rata-rata Nilai</th>
                    <th class="grade-col">Huruf</th>
                    <th style="width: 80px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                
                foreach($list_report as $report):
                    if($report->rata2 !== null) {
                        if($report->rata2 >= 90) {
                            $huruf = 'A';
                            $keterangan = 'Sangat Baik';
                        } elseif($report->rata2 >= 80) {
                            $huruf = 'B';
                            $keterangan = 'Baik';
                        } elseif($report->rata2 >= 70) {
                            $huruf = 'C';
                            $keterangan = 'Cukup';
                        } elseif($report->rata2 >= 60) {
                            $huruf = 'D';
                            $keterangan = 'Kurang';
                        } else {
                            $huruf = 'E';
                            $keterangan = 'Sangat Kurang';
                        }
                    } else {
                        $huruf = '-';
                        $keterangan = 'Belum Ada Nilai';
                    }
                ?>
                <tr>
                    <td class="no-col"><?= $no++ ?></td>
                    <td class="subject-col text-left"><?= $report->nama_pelajaran ?></td>
                    <td class="subject-col text-left"><?= $report->nama_kelas ?></td>
                    <td class="grade-col">
                        <?= $report->rata2 ? '<strong>' . number_format($report->rata2, 0) . '</strong>' : '<span style="color: #999;">-</span>' ?>
                    </td>
                    <td class="grade-col">
                        <?= $huruf != '-' ? '<strong>' . $huruf . '</strong>' : '<span style="color: #999;">-</span>' ?>
                    </td>
                    <td><?= $keterangan ?></td>
                </tr>
                <?php endforeach; ?>
                
                <!-- Baris kosong jika diperlukan -->
                <?php for($i = $jumlahMapel->jml; $i < 12; $i++): ?>
                <tr>
                    <td class="no-col"><?= $i + 1 ?></td>
                    <td class="subject-col text-left">-</td>
                    <td class="grade-col">-</td>
                    <td class="grade-col">-</td>
                    <td class="grade-col">-</td>
                    <td>-</td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- Ringkasan Hasil -->
        <div class="summary-section">
            <h4 style="text-align: center; margin-bottom: 15px;">RINGKASAN PENGAJARAN GURU</h4>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Total Mata Pelajaran</div>
                    <div class="summary-value"><?= $jumlahMapel->jml ?></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Mata Pelajaran Dinilai</div>
                    <div class="summary-value"><?= count($jumlahDinilai) ?></div>
                </div>
               </div>
               <div class="summary-item">
                   <div class="summary-label">Rata-rata Nilai</div>
                   <div class="summary-value"><?= number_format($rata2_all ?? 0, 1) ?></div>
               </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="footer-section">
            <div class="signature-box">
                <div>Mengetahui,</div>
                <div><strong>Kepala Sekolah</strong></div>
                <div class="signature-line"></div>
                <div><strong>Drs. Ahmad Wijaya, M.Pd</strong></div>
                <div>NIP. 196505151990031004</div>
            </div>
            <div class="signature-box">
                <div>Surabaya, <?= date('d F Y') ?></div>
                <div><strong>Guru</strong></div>
                <div class="signature-line"></div>
                <div><strong><?= $guru->NAMA_GURU ?? 'Nama Guru' ?></strong></div>
                <div>ID. <?= $guru->ID_GURU ?? '-' ?></div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="keterangan">
            <strong>Keterangan:</strong><br>
            • Nilai Akhir dihitung dengan rumus: (UTS × 40%) + (UAS × 40%) + (Tugas × 20%)<br>
            • Kriteria Penilaian: A (90-100), B (80-89), C (70-79), D (60-69), E (0-59)<br>
            • Batas Kelulusan: Rata-rata nilai minimal 70<br>
            • Total mata pelajaran: <?= $jumlahMapel->jml ?>, yang sudah dinilai: <?= count($jumlahDinilai) ?><br>
            • Report ini dicetak secara otomatis oleh sistem pada tanggal <?= date('d F Y, H:i:s') ?>
        </div>
    </div>

    <script>
        // Auto print ketika halaman dimuat (opsional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 1000);
        // }
    </script>
</body>
</html>