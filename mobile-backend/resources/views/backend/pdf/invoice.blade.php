<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order_id }}</title>
    <!-- Đảm bảo font 'Noto Sans' cho tiếng Việt -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Vietnamese:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* Áp dụng font Noto Sans cho toàn bộ trang */
        * {
            font-family: 'Noto Sans', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans', sans-serif;
            margin: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        .content,
        .order-details {
            font-family: 'Noto Sans', sans-serif !important;
        }

        h1 {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h1>Hóa Đơn Thanh Toán</h1>
        <p>Mã đơn hàng: {{ $order_id }}</p>
        <p>Tên khách hàng: {{ $customer_name }}</p>
        <p>Ngày tạo: {{ $order_date }}</p>
        <p>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VND</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'], 0, ',', '.') }} VND</td>
                    <td>{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
