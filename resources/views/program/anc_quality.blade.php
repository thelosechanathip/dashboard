@extends('layout.dashboard_template')

@section('title')
    <title>ANC Quality 8</title>
@endsection

@section('content')
    <main class="main-content mb-5" id="main">
        {{-- Modal Start --}}
            <!-- changeDataModal Start -->
                <div class="modal fade" id="changeDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลในส่วนของ วันอังคาร/พฤหัสบดี</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <form method="POST" id="change_data_date_form">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label for="tt_12" class="form-label fw-bold">อายุครรภ์ <= 12 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_12" name="tt_12">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_15_18" class="form-label fw-bold">เมื่ออายุครรภ์ 15-18 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_15_18" name="tt_15_18">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_19_20" class="form-label fw-bold">เมื่ออายุครรภ์ 19-20 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_19_20" name="tt_19_20">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_21_26" class="form-label fw-bold">เมื่ออายุครรภ์ 21-26 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_21_26" name="tt_21_26">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_27_30" class="form-label fw-bold">เมื่ออายุครรภ์ 27-30 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_27_30" name="tt_27_30">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_31_34" class="form-label fw-bold">เมื่ออายุครรภ์ 31-34 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_31_34" name="tt_31_34">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_35_36" class="form-label fw-bold">เมื่ออายุครรภ์ 35-36 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_35_36" name="tt_35_36">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_37_38" class="form-label fw-bold">เมื่ออายุครรภ์ 37-38 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_37_38" name="tt_37_38">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="tt_39_40" class="form-label fw-bold">เมื่ออายุครรภ์ 39-40 สัปดาห์</label>
                                                <input type="date" class="form-control" id="tt_39_40" name="tt_39_40">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="change_data_date">ยืนยันการแก้ไขข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- changeDataModal End -->
            <!-- activaityDataModal Start -->
                <div class="modal fade" id="activityDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลในส่วนของ วันอังคาร/พฤหัสบดี</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <form method="POST" id="activity_data_form">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label for="atvt_12" class="form-label fw-bold">อายุครรภ์ <= 12 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_12" name="atvt_12">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_15_18" class="form-label fw-bold">เมื่ออายุครรภ์ 15-18 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_15_18" name="atvt_15_18">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_19_20" class="form-label fw-bold">เมื่ออายุครรภ์ 19-20 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_19_20" name="atvt_19_20">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_21_26" class="form-label fw-bold">เมื่ออายุครรภ์ 21-26 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_21_26" name="atvt_21_26">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_27_30" class="form-label fw-bold">เมื่ออายุครรภ์ 27-30 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_27_30" name="atvt_27_30">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_31_34" class="form-label fw-bold">เมื่ออายุครรภ์ 31-34 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_31_34" name="atvt_31_34">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_35_36" class="form-label fw-bold">เมื่ออายุครรภ์ 35-36 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_35_36" name="atvt_35_36">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_37_38" class="form-label fw-bold">เมื่ออายุครรภ์ 37-38 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_37_38" name="atvt_37_38">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label for="atvt_39_40" class="form-label fw-bold">เมื่ออายุครรภ์ 39-40 สัปดาห์</label>
                                                <input type="text" class="form-control" id="atvt_39_40" name="atvt_39_40">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="activity_data">ยืนยันการแก้ไขข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- activaityDataModal End -->
        {{-- Modal End --}}
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="">
                        <h1 class="h2">ANC Quality 8</h1>
                    </div>
                    <div class="d-flex pt-3">
                        <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                        <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <form method="POST" id="get_result_form">
                @csrf
                <div class="row">
                    <div class="col mb-3">
                        <label for="date" class="form-label fw-bold">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="col mb-3">
                        <label for="fullname" class="form-label fw-bold">คำนำหน้า ชื่อ-สกุล</label>
                        <input type="text" class="form-control" id="fullname" name="fullname">
                    </div>
                    <div class="col mb-3">
                        {{-- <label for="shph" class="form-label fw-bold">รพสต.</label>
                        <input type="text" class="form-control" id="shph" name="shph"> --}}
                        <label for="shph" class="form-label fw-bold">เลือกหน่วยบริการ</label>
                        <select class="form-select" placeholder="เลือกหน่วยบริการ" id="shph" name="shph" aria-label="Default select example"
                            style="min-width: 200px;">
                            <option selected value="------------">------------</option>
                            @foreach($zbm_rpst_name as $zrn)
                                <option value="{{ substr(strstr($zrn->rpst_name, '.'), 1) }}">{{ $zrn->rpst_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label for="telephone" class="form-label fw-bold">หมายเลขโทรศัพท์</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                </div>
            </form>
        </div>
    
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="container my-4">
                <h3 class="text-center">ช่วงวันที่ แนะนำให้นัด ANC 8 ครั้งคุณภาพ</h3>
                <table class="table table-bordered table-striped text-center align-middle table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>รายการ</th>
                            <th>วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>LMP</td>
                            <td class="" id="show_data_lmp"></td>
                        </tr>
                        <tr>
                            <td>EDC</td>
                            <td class="" id="show_data_edc"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped text-center align-middle table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>ช่วงที่</th>
                            <th>อายุครรภ์</th>
                            <th>ช่วงเวลาที่แนะนำ</th>
                            <th>ถึง</th>
                            <th>
                                กิจกรรม
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-patch-plus ms-2 zoom-card" style="cursor: pointer;" viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#activityDataModal">
                                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
                                    <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z"/>
                                </svg>
                            </th>
                            <th>
                                วันนัด( อังคาร/พฤหัสบดี )
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-patch-plus ms-2 zoom-card" style="cursor: pointer;" viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#changeDataModal">
                                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
                                    <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z"/>
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ช่วงที่ 1</td>
                            <td>อายุครรภ์ &lt;= 12 สัปดาห์</td>
                            <td class="" id="show_data_week_12"></td>
                            <td></td>
                            <td class="" id="show_data_atvt_12"></td>
                            <td class="" id="show_data_tt_12"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 2</td>
                            <td>เมื่ออายุครรภ์ 15-18 สัปดาห์</td>
                            <td class="" id="show_data_week_15"></td>
                            <td class="" id="show_data_week_18"></td>
                            <td class="" id="show_data_atvt_15_18"></td>
                            <td class="" id="show_data_tt_15_18"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>เมื่ออายุครรภ์ 19-20 สัปดาห์</td>
                            <td class="" id="show_data_week_19"></td>
                            <td class="" id="show_data_week_20"></td>
                            <td class="" id="show_data_atvt_19_20"></td>
                            <td class="" id="show_data_tt_19_20"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 3</td>
                            <td>เมื่ออายุครรภ์ 21-26 สัปดาห์</td>
                            <td class="" id="show_data_week_21"></td>
                            <td class="" id="show_data_week_26"></td>
                            <td class="" id="show_data_atvt_21_26"></td>
                            <td class="" id="show_data_tt_21_26"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 4</td>
                            <td>เมื่ออายุครรภ์ 27-30 สัปดาห์</td>
                            <td class="" id="show_data_week_27"></td>
                            <td class="" id="show_data_week_30"></td>
                            <td class="" id="show_data_atvt_27_30"></td>
                            <td class="" id="show_data_tt_27_30"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 5</td>
                            <td>เมื่ออายุครรภ์ 31-34 สัปดาห์</td>
                            <td class="" id="show_data_week_31"></td>
                            <td class="" id="show_data_week_34"></td>
                            <td class="" id="show_data_atvt_31_34"></td>
                            <td class="" id="show_data_tt_31_34"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 6</td>
                            <td>เมื่ออายุครรภ์ 35-36 สัปดาห์</td>
                            <td class="" id="show_data_week_35"></td>
                            <td class="" id="show_data_week_36"></td>
                            <td class="" id="show_data_atvt_35_36"></td>
                            <td class="" id="show_data_tt_35_36"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 7</td>
                            <td>เมื่ออายุครรภ์ 37-38 สัปดาห์</td>
                            <td class="" id="show_data_week_37"></td>
                            <td class="" id="show_data_week_38"></td>
                            <td class="" id="show_data_atvt_37_38"></td>
                            <td class="" id="show_data_tt_37_38"></td>
                        </tr>
                        <tr>
                            <td>ช่วงที่ 8</td>
                            <td>เมื่ออายุครรภ์ 39-40 สัปดาห์</td>
                            <td class="" id="show_data_week_39"></td>
                            <td class="" id="show_data_week_40"></td>
                            <td class="" id="show_data_atvt_39_40"></td>
                            <td class="" id="show_data_tt_39_40"></td>
                        </tr>
                    </tbody>
                </table>
    
                <div class="mt-4">
                    <div class="d-flex justify-content-between">
                        <h6>งานบริการฝากครรภ์ กลุ่มงานบริการด้านปฐมภูมิและองค์รวม โรงพยาบาลอากาศอำนวย เบอร์โทร : 093-163-9366</h6>
                        <button class="btn btn-outline-danger zoom-card" id="exportToPdf">ดาวน์โหลด PDF</button>
                    </div>
                    <div class="d-flex">
                        <p>ชื่อ-สกุล: <span class="" id="show_data_fullname"></span></p>
                        <p class="ms-5">PCU/รพ.สต: <span class="" id="show_data_shph"></span></p>
                        <p class="ms-5">โทร: <span class="" id="show_data_telephone"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function convertToThaiDate(dateString) {
                if (dateString !== '') {
                    // ดึงเฉพาะปีจาก dateString
                    const yearPart = parseInt(dateString.substring(0, 4));

                    // ตรวจสอบว่าปีเป็น พ.ศ. หรือ ค.ศ.
                    let adjustedDateString = dateString;
                    if (yearPart > 2500) {
                        // หากเป็น พ.ศ. ให้แปลงปีเป็น ค.ศ.
                        const convertedYear = yearPart - 543;
                        adjustedDateString = convertedYear + dateString.substring(4); // แทนปีใหม่ใน dateString
                    }

                    const date = new Date(adjustedDateString);
                    const thaiMonths = [
                        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                    ];

                    const day = date.getDate();
                    const month = thaiMonths[date.getMonth()];
                    const year = date.getFullYear() + 543; // แปลงปีเป็น พ.ศ.

                    return `${day} ${month} ${year}`;
                } else {
                    return '';
                }
            }

            $('#change_data_date').on('click', function() {
                let form = document.getElementById('change_data_date_form');
                let formData = new FormData(form);
                let tt_12Value = formData.get('tt_12');
                let thaiDate_tt_12 = convertToThaiDate(tt_12Value);
                let tt_15_18Value = formData.get('tt_15_18');
                let thaiDate_tt_15_18 = convertToThaiDate(tt_15_18Value);
                let tt_19_20Value = formData.get('tt_19_20');
                let thaiDate_tt_19_20 = convertToThaiDate(tt_19_20Value);
                let tt_21_26Value = formData.get('tt_21_26');
                let thaiDate_tt_21_26 = convertToThaiDate(tt_21_26Value);
                let tt_27_30Value = formData.get('tt_27_30');
                let thaiDate_tt_27_30 = convertToThaiDate(tt_27_30Value);
                let tt_31_34Value = formData.get('tt_31_34');
                let thaiDate_tt_31_34 = convertToThaiDate(tt_31_34Value);
                let tt_35_36Value = formData.get('tt_35_36');
                let thaiDate_tt_35_36 = convertToThaiDate(tt_35_36Value);
                let tt_37_38Value = formData.get('tt_37_38');
                let thaiDate_tt_37_38 = convertToThaiDate(tt_37_38Value);
                let tt_39_40Value = formData.get('tt_39_40');
                let thaiDate_tt_39_40 = convertToThaiDate(tt_39_40Value);

                $('#show_data_tt_12').text(thaiDate_tt_12 ? thaiDate_tt_12 : '----------');
                $('#show_data_tt_15_18').text(thaiDate_tt_15_18 ? thaiDate_tt_15_18 : '----------');
                $('#show_data_tt_19_20').text(thaiDate_tt_19_20 ? thaiDate_tt_19_20 : '----------');
                $('#show_data_tt_21_26').text(thaiDate_tt_21_26 ? thaiDate_tt_21_26 : '----------');
                $('#show_data_tt_27_30').text(thaiDate_tt_27_30 ? thaiDate_tt_27_30 : '----------');
                $('#show_data_tt_31_34').text(thaiDate_tt_31_34 ? thaiDate_tt_31_34 : '----------');
                $('#show_data_tt_35_36').text(thaiDate_tt_35_36 ? thaiDate_tt_35_36 : '----------');
                $('#show_data_tt_37_38').text(thaiDate_tt_37_38 ? thaiDate_tt_37_38 : '----------');
                $('#show_data_tt_39_40').text(thaiDate_tt_39_40 ? thaiDate_tt_39_40 : '----------');

                $("#changeDataModal").modal('hide');
            });

            $('#activity_data').on('click', function() {
                let form = document.getElementById('activity_data_form');
                let formData = new FormData(form);
                let atvt_12Value = formData.get('atvt_12');
                let atvt_15_18Value = formData.get('atvt_15_18');
                let atvt_19_20Value = formData.get('atvt_19_20');
                let atvt_21_26Value = formData.get('atvt_21_26');
                let atvt_27_30Value = formData.get('atvt_27_30');
                let atvt_31_34Value = formData.get('atvt_31_34');
                let atvt_35_36Value = formData.get('atvt_35_36');
                let atvt_37_38Value = formData.get('atvt_37_38');
                let atvt_39_40Value = formData.get('atvt_39_40');

                $('#show_data_atvt_12').text(atvt_12Value ? atvt_12Value : '----------');
                $('#show_data_atvt_15_18').text(atvt_15_18Value ? atvt_15_18Value : '----------');
                $('#show_data_atvt_19_20').text(atvt_19_20Value ? atvt_19_20Value : '----------');
                $('#show_data_atvt_21_26').text(atvt_21_26Value ? atvt_21_26Value : '----------');
                $('#show_data_atvt_27_30').text(atvt_27_30Value ? atvt_27_30Value : '----------');
                $('#show_data_atvt_31_34').text(atvt_31_34Value ? atvt_31_34Value : '----------');
                $('#show_data_atvt_35_36').text(atvt_35_36Value ? atvt_35_36Value : '----------');
                $('#show_data_atvt_37_38').text(atvt_37_38Value ? atvt_37_38Value : '----------');
                $('#show_data_atvt_39_40').text(atvt_39_40Value ? atvt_39_40Value : '----------');

                $("#activityDataModal").modal('hide');
            });

            $('#get_result_form').on('change', function() {  // Changed from #select_date to #date
                let form = document.getElementById('get_result_form');
                let formData = new FormData(form);
                let dateValue = formData.get('date');
                let thaiDate_date = convertToThaiDate(dateValue);
                let fullnameValue = formData.get('fullname');
                let shphValue = formData.get('shph');
                let telephoneValue = formData.get('telephone');

                $('#show_data_edc').text(thaiDate_date);
                $('#show_data_fullname').text(fullnameValue ? fullnameValue : '----------');
                $('#show_data_shph').text(shphValue ? shphValue : '----------');
                $('#show_data_telephone').text(telephoneValue ? telephoneValue : '----------');

                const data = {
                    lmp: $('#show_data_lmp').text(),
                    edc: $('#show_data_edc').text(),
                    week_12: $('#show_data_week_12').text(),
                    week_15: $('#show_data_week_15').text(),
                    week_18: $('#show_data_week_18').text(),
                    week_19: $('#show_data_week_19').text(),
                    week_20: $('#show_data_week_20').text(),
                    week_21: $('#show_data_week_21').text(),
                    week_26: $('#show_data_week_26').text(),
                    week_27: $('#show_data_week_27').text(),
                    week_30: $('#show_data_week_30').text(),
                    week_31: $('#show_data_week_31').text(),
                    week_34: $('#show_data_week_34').text(),
                    week_35: $('#show_data_week_35').text(),
                    week_36: $('#show_data_week_36').text(),
                    week_37: $('#show_data_week_37').text(),
                    week_38: $('#show_data_week_38').text(),
                    week_39: $('#show_data_week_39').text(),
                    week_40: $('#show_data_week_40').text(),
                    atvt_12: $('#show_data_atvt_12').text(),
                    atvt_15_18: $('#show_data_atvt_15_18').text(),
                    atvt_19_20: $('#show_data_atvt_19_20').text(),
                    atvt_21_26: $('#show_data_atvt_21_26').text(),
                    atvt_27_30: $('#show_data_atvt_27_30').text(),
                    atvt_31_34: $('#show_data_atvt_31_34').text(),
                    atvt_35_36: $('#show_data_atvt_35_36').text(),
                    atvt_37_38: $('#show_data_atvt_37_38').text(),
                    atvt_39_40: $('#show_data_atvt_39_40').text(),
                    tt_12: $('#show_data_tt_12').text(),
                    tt_15_18: $('#show_data_tt_15_18').text(),
                    tt_19_20: $('#show_data_tt_19_20').text(),
                    tt_21_26: $('#show_data_tt_21_26').text(),
                    tt_27_30: $('#show_data_tt_27_30').text(),
                    tt_31_34: $('#show_data_tt_31_34').text(),
                    tt_35_36: $('#show_data_tt_35_36').text(),
                    tt_37_38: $('#show_data_tt_37_38').text(),
                    tt_39_40: $('#show_data_tt_39_40').text(),
                    fullname: $('#show_data_fullname').text(),
                    shph: $('#show_data_shph').text(),
                    telephone: $('#show_data_telephone').text(),
                    // เพิ่มค่าอื่น ๆ ที่ต้องการ
                };

                const jsonData = JSON.stringify(data);

                // Set the JSON string as a data attribute on the button
                $('#send_data').attr('data-send', jsonData);

                // Show Swal with loading icon
                let loadingSwal = Swal.fire({
                    title: 'กำลังโหลดข้อมูล...',
                    text: 'โปรดรอสักครู่',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show spinner inside the Swal
                    }
                });

                $.ajax({
                    url: '{{ route('getResultAncQuality') }}',
                    method: 'POST',  // Specify POST method
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token if not already added
                    },
                    success: function(response) {
                        Swal.close();

                        $('#show_data_lmp').text(response.result_lmp);
                        $('#show_data_week_12').text(response.result_12);
                        $('#show_data_week_15').text(response.result_15);
                        $('#show_data_week_18').text(response.result_18);
                        $('#show_data_week_19').text(response.result_19);
                        $('#show_data_week_20').text(response.result_20);
                        $('#show_data_week_21').text(response.result_21);
                        $('#show_data_week_26').text(response.result_26);
                        $('#show_data_week_27').text(response.result_27);
                        $('#show_data_week_30').text(response.result_30);
                        $('#show_data_week_31').text(response.result_31);
                        $('#show_data_week_34').text(response.result_34);
                        $('#show_data_week_35').text(response.result_35);
                        $('#show_data_week_36').text(response.result_36);
                        $('#show_data_week_37').text(response.result_37);
                        $('#show_data_week_38').text(response.result_38);
                        $('#show_data_week_39').text(response.result_39);
                        $('#show_data_week_40').text(response.result_40);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#exportToPdf').on('click', function() {
                // ดึงค่าจาก ID ต่าง ๆ
                const data = {
                    lmp: $('#show_data_lmp').text(),
                    edc: $('#show_data_edc').text(),
                    week_12: $('#show_data_week_12').text(),
                    week_15: $('#show_data_week_15').text(),
                    week_18: $('#show_data_week_18').text(),
                    week_19: $('#show_data_week_19').text(),
                    week_20: $('#show_data_week_20').text(),
                    week_21: $('#show_data_week_21').text(),
                    week_26: $('#show_data_week_26').text(),
                    week_27: $('#show_data_week_27').text(),
                    week_30: $('#show_data_week_30').text(),
                    week_31: $('#show_data_week_31').text(),
                    week_34: $('#show_data_week_34').text(),
                    week_35: $('#show_data_week_35').text(),
                    week_36: $('#show_data_week_36').text(),
                    week_37: $('#show_data_week_37').text(),
                    week_38: $('#show_data_week_38').text(),
                    week_39: $('#show_data_week_39').text(),
                    week_40: $('#show_data_week_40').text(),
                    atvt_12: $('#show_data_atvt_12').text(),
                    atvt_15_18: $('#show_data_atvt_15_18').text(),
                    atvt_19_20: $('#show_data_atvt_19_20').text(),
                    atvt_21_26: $('#show_data_atvt_21_26').text(),
                    atvt_27_30: $('#show_data_atvt_27_30').text(),
                    atvt_31_34: $('#show_data_atvt_31_34').text(),
                    atvt_35_36: $('#show_data_atvt_35_36').text(),
                    atvt_37_38: $('#show_data_atvt_37_38').text(),
                    atvt_39_40: $('#show_data_atvt_39_40').text(),
                    tt_12: $('#show_data_tt_12').text(),
                    tt_15_18: $('#show_data_tt_15_18').text(),
                    tt_19_20: $('#show_data_tt_19_20').text(),
                    tt_21_26: $('#show_data_tt_21_26').text(),
                    tt_27_30: $('#show_data_tt_27_30').text(),
                    tt_31_34: $('#show_data_tt_31_34').text(),
                    tt_35_36: $('#show_data_tt_35_36').text(),
                    tt_37_38: $('#show_data_tt_37_38').text(),
                    tt_39_40: $('#show_data_tt_39_40').text(),
                    fullname: $('#show_data_fullname').text(),
                    shph: $('#show_data_shph').text(),
                    telephone: $('#show_data_telephone').text(),
                };

                // ส่งข้อมูลไปที่ Controller ด้วย window.open เพื่อเปิด PDF ในแท็บใหม่
                const url = new URL('{{ route("exportPDFAncQuality") }}');
                Object.keys(data).forEach(key => url.searchParams.append(key, data[key]));
                
                window.open(url, '_blank');
            });

        });
    </script>
@endsection
