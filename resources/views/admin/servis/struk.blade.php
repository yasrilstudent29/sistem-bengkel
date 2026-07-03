<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Servis #{{ $servis->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a1a; padding: 30px; }

        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #183356; padding-bottom: 16px; }
        .header .logo { font-size: 20px; font-weight: bold; color: #183356; }
        .header .tagline { font-size: 11px; color: #666; margin-top: 2px; }
        .header .struk-title { font-size: 14px; font-weight: bold; margin-top: 10px; color: #fa7c20; }

        .section { margin-bottom: 16px; }
        .section-title { font-size: 11px; font-weight: bold; text-transform: uppercase; color: #183356; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; margin-bottom: 8px; letter-spacing: 0.5px; }

        .row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .label { color: #666; width: 45%; }
        .value { font-weight: bold; width: 55%; text-align: right; }

        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-proses { background: #dbeafe; color: #1e40af; }
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-diambil { background: #f3f4f6; color: #374151; }

        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table th { background: #183356; color: white; padding: 7px 8px; text-align: left; font-size: 11px; }
        table td { padding: 6px 8px; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
        table tr:last-child td { border-bottom: none; }

        .total-section { margin-top: 16px; border-top: 2px solid #183356; padding-top: 12px; }
        .total-row { display: flex; justify-content: space-between; align-items: center; }
        .total-label { font-size: 14px; font-weight: bold; color: #183356; }
        .total-value { font-size: 18px; font-weight: bold; color: #fa7c20; }

        .footer { margin-top: 24px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 12px; }
        .footer .thank-you { font-size: 12px; font-weight: bold; color: #183356; margin-bottom: 4px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="logo">⚙ Sistem Bengkel</div>
        <div class="tagline">Sistem Informasi Manajemen Bengkel & Servis Kendaraan</div>
        <div class="struk-title">STRUK SERVIS #{{ str_pad($servis->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>

    {{-- Info Servis --}}
    <div class="section">
        <div class="section-title">Informasi Servis</div>
        <div class="row">
            <span class="label">Tanggal Masuk</span>
            <span class="value">{{ $servis->tanggal_masuk->format('d M Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Tanggal Selesai</span>
            <span class="value">{{ $servis->tanggal_selesai?->format('d M Y') ?? '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Status</span>
            <span class="value">
                <span class="status-badge status-{{ $servis->status }}">
                    {{ ucfirst($servis->status) }}
                </span>
            </span>
        </div>
        <div class="row">
            <span class="label">Mekanik</span>
            <span class="value">{{ $servis->mekanik->nama }}</span>
        </div>
    </div>

    {{-- Info Customer & Kendaraan --}}
    <div class="section">
        <div class="section-title">Data Customer & Kendaraan</div>
        <div class="row">
            <span class="label">Nama Customer</span>
            <span class="value">{{ $servis->kendaraan->user->customer->nama_lengkap ?? $servis->kendaraan->user->name }}</span>
        </div>
        <div class="row">
            <span class="label">No. Telepon</span>
            <span class="value">{{ $servis->kendaraan->user->customer->no_telepon ?? '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Kendaraan</span>
            <span class="value">{{ $servis->kendaraan->tahun }} {{ $servis->kendaraan->merek }} {{ $servis->kendaraan->model }}</span>
        </div>
        <div class="row">
            <span class="label">Plat Nomor</span>
            <span class="value">{{ $servis->kendaraan->plat_nomor }}</span>
        </div>
    </div>

    {{-- Keluhan & Catatan --}}
    <div class="section">
        <div class="section-title">Keluhan & Catatan</div>
        <div class="row">
            <span class="label">Keluhan</span>
            <span class="value">{{ $servis->keluhan }}</span>
        </div>
        @if ($servis->catatan_mekanik)
            <div class="row">
                <span class="label">Catatan Mekanik</span>
                <span class="value">{{ $servis->catatan_mekanik }}</span>
            </div>
        @endif
    </div>

    {{-- Spare Parts --}}
    @if ($servis->spareParts->count() > 0)
        <div class="section">
            <div class="section-title">Spare Part Digunakan</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Part</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Harga Satuan</th>
                        <th style="text-align:right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servis->spareParts as $part)
                        <tr>
                            <td>{{ $part->nama }}</td>
                            <td style="text-align:center">{{ $part->pivot->jumlah }}</td>
                            <td style="text-align:right">Rp {{ number_format($part->pivot->harga_satuan, 0, ',', '.') }}</td>
                            <td style="text-align:right">Rp {{ number_format($part->pivot->jumlah * $part->pivot->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Total --}}
    <div class="total-section">
        <div class="total-row">
            <span class="total-label">TOTAL BIAYA</span>
            <span class="total-value">Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <div class="thank-you">Terima kasih telah mempercayai kami!</div>
        <div>Dicetak pada {{ now()->format('d M Y, H:i') }} WIB</div>
        <div>Sistem Bengkel — Sistem Informasi Manajemen Bengkel & Servis Kendaraan</div>
    </div>

</body>
</html>