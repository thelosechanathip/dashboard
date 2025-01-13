<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'sarabun_new', sans-serif;
            font-size: 18px;
        }
        /* .text-danger {
            color: red;
        } */
         /* Table Styling */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .align-middle {
            vertical-align: middle;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .ms-5 {
            margin-left: 3rem; /* หรือ 48px */
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col {
            flex: 1;
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <img src="{{ storage_path('images/moph-sm.png') }}" width="80" height="80" alt="">
        </div>

        <h2 class="text-center">ช่วงวันที่ แนะนำให้นัด ANC 8 ครั้งคุณภาพ</h2>
        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <td>รายการ</th>
                    <td>วันที่</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="text-center">LMP</td>
                    <td class="text-danger">{{ $lmp }}</td>
                </tr>
                <tr>
                    <td class="text-center">EDC</td>
                    <td class="text-danger">{{ $edc }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-striped" style="margin-top: 20px;">
            <thead class="text-center">
                <tr>
                    <th>ช่วงที่</th>
                    <th>อายุครรภ์</th>
                    <th>ช่วงเวลาที่แนะนำ</th>
                    <th>ถึง</th>
                    <th>กิจกรรม</th>
                    <th>วันนัด (อังคาร/พฤหัสบดี)</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr class="text-center">
                    <td class="text-center">ช่วงที่ 1</td>
                    <td>อายุครรภ์ <= 12 สัปดาห์</td>
                    <td class="text-danger">{{ $week_12 }}</td>
                    <td></td>
                    <td class="text-danger">{{ $atvt_12 }}</td>
                    <td class="text-danger">{{ $tt_12 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 2</td>
                    <td>เมื่ออายุครรภ์ 15-18 สัปดาห์</td>
                    <td class="text-danger">{{ $week_15 }}</td>
                    <td class="text-danger">{{ $week_18 }}</td>
                    <td class="text-danger">{{ $atvt_15_18 }}</td>
                    <td class="text-danger">{{ $tt_15_18 }}</td>
                </tr>
                <tr>
                    <td class="text-center"></td>
                    <td>เมื่ออายุครรภ์ 19-20 สัปดาห์</td>
                    <td class="text-danger">{{ $week_19 }}</td>
                    <td class="text-danger">{{ $week_20 }}</td>
                    <td class="text-danger">{{ $atvt_19_20 }}</td>
                    <td class="text-danger">{{ $tt_19_20 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 3</td>
                    <td>เมื่ออายุครรภ์ 21-26 สัปดาห์</td>
                    <td class="text-danger">{{ $week_21 }}</td>
                    <td class="text-danger">{{ $week_26 }}</td>
                    <td class="text-danger">{{ $atvt_21_26 }}</td>
                    <td class="text-danger">{{ $tt_21_26 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 4</td>
                    <td>เมื่ออายุครรภ์ 27-30 สัปดาห์</td>
                    <td class="text-danger">{{ $week_27 }}</td>
                    <td class="text-danger">{{ $week_30 }}</td>
                    <td class="text-danger">{{ $atvt_27_30 }}</td>
                    <td class="text-danger">{{ $tt_27_30 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 5</td>
                    <td>เมื่ออายุครรภ์ 31-34 สัปดาห์</td>
                    <td class="text-danger">{{ $week_31 }}</td>
                    <td class="text-danger">{{ $week_34 }}</td>
                    <td class="text-danger">{{ $atvt_31_34 }}</td>
                    <td class="text-danger">{{ $tt_31_34 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 6</td>
                    <td>เมื่ออายุครรภ์ 35-36 สัปดาห์</td>
                    <td class="text-danger">{{ $week_35 }}</td>
                    <td class="text-danger">{{ $week_36 }}</td>
                    <td class="text-danger">{{ $atvt_35_36 }}</td>
                    <td class="text-danger">{{ $tt_35_36 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 7</td>
                    <td>เมื่ออายุครรภ์ 37-38 สัปดาห์</td>
                    <td class="text-danger">{{ $week_37 }}</td>
                    <td class="text-danger">{{ $week_38 }}</td>
                    <td class="text-danger">{{ $atvt_37_38 }}</td>
                    <td class="text-danger">{{ $tt_37_38 }}</td>
                </tr>
                <tr>
                    <td class="text-center">ช่วงที่ 8</td>
                    <td>เมื่ออายุครรภ์ 39-40 สัปดาห์</td>
                    <td class="text-danger">{{ $week_39 }}</td>
                    <td class="text-danger">{{ $week_40 }}</td>
                    <td class="text-danger">{{ $atvt_39_40 }}</td>
                    <td class="text-danger">{{ $tt_39_40 }}</td>
                </tr>
            </tbody>
        </table>

        <div class="container">
            <h3 style="text-align: center;">งานบริการฝากครรภ์ กลุ่มงานบริการด้านปฐมภูมิและองค์รวม โรงพยาบาลอากาศอำนวย เบอร์โทร : 093-163-9366</h3>
            <table style="width: 45%; margin-top: 10px;">
                <tr>
                    <td>ชื่อ-สกุล: <span class="text-danger">{{ $fullname }}</span></td>
                    <td>PCU/รพ.สต: <span class="text-danger">{{ $shph }}</span></td>
                    <td>โทร: <span class="text-danger">{{ $telephone }}</span></td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>
