<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Karyawan - Print</title>
    <style>
        @media print {
            .no-print { display: none; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        
        .header h2 {
            margin: 5px 0;
        }
        
        .info {
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature {
            margin-top: 80px;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px;">
            🖨️ Print Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; background: #6c757d; color: white; border: none; cursor: pointer; border-radius: 5px; margin-left: 10px;">
            ✖️ Tutup
        </button>
    </div>
    
    <!-- Header -->
    <div class="header">
        <h2>SISTEM MANAJEMEN KEPEGAWAIAN</h2>
        <h3>LAPORAN DATA KARYAWAN</h3>
    </div>
    
    <!-- Info -->
    <div class="info">
        <table style="border: none; width: 50%;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;"><strong>Tanggal Cetak</strong></td>
                <td style="border: none;">: <?= $tanggal_cetak ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Karyawan</strong></td>
                <td style="border: none;">: <?= count($karyawans) ?> orang</td>
            </tr>
        </table>
    </div>
    
    <!-- Table Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Lengkap</th>
                <th style="width: 15%;">Departemen</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 12%;">Tgl Lahir</th>
                <th style="width: 12%;">Tgl Masuk</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($karyawans)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data karyawan</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($karyawans as $k): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($k['Nama_Lengkap']) ?></td>
                        <td><?= htmlspecialchars($k['Nama_Departemen'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($k['Email_Kantor']) ?></td>
                        <td><?= date('d/m/Y', strtotime($k['Tgl_Lahir'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($k['Tgl_Masuk'])) ?></td>
                        <td><?= htmlspecialchars($k['Status_Kerja']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        <p>Jakarta, <?= date('d F Y') ?></p>
        <div class="signature">
            <p style="margin: 0;">Mengetahui,</p>
            <p style="margin: 0;"><strong>Manager HRD</strong></p>
            <div class="signature-line"></div>
            <p style="margin-top: 5px;">( _________________ )</p>
        </div>
    </div>
    
    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>