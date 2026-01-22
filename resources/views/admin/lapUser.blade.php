<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .kop img {
            height: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .kop h1 {
            display: inline-block;
            font-size: 22px;
            vertical-align: middle;
            margin: 0;
        }

        .kop p {
            margin: 2px 0;
            font-size: 12px;
        }

        .tanggal {
            text-align: right;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            border: none;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- KOP --}}
    <div class="kop">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <h1>CHICKin</h1>
        <p>Sistem Manajemen User</p>
        <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>
    </div>

    {{-- TANGGAL --}}
    <div class="tanggal">
        Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    {{-- JUDUL --}}
    <h3 style="text-align:center; margin-bottom:15px;">
        LAPORAN DATA USER
    </h3>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td> {{-- nomor urut --}}
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="ttd">
        <tr>
            <td width="60%"></td>
            <td>
                <p>Mengetahui,</p>
                <br><br><br>
                <p><b>____________________</b></p>
                <p>Admin</p>
            </td>
        </tr>
    </table>

</body>
</html>
