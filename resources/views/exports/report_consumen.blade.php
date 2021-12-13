<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div>
        Report Order Consumen
    </div>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Nama Konsumen</th>
            <th>Email</th>
            <th>No Hp</th>
            <th>Alamat</th>
            <th>Jenis Jasa</th>
            <th>Status</th>
            <th>Harga Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orderdetails as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ @$item->created_at }}</td>
                <td>{{ @$item->order->user->name }}</td>
                <td>{{ @$item->order->user->email }}</td>
                <td>{{ @$item->order->user->number }}</td>
                <td>{{ @$item->order->user->address }}</td>
                <td>{{ @$item->service->name }}</td>
                <td>{{ @$item->status_order_detail }}</td>
                <td>{{ @$item->total_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>