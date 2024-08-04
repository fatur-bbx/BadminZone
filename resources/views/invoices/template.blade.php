@php
    use Carbon\Carbon;
    $formattedDate = Carbon::parse($invoice->created_at)->format('F d, Y');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Faktur - {{ $invoice->nama_faktur }} - BadminZone</title>
    <link rel="stylesheet" href="{{ asset('css/invoice/style.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <h2>BadminZone</h2>
    </div>
    <h1>Faktur {{ $invoice->nama_faktur }}</h1>
    <div id="company" class="clearfix">
        <div>BadminZone</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">badminzone@gmail.com</a></div>
    </div>
    <div id="project">
        <div><span>HANDLE BY</span> {{$invoice->handle_faktur}}</div>
        <div><span>EMAIL</span> <a href="mailto:{{$invoice->email_handle_faktur}}">{{$invoice->email_handle_faktur}}</a></div>
        <div><span>DATE</span> {{$formattedDate}}</div>
    </div>
</header>
<main>
    <table>
        <thead>
            <tr>
                <th class="service">SERVICE</th>
                <th class="desc">DESCRIPTION</th>
                <th>PRICE</th>
                <th>QTY</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="service">{{ $invoice->pendapatan->persediaan->nama_barang ?? $invoice->pendapatan->deskripsi }}</td>
                <td class="desc">{{ $invoice->pendapatan->deskripsi }}</td>
                <td class="unit">Rp. {{ number_format($invoice->pendapatan->harga, 2) }}</td>
                <td class="qty">{{ $invoice->pendapatan->jumlah }}</td>
                <td class="total">Rp. {{ number_format($invoice->pendapatan->harga * $invoice->pendapatan->jumlah, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="grand total">TOTAL</td>
                <td class="grand total">Rp. {{ number_format($invoice->pendapatan->harga * $invoice->pendapatan->jumlah, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('invoices.download', $invoice->id_faktur) }}">Download PDF</a>
</main>
<footer>
    Faktur dibuat di komputer dan sah tanpa tanda tangan dan stempel.
</footer>
</body>
</html>
