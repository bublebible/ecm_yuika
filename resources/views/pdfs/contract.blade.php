<!DOCTYPE html>
<html>
<head>
    <title>Kontrak Sewa</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { font-size: 14px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .signature { margin-top: 50px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT PERJANJIAN SEWA KOSTUM</h2>
        <p>No: {{ $rental->id }}/RENT/{{ date('Y') }}</p>
    </div>

    <div class="content">
        <p>Kami yang bertanda tangan di bawah ini:</p>
        <p><b>Pihak Pertama (Penyewa):</b><br>
        Nama: {{ $rental->user->name }}<br>
        Email: {{ $rental->user->email }}<br>
        Telepon: {{ $rental->user->phone ?? '-' }}<br>
        Alamat: {{ $rental->user->address ?? '-' }}</p>

        <p><b>Pihak Kedua (Pemilik):</b><br>
        Nama: Rental Kostum ECM<br>
        Alamat: Jl. Contoh No. 123</p>

        <p>Menyepakati penyewaan aset sebagai berikut:</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Aset</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rental->items as $item)
                <tr>
                    <td>{{ $item->asset->name }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><b>Durasi Sewa:</b> {{ $rental->start_date->format('d M Y') }} s/d {{ $rental->end_date->format('d M Y') }}</p>
        <p><b>Total Biaya:</b> Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>

        <p>Penyewa bertanggung jawab penuh atas kerusakan atau kehilangan selama masa sewa sesuai dengan ketentuan yang berlaku.</p>

        <div class="signature">
            <div style="float:left; width: 40%;">
                <p>Penyewa,</p>
                <br><br><br>
                <p>({{ $rental->user->name }})</p>
            </div>
            <div style="float:right; width: 40%;">
                <p>Pemilik,</p>
                <br><br><br>
                <p>(Staf Admin)</p>
            </div>
        </div>
    </div>
</body>
</html>
