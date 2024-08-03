@php
    use Carbon\Carbon;
    $formattedDate = Carbon::parse($invoice->created_at)->format('F d, Y');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Faktur - {{ $invoice->nama_faktur }} - BadminZone</title>
    <style>
        @page {
            size: 420mm 297mm;
            margin: 0;
        }

        body {
            width: 100%;
            margin: 0;
            padding: 0;
        }


        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
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
            <div><span>HANDLE BY</span> {{ $invoice->handle_faktur }}</div>
            <div><span>EMAIL</span> <a
                    href="mailto:{{ $invoice->email_handle_faktur }}">{{ $invoice->email_handle_faktur }}</a></div>
            <div><span>DATE</span> {{ $formattedDate }}</div>
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
                    <td class="service">
                        {{ $invoice->pendapatan->persediaan->nama_barang ?? $invoice->pendapatan->deskripsi }}</td>
                    <td class="desc">{{ $invoice->pendapatan->deskripsi }}</td>
                    <td class="unit">Rp. {{ number_format($invoice->pendapatan->harga, 2) }}</td>
                    <td class="qty">{{ $invoice->pendapatan->jumlah }}</td>
                    <td class="total">
                        ${{ number_format($invoice->pendapatan->harga * $invoice->pendapatan->jumlah, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="grand total">TOTAL</td>
                    <td class="grand total">
                        ${{ number_format($invoice->pendapatan->harga * $invoice->pendapatan->jumlah, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        Faktur dibuat di komputer dan sah tanpa tanda tangan dan stempel.
    </footer>
</body>

</html>
