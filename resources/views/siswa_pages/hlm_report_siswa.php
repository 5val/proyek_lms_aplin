<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Siswa</title>
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
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak Rapor</button>
    <button class="back-button no-print" onclick="window.history.back()">Back</button>

    <div class="rapor-container">
        <!-- Header Rapor -->
        <div class="header-rapot">
            <div class="header-top">
                <!-- <div class="logo">
                    LOGO<br>SEKOLAH
                </div> -->
                <div class="school-info">
                    <div class="school-name">Zona AI School</div>
                    <div class="school-address">Jl. Wijaya Kusuma No. 48, Surabaya 60271</div>
                    <div class="school-address">Telp. (031) 5677394 | Email: sman1sby@education.id</div>
                    <div class="school-address">Website: www.sman1surabaya.sch.id</div>
                </div>
                <div class="rapor-title">RAPOR SISWA</div>
            </div>
        </div>

        <!-- Informasi Siswa -->
        <div class="student-info">
            <div class="left-info">
                <div class="info-row">
                    <span class="info-label">Nama Siswa</span>
                    <span class="info-value"><?= $siswa->NAMA_SISWA ?? 'NAMA SISWA' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">NIS</span>
                    <span class="info-value"><?= $siswa->ID_SISWA ?? 'NIS' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kelas</span>
                    <span class="info-value"><?= $waliKelas->NAMA_KELAS ?? ($nilaiSiswa->first()->NAMA_KELAS ?? 'Nama Kelas') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Semester / Tahun</span>
                    <span class="info-value"><?= $selectedPeriodeInfo->PERIODE ?? ($nilaiSiswa->first()->PERIODE ?? 'Periode') ?></span>
                </div>
            </div>
            <div class="right-info">
                <div class="info-row">
                    <span class="info-label">Wali Kelas</span>
                    <span class="info-value"><?= $waliKelas->NAMA_WALI_KELAS ?? 'Nama Wali Kelas' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value"><?= $siswa->ALAMAT_SISWA ?? 'Alamat Siswa' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon</span>
                    <span class="info-value"><?= $siswa->NO_TELPON_SISWA ?? '081234567890' ?></span>
                </div>
            </div>
        </div>

        <!-- Tabel Nilai -->
        <?php
            $nilaiData = isset($nilaiSiswaDisplay) ? $nilaiSiswaDisplay : $nilaiSiswa;
            $minimumMapel = $minimumMataPelajaran ?? 10;
            $totalMapelDiambil = $totalMataPelajaranDiambil ?? count($nilaiSiswa ?? []);
        ?>

        <table class="grades-table">
            <thead>
                <tr>
                    <th class="no-col">No.</th>
                    <th class="subject-col">Mata Pelajaran</th>
                    <th class="grade-col">UTS<br>(40%)</th>
                    <th class="grade-col">UAS<br>(40%)</th>
                    <th class="grade-col">Tugas<br>(20%)</th>
                    <th class="grade-col">Nilai<br>Akhir</th>
                    <th class="grade-col">Huruf</th>
                    <th style="width: 80px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $totalNilai = 0;
                $jumlahMapelDenganNilai = 0;
                $jumlahMapel = count($nilaiData);

                foreach($nilaiData as $nilai):
                    $isPlaceholder = property_exists($nilai, 'IS_PLACEHOLDER') && $nilai->IS_PLACEHOLDER;
                    $nilaiAkhir = $isPlaceholder ? null : $nilai->NILAI_AKHIR;
                    $namaMapel = $isPlaceholder ? 'Mata pelajaran belum dipilih' : $nilai->NAMA_PELAJARAN;

                    if(!$isPlaceholder && $nilaiAkhir !== null) {
                        $totalNilai += $nilaiAkhir;
                        $jumlahMapelDenganNilai++;

                        if($nilaiAkhir >= 90) {
                            $huruf = 'A';
                            $keterangan = 'Sangat Baik';
                        } elseif($nilaiAkhir >= 80) {
                            $huruf = 'B';
                            $keterangan = 'Baik';
                        } elseif($nilaiAkhir >= 70) {
                            $huruf = 'C';
                            $keterangan = 'Cukup';
                        } elseif($nilaiAkhir >= 60) {
                            $huruf = 'D';
                            $keterangan = 'Kurang';
                        } else {
                            $huruf = 'E';
                            $keterangan = 'Sangat Kurang';
                        }
                    } else {
                        $huruf = '-';
                        $keterangan = $isPlaceholder ? 'Belum diambil' : 'Belum Ada Nilai';
                    }
                ?>
                <tr>
                    <td class="no-col"><?= $no++ ?></td>
                    <td class="subject-col text-left"><?= $namaMapel ?></td>
                    <td class="grade-col"><?= (!$isPlaceholder && $nilai->NILAI_UTS) ? number_format($nilai->NILAI_UTS, 0) : '-' ?></td>
                    <td class="grade-col"><?= (!$isPlaceholder && $nilai->NILAI_UAS) ? number_format($nilai->NILAI_UAS, 0) : '-' ?></td>
                    <td class="grade-col"><?= (!$isPlaceholder && $nilai->NILAI_TUGAS) ? number_format($nilai->NILAI_TUGAS, 0) : '-' ?></td>
                    <td class="grade-col">
                        <?= $nilaiAkhir ? '<strong>' . number_format($nilaiAkhir, 0) . '</strong>' : '<span style="color: #999;">-</span>' ?>
                    </td>
                    <td class="grade-col">
                        <?= $huruf != '-' ? '<strong>' . $huruf . '</strong>' : '<span style="color: #999;">-</span>' ?>
                    </td>
                    <td><?= $keterangan ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ringkasan Hasil -->
        <div class="summary-section">
            <h4 style="text-align: center; margin-bottom: 15px;">RINGKASAN HASIL BELAJAR</h4>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Total Mata Pelajaran</div>
                    <div class="summary-value"><?= $totalMataPelajaran ?> <span style="font-size: 9px; font-weight: 400;">(diambil: <?= $totalMapelDiambil ?>, minimal <?= $minimumMapel ?>)</span></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Mata Pelajaran Dinilai</div>
                    <div class="summary-value"><?= $mataPelajaranDenganNilai ?></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Rata-rata Nilai</div>
                    <div class="summary-value"><?= number_format($rataRataNilai ?? 0, 1) ?></div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <strong>Status Kelulusan:</strong><br>
                    <?php
                    $rataRata = $rataRataNilai ?? 0;
                    $status = $statusKelulusan;
                    echo '<span style="font-size: 14px; color: ' . ($status == 'LULUS' ? 'green' : 'red') . ';"><strong>' . $status . '</strong></span>';
                    ?>
                </div>
                <div>
                    <strong>Catatan:</strong><br>
                    <div style="font-size: 12px; color: #666; margin-top: 5px;">
                        <?php
                            $belumDinilai = max(0, $totalMapelDiambil - $mataPelajaranDenganNilai);
                            $kurangMapel = max(0, $minimumMapel - $totalMapelDiambil);

                            if($kurangMapel > 0) {
                                echo "Perlu menambah {$kurangMapel} mata pelajaran lagi untuk memenuhi minimal {$minimumMapel}.<br>";
                            }

                            if($belumDinilai > 0) {
                                echo "Masih ada {$belumDinilai} mata pelajaran yang belum dinilai.";
                            } else {
                                echo "Semua mata pelajaran yang diambil sudah dinilai.";
                            }
                        ?>
                    </div>
                </div>
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
                <div><strong>Wali Kelas</strong></div>
                <div class="signature-line"></div>
                <div><strong><?= $waliKelas->NAMA_WALI_KELAS ?? 'Nama Wali Kelas' ?></strong></div>
                <div>NIP. <?= $waliKelas->ID_WALI_KELAS ?? '-' ?></div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="keterangan">
            <strong>Keterangan:</strong><br>
            • Nilai Akhir dihitung dengan rumus: (UTS × 40%) + (UAS × 40%) + (Tugas × 20%)<br>
            • Kriteria Penilaian: A (90-100), B (80-89), C (70-79), D (60-69), E (0-59)<br>
            • Batas Kelulusan: Rata-rata nilai minimal 70<br>
            • Total mata pelajaran (ditampilkan minimal <?= $minimumMapel ?>): <?= $totalMataPelajaran ?>, diambil: <?= $totalMapelDiambil ?>, sudah dinilai: <?= $mataPelajaranDenganNilai ?><br>
            • Rapor ini dicetak secara otomatis oleh sistem pada tanggal <?= date('d F Y, H:i:s') ?>
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
