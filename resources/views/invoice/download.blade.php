<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        body,
        table,
        th,
        td {
            font-family: 'San Francisco', Arial, sans-serif;
        }

        #header {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        .order_id,
        .invoice,
        .date,
        .value_date,
        .value_balance_due,
        .balance_due {
            text-align: right;
        }

        .invoice {
            font-size: 30px;
        }

        .order_id,
        .bill_to {
            color: #696969;
        }

        .date,
        .balance_due {
            width: 40%;
        }

        .value_date,
        .value_balance_due {
            width: 20%;
        }

        .balance_due,
        .value_balance_due {
            font-weight: bold;
            font-size: 18px;
        }

        #item {
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            font-size: 14px;
        }

        #item thead {
            background-color: #555;
            color: white;
        }

        #item th,
        #item td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        #item th {
            text-align: center;
        }

        #item tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #item tbody tr:hover {
            background-color: #ddd;
        }

        .item_price,
        .item_total {
            text-align: right;
        }

        .item_qty {
            text-align: center;
        }

        #payment {
            font-size: 10px;
        }

        .terms {
            color: #696969;
        }
    </style>
</head>

<body>
    <table id="header">
        <tr>
            <td rowspan="4">
                <img src="{{ $logo }}">
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="invoice" colspan="2">
                INVOICE
            </td>
        </tr>
        <tr>
            <td class="order_id" colspan="2">
                # {{ $invoice['order_id'] }}
            </td>
        </tr>
        <tr>
            <td>
                <b>{{ $invoice['brand_name'] }}</b>
                <br>
                {{ $invoice['brand_address'] }}
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td rowspan="3">
                <span class="bill_to">Bill To:</span>
                <br>
                <b>{{ $invoice['customer_name'] }}</b>
            </td>
            <td class="date">Date :</td>
            <td class="value_date">{{ \Carbon\Carbon::parse($invoice['date'])->format('d - m - Y') }}</td>
        </tr>
        <tr>
            <td class="date">Due Date :</td>
            <td class="value_date">{{ \Carbon\Carbon::parse($invoice['due_date'])->format('d - m - Y') }}</td>
        </tr>
        <tr>
            <td class="balance_due">Balance Due :</td>
            <td class="value_balance_due">IDR {{ number_format($invoice['total'], 2) }}</td>
        </tr>
    </table>

    <br><br>

    <table id="item">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail_invoices as $item)
                <tr>
                    <td>{{ $item['item_name'] }} - Size {{ $item['item_size'] }}</td>
                    <td class="item_qty">{{ $item['qty'] }}</td>
                    <td class="item_price">IDR {{ number_format($item['price'], 2) }}</td>
                    <td class="item_total">IDR {{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table id="payment">
        <tr>
            <td class="terms">Terms:</td>
        </tr>
        <tr>
            <td>Pembayaran:</td>
        </tr>
        <tr>
            <td>
                @foreach (json_decode($invoice['brand_rekenings']) as $key => $rekening)
                    @if ($key === 0)
                        {{ $rekening->rekening }}
                    @else
                        <br>{{ $rekening->rekening }}
                    @endif
                @endforeach
            </td>
        </tr>
    </table>
</body>

</html>
