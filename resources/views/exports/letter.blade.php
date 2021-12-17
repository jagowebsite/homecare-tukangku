<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Homecare - Tukangku</title>
   
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        .gray {
            background-color: lightgray
        }

    </style>
   
</head>

<body>
    <table width="100%">
        <tr>
            <td style="position: relative;">
                <img src="https://harmonisproperty.com/assets/img/ic_logo.png" alt="" width="120" style="position: absolute"/>
                <div align="center" style="margin-top:25px;margin-bottom:5px;">
                    <h4 style="margin-bottom:1px;margin-top:1px;">HARMONIS PROPERTY</h4>
                <h4 style="margin-bottom: 1px;margin-top:1px;">TUKANGKU</h4>
                <p style="font-size: 14px;margin-bottom:0px;margin-top:0px;">Btn Keban Agung Kecataman Lawang Kidul</p>
                <p style="font-size: 14px;margin-bottom:0px;margin-top:0px;">Tlp. 2538779254. Email. tukangkita@harmonisproperty.com</p>
                </div>
            </td>
        </tr>
      </table>
    {{-- <div class="row mt-3 w-100">
        <div class="col-2">
            <img src="https://harmonisproperty.com/assets/img/ic_logo.png" alt="" width="100" />
        </div>
        <div class="col-8 text-center">
            <h5>HARMONIS PROPERTY</h5>
            <h5>TUKANGKU</h5>
            <p class="mb-0" style="font-size: 12px;">Btn Keban Agung Kecataman Lawang Kidul</p>
            <p class="mb-0" style="font-size: 12px;">Tlp. 2538779254. Email. tukangkita@harmonisproperty.com</p>
        </div>
        <div class="col-2"></div>
    </div> --}}
    <div width='100%' style="border:1.5px solid black;margin-top:5px;margin-bottom:10px;"></div>
    <br />
    <table width="100%">
        <tr>
            <td align="center" >
                <p style="margin-bottom:1px;font-weight: bold;">SURAT TUGAS</p> 
                <p style="margin-top:0px;">Nomor: {{@$orderconfirmation->orderdetail->order->invoice_code}}</p> 
            </td>
        </tr>
      </table>
    {{-- <div class="row mt-4 w-100">
        <div class="col-12 text-center">
            <h5>SURAT TUGAS</h5>
        </div>
    </div> --}}
    {{-- <br /> --}}
    <table width="100%">
        <tr>
            <td colspan="2">
                <p style="margin-bottom:1px;">Berdasarkan surat tugas ini,saya sebagai teknisi / layanan yang akan ditugaskan di tempat Bapak / Ibu sebagai berikut.</p> 
            </td>
        </tr>
        <tr>
            <td width="20%">Nama</td>
            <td>: {{strtoupper(@$orderconfirmation->employee->name)}}</td>
        </tr>
        <tr>
            <td width="20%">Jabatan</td>
            <td>: KARYAWAN</td>
        </tr>
        <tr>
            <td width="20%">Unit Kerja</td>
            <td>: {{strtoupper(@$orderconfirmation->service->servicecategory->name)}}</td>
        </tr>
        <tr>
            <td width="20%">Tugas/Layanan</td>
            <td>: {{strtoupper(@$orderconfirmation->service->name)}}</td>
        </tr>
        <tr>
            <td width="20%">Durasi Layanan</td>
            <td>: {{$orderconfirmation->work_duration}} {{$orderconfirmation->type_work_duration}}</td>
        </tr>
        <tr>
            <td width="20%">Tempat</td>
            <td>: {{@$orderconfirmation->orderdetail->order->payments[0]->address ?? @$orderconfirmation->orderdetail->order->user->address}}</td>
        </tr>
        <tr>
            <td width="20%">Konsumen</td>
            <td>: {{strtoupper(@$orderconfirmation->orderdetail->order->user->name)}}</td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="margin-bottom:1px;">Demikian surat tugas ini yang kami buat untuk layanan dari tukangku, apabila ada kekurangan dari layanan kami silakan untuk dilaporakan.</p> 
            </td>
        </tr>
      </table>
      <br />
      <table width="40%" align="right">
          <tr>
              <td>
                  <p style="margin-bottom:0px;">Tanjung Enim, {{date_format(date_create($orderconfirmation->created_at), 'd F Y')}}</p> 
                  <p style="margin-bottom:0px;margin-top:0px;">Owner, </p> 
                  <p style="margin-top:80px;">Tukangku</p> 
              </td>
          </tr>
        </table>
</body>

</html>
