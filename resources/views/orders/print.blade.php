<!DOCTYPE html>
<html>
<head>
    <title>Orden #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin: 20px 0;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        .items {
            margin: 20px 0;
        }
        .item {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }
        .notes {
            font-size: 12px;
            color: #666;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Restaurante Vastago</h1>
        <p>Orden #{{ $order->id }}</p>
        <p>Mesa {{ $order->table->number }}</p>
        <div class="details">
            <p>Mesero: {{ $order->user->name }}</p>
            <p>Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="items">
        @foreach($order->items as $item)
        <div class="item">
            <div>
                <span>{{ $item->quantity }}x {{ $item->product->name }}</span>
                @if($item->notes)
                <div class="notes">{{ $item->notes }}</div>
                @endif
            </div>
            <span>${{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>

    <div class="total">
        Total: ${{ number_format($order->total, 0, ',', '.') }}
    </div>

    <button class="no-print" onclick="window.print()">Imprimir</button>
</body>
</html>
