<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .mb-3 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-top: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="text-center mb-3">
        <h2>Your Company Name</h2>
        <p>123 Your Street, Your City</p>
        <p>Tel: (123) 456-7890</p>
    </div>

    <div class="mb-3">
        <p><strong>Customer:</strong> {{ $customer_name }}</p>
        <p><strong>Date:</strong> {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>${{ number_format($item['price'], 2) }}</td>
                <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
            </tr>
            @php $total += $item['price'] * $item['quantity']; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total</td>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mb-3" style="margin-top: 20px;">
        <p>Thank you for your business!</p>
        <p>Please come again</p>
    </div>
</body>

</html>