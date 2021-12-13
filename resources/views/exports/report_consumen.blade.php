<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    
    <table>
        <thead>
            <tr><th colspan="9">Laporan Penjualan dari tanggal {{date_format(date_create(@$start_date), 'd F Y')}} sampai {{date_format(date_create(@$end_date), 'd F Y')}}</th></tr>
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
                <td>{{date_format(date_create(@$item->created_at), 'd F Y')}}</td>
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