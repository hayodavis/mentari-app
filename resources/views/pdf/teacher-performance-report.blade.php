<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendampingan - {{ $teacher->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; position: relative; }
        .logo { position: absolute; left: 20px; top: 0; height: 70px; }
        .school { font-size: 16px; font-weight: bold; text-transform: uppercase; line-height: 1.4; }
        .title { text-align: center; margin: 25px 0 10px; font-size: 14pt; font-weight: bold; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #f0f0f0; text-align: center; }
        .status-pending { color: #b58900; font-weight: bold; }
        .status-inprogress { color: #0074D9; font-weight: bold; }
        .status-done { color: #2E8B57; font-weight: bold; }
        .rekap { margin-top: 20px; border: 1px solid #999; width: 50%; font-size: 12px; }
        .rekap th, .rekap td { border: 1px solid #999; padding: 6px; text-align: left; }
        .rekap th { background: #f8f8f8; }
        .footer { margin-top: 50px; width: 100%; text-align: right; font-size: 12px; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <img src="{{ public_path('images/logo-smkn2bangkalan.png') }}" class="logo">
        <div class="school">
            SMK NEGERI 2 BANGKALAN<br>
            LAPORAN PENDAMPINGAN SISWA
        </div>
    </div>

    <!-- JUDUL -->
    <div class="title">
        Laporan Pendampingan Guru Wali - {{ $teacher->name }}
    </div>

    <p><strong>Tanggal Cetak:</strong> {{ $date }}</p>

    <!-- TABEL CATATAN -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Topik</th>
                <th>Catatan</th>
                <th>Tindak Lanjut</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rekap = ['pending' => 0, 'in_progress' => 0, 'done' => 0];
            @endphp
            @forelse($assistances as $i => $a)
                @php
                    $statusMap = [
                        'pending' => ['label' => 'Pending', 'class' => 'status-pending'],
                        'in_progress' => ['label' => 'Sedang Diproses', 'class' => 'status-inprogress'],
                        'done' => ['label' => 'Selesai', 'class' => 'status-done'],
                    ];
                    $status = $statusMap[$a->status] ?? ['label' => ucfirst($a->status), 'class' => ''];
                    $rekap[$a->status] = ($rekap[$a->status] ?? 0) + 1;
                @endphp
                <tr>
                    <td style="text-align: center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $a->student->name ?? '—' }}</td>
                    <td>{{ $a->student->classroom->name ?? '—' }}</td>
                    <td>{{ $a->topic }}</td>
                    <td>{{ $a->notes ?: '—' }}</td>
                    <td>{{ $a->follow_up ?: '—' }}</td>
                    <td style="text-align: center" class="{{ $status['class'] }}">{{ $status['label'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:gray;">Tidak ada data pendampingan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- REKAP RINGKAS -->
    <table class="rekap" style="margin-top: 25px;">
        <tr><th colspan="2" style="text-align:center;">Rekap Status Pendampingan</th></tr>
        <tr><td>Pending</td><td>{{ $rekap['pending'] }}</td></tr>
        <tr><td>Sedang Diproses</td><td>{{ $rekap['in_progress'] }}</td></tr>
        <tr><td>Selesai</td><td>{{ $rekap['done'] }}</td></tr>
        <tr><th>Total</th><th>{{ array_sum($rekap) }}</th></tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Bangkalan, {{ $date }}<br>
        Kepala SMK Negeri 2 Bangkalan</p>
        <p style="margin-top:60px;">
            <b><u>Nur Hazizah, S.Pd., M.Pd.</u></b><br>
            NIP 19691218 199703 2 006
        </p>
    </div>

</body>
</html>
