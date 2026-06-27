<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans';
            font-size: 13px;
            color: #1e293b;
            background: white;
            padding: 24px;
            line-height: 1.4;
        }

        .invoice-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
        }

        /* clearboth */
        .clearboth::after {
            content: "";
            clear: both;
            display: table;
        }

        /* header section */
        .header-left {
            float: left;
            width: 60%;
        }

        .header-right {
            float: right;
            width: 40%;
            text-align: right;
        }

        .company-name {
            font-size: 26px;
            font-weight: 800;
            color: #0f3b5c;
            margin: 0 0 6px 0;
        }

        .company-address {
            color: #475569;
            font-size: 12px;
            line-height: 1.5;
            margin-top: 4px;
        }

        .invoice-title {
            font-size: 36px;
            font-weight: 800;
            color: #1e5a8a;
            letter-spacing: 2px;
            margin: 0;
            padding: 8px 0;
            border-bottom: 2px solid #1e5a8a;
            display: inline-block;
        }

        .divider-light {
            clear: both;
            border-top: 1px solid #cbd5e1;
            margin: 10px 0;
        }

        /* info rows */
        .info-left {
            float: left;
            width: 60%;
        }

        .info-right {
            float: right;
            width: 40%;
            text-align: right;

        }

        .invoice-to-label {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e5a8a;
        }


        .customer-name {
            font-size: 18px;
            font-weight: 700;
            margin: 4px 0;
            color: #0c4a6e;
        }

        .info-text {
            color: #334155;
            font-size: 13px;
            line-height: 1.25;
        }

        .info-text p {
            margin: 5px 0;
            text-emphasis: wrap;
        }

        .invoice-details {
            float: right;
            background: #f8fafc;
            padding: 10px 16px;
            border-radius: 8px;
            display: inline-block;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        .invoice-details p {
            margin-bottom: 6px 0;
        }

        .invoice-details span {
            font-weight: 700;
            color: #0f3b5c;
        }

        /* table section */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 12px;
        }

        .items-table th {
            background-color: #ebefff;
            color: #1e5a8a;
            text-align: left;
            font-weight: bold;
        }

        .items-table td {
            color: #1f2937;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: end !important;
        }

        /* summary section */
        .summary-section {
            float: right;
            width: 40%;
            margin-top: 5px;
            border: 1px solid #e2e8f0;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            color: #475569;
            padding: 6px 15px;
            border-bottom: 1px solid #e2e8f0;
        }


        .summary-table td:last-child {
            text-align: right;
        }

        .summary-table tr:last-child td {
            border-bottom: none;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">

        <div class="clearboth">
            <div class="header-left">
                <h2 class="company-name">Inventory Shop</h2>
                <p class="company-address">
                    Contai, Purba Medinipur, West Bengal - 721444<br>
                    Phone: 8768103700<br>
                    Email: support@inventoryshop.in<br>
                </p>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
            </div>
        </div>

        <div class="divider-light"></div>


        <!-- Customer & Invoice Details -->
        <div class="clearboth">
            <div class="info-left">
                <div class="invoice-to-label">BILL TO:</div>
                <div class="customer-name">
                    {{ $order->customer->name }}
                </div>
                <div class="info-text">
                    <p>{{ $order->customer->addresses->first()?->address ?? 'N/A' }}<br>
                    <p>Phone: {{ $order->customer->mobile ?? 'N/A' }}</p>
                    {{-- <p>Email: {{ $order->customer->email }}</p> --}}

                    {{-- , {{ $order->customer->addresses[0]->city }},
                        {{ $order->customer->addresses[0]->pin_code }} --}}
                    </p>
                </div>
            </div>
            <div class="info-right">
                <div class="invoice-details">
                    <p><span>Invoice No:</span> {{ $order->code }}</p>
                    <p><span>Invoice Date: </span> {{ $order->date->format('F j, Y') }}</p>
                    <p><span>Order Status:<b> Paid</p>
                    <p><span>Payment Mode:<b> Cash</p>
                </div>
            </div>
        </div>

        <div class="divider-light"></div>

        <!-- order items table -->
        <table class="items-table">
            <thead>
                <tr class="heading">
                    <th class="text-center" style="width: 17%;">Product Code</th>
                    <th style="width: 43%;">Item</th>
                    <th class="text-center" style="width: 10%;">Qty</th>
                    <th class="text-right" style="width: 15%;">Unit Price</th>
                    <th class="text-right" style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $item)
                    <tr>
                        <td class="text-center">{{ $item->product->code }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹ {{ number_format($item->product->price, 2) }}</td>
                        <td class="text-right">₹ {{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach

                @foreach ($order->custom_items as $items)
                    <tr>
                        <td class="text-center">-</td>
                        <td>{{ $items['name'] }}</td>
                        <td class="text-center">{{ $items['qty'] }}</td>
                        <td class="text-right">₹ {{ number_format($items['price'], 2) }}</td>
                        <td class="text-right">₹ {{ number_format($items['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- summary section -->
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">₹ {{ number_format($order->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td>Platform fee</td>
                    <td class="text-right">₹ {{ number_format($order->additional_charges, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td class="text-right">&#8377; {{ number_format($order->discount, 2) }}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td class="text-right"> &#8377;
                        {{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
