<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Homecare - Tukangku</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: 16px;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: 16px;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"><img src="https://harmonisproperty.com/assets/img/ic_logo.png" alt="" width="150"/></td>
        <td align="right">
            <h3>{{$order->invoice_code}} - @if ($order->status_order=='done')
              <span style="color: green">SELESAI</span>
              @elseif($order->status_order=='cancel')
              <span style="color: red">BATAL</span>
              @else
              <span style="color: orange">DIPROSES</span>
            @endif
          </h3>
          <p>{{date_format(date_create(@$order->created_at), 'Y-m-d H:i:s')}}</p>
            <pre>
                Tukang Kita
                Jalan HR Muhammad
                081273328123
                tukangkita@harmonisproperty.com
            </pre>
        </td>
    </tr>

  </table>
@isset($order->user)
<table width="100%">
  <tr>
      <td>{{@$order->user->name}}</td>
  </tr>
  <tr>
      <td>{{@$order->user->address}}</td>
  </tr>
  <tr>
      <td>{{@$order->user->number}}</td>
  </tr>

</table>
@endisset

  <br/>

<table width="100%">
  <thead style="background-color: lightgray;">
    <tr>
      <th>#</th>
      <th>Nama Layanan</th>
      <th>Durasi Layanan</th>
      <th>Harga</th>
      <th>Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @if (count($order->orderdetails))
    @foreach (@$order->orderdetails as $item)
        <tr>
          <th scope="row">{{$loop->iteration}}</th>
          <td>{{@$item->service->name}}</td>
          <td align="right">{{@$item->quantity}} {{@$item->service->type_quantity}}</td>
          <td align="right">Rp. {{number_format(@$item->price)}}</td>
          <td align="right">Rp. {{number_format(@$item->total_price)}}</td>
        </tr>
        {{-- <tr>
            <th scope="row">2</th>
            <td>Service AC</td>
            <td align="right">1 Layanan</td>
            <td align="right">Rp. 50.000,00</td>
            <td align="right">Rp. 50.000,00</td>
        </tr>
         --}}
    @endforeach
  </tbody>
  <tfoot>
      <tr>
          <td colspan="3"></td>
          <td align="right">Total Bayar</td>
          <td align="right" class="gray">Rp. {{number_format($order->orderdetails->sum('total_price'))}}</td>
      </tr>
  </tfoot>
</table> 
@endif
  <br/>
<div style="margin-top: 25px;"> </div>
@if (count($order->payments))
<table width="100%">
  <tr>
      <td>Detail Pembayaran Layanan</td>
  </tr>
  

</table>
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>Tanggal Pembayaran</th>
        <th>Kode Pembayaran</th>
        <th>Jenis Pembayaran</th>
        <th>Tipe Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Total Bayar</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($order->payments as $item)
      <tr>
        <td scope="row">{{date_format(date_create(@$item->created_at), 'Y-m-d H:i:s')}}</td>
        <td>{{$item->payment_code}}</td>
        <td align="right">{{$item->type}}</td>
        <td align="right">{{$item->type_transfer}}</td>
        <td align="right">{{$item->status_payment}}</td>
        <td align="right">Rp. {{number_format($item->total_payment)}}</td>
      </tr>
      @endforeach
      
    </tbody>

    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td align="right">Total Bayar</td>
            <td align="right" class="gray">Rp. {{number_format($order->payments->sum('total_payment'))}}</td>
        </tr>
    </tfoot>
  </table>
@endif
</body>
</html>