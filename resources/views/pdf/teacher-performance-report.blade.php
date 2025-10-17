<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendampingan - {{ $teacher->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; }
        .logo { float: left; height: 70px; }
        .school { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .title { text-align: center; margin-bottom: 10px; font-size: 14pt; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #f0f0f0; text-align: center; }
        .footer { margin-top: 40px; width: 100%; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo-smkn2bangkalan.png') }}" class="logo">
        <div class="school">
            SMK NEGERI 2 BANGKALAN<br>
            LAPORAN PENDAMPINGAN SISWA
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="title">
        Laporan Pendampingan Guru Wali - {{ $teacher->name }}
    </div>

    <p><strong>Tanggal Cetak:</strong> {{ $date }}</p>

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
            @forelse($assistances as $i => $a)
                <tr>
                    <td style="text-align: center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $a->student->name ?? '—' }}</td>
                    <td>{{ $a->student->classroom->name ?? '—' }}</td>
                    <td>{{ $a->topic }}</td>
                    <td>{{ $a->notes ?: '—' }}</td>
                    <td>{{ $a->follow_up ?: '—' }}</td>
                    <td style="text-align: center">{{ ucfirst(str_replace('_', ' ', $a->status)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:gray;">Tidak ada data pendampingan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Bangkalan, {{ $date }}<br>
        Kepala SMK Negeri 2 Bangkalan<p/>
        <p style="margin-top:60px;"><b><u>Nur Hazizah,S.Pd., M.Pd.</b></u><br>
        NIP 196912181997032006</p>
    </div>

</body>
</html>
