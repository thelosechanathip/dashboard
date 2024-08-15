@extends('layout.dashboard_template')

@section('title')
    <title>Palliative Care</title>
@endsection

@section('content')
    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง Start -->
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) Start --}}
            <div class="modal fade " id="home_visiting_information" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="home_visiting_information_title">ข้อมูลการเยี่ยมบ้าน</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="spinner-border loadingIcon" style="" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="container" id="show-home-visiting-information"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) End --}}
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 Start --}}
            <div class="modal fade " id="home_visiting_information_z718" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="home_visiting_information_z718_title">ข้อมูลการเยี่ยมบ้าน Family Meeting</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="spinner-border loadingIcon" style="" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="container" id="show-home-visiting-information-z718"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 End --}}
        {{-- ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว Start --}}
            <div class="modal fade" id="eclaim-received-money-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eclaim-received-money-modal_title">ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body w-auto">
                            <div class="text-center">
                                <div class="spinner-border loadingIcon" style="" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="container" id="show-eclaim-received-money"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว End --}}
        {{-- จำนวนผู้ป่วยรายใหม่ Start --}}
            <div class="modal fade " id="number-of-new-patients-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="number-of-new-patients-modal_title">ผู้ป่วย Palliative Care รายใหม่</h5>
                            <div class="spinner-border loadingIcon ms-3" style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button type="button" class="btn-close zoom-card action-button" mode="reset_form_number_of_new_patients_select" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="container mb-4 border-bottom row gx-1">
                                    <form id="selectFormNewPalliativeCare" class="col-auto">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-1">
                                            <div class="col-auto me-3">
                                                <span class="w-auto">รายการ</span>
                                            </div>
                                            <select class="form-select w-auto" id="selectNewPalliativeCare" aria-label="Default select example" >
                                                <option selected value="0">-------------------------</option>
                                                <option value="1">ปีงบประมาณ</option>
                                                <option value="2">กำหนดเอง</option>
                                            </select>
                                        </div>
                                    </form>
                                    <form id="number_of_new_patients_select_fiscal_years_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex aling-items-center justify-content-start row gx-5">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div class="col-auto">
                                                    <span class="me-2">ปี</span>
                                                </div>
                                                <div class="col-auto">
                                                    <select class="form-select w-auto" id="nonpsfy_years" name="nonpsfy_years" aria-label="Default select example">
                                                        <option selected value="0">-----</option>
                                                        <option value="2565">2565</option>
                                                        <option value="2566">2566</option>
                                                        <option value="2567">2567</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto ms-3">
                                                    <button type="submit" id="number_of_new_patients_select_fiscal_years_submit" class="btn btn-primary w-auto">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="patient_date_range_select_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-3">
                                            <div class="col-md-8 d-flex align-items-center">
                                                <!-- เลือกเดือน ตั้งแต่ -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                                    <input type="date" class="form-control" id="pdrs_1" name="pdrs_1" placeholder="pdrs_1" required>
                                                </div>

                                                <!-- ถึง -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                                    <input type="date" class="form-control" id="pdrs_2" name="pdrs_2" placeholder="pdrs_2" required>
                                                </div>

                                                <!-- ยืนยัน -->
                                                <div class="ms-3">
                                                    <button type="submit" id="patient_date_range_select_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="container" id="show-number-of-new-patients"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger zoom-card action-button" mode="reset_form_number_of_new_patients_select" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- จำนวนผู้ป่วยรายใหม่ End --}}
        {{-- จำนวนผู้ป่วยรายเก่า Start --}}
            <div class="modal fade " id="number-of-old-patients-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="number-of-old-patients-modal_title">ผู้ป่วย Palliative Care รายเก่า</h5>
                            <div class="spinner-border loadingIcon ms-3" style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button type="button" class="btn-close zoom-card action-button" mode="reset_form_number_of_old_patients_select" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="container mb-4 border-bottom row gx-1">
                                    <form id="selectFormOldPalliativeCare" class="col-auto">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-1">
                                            <div class="col-auto me-3">
                                                <span class="w-auto">รายการ</span>
                                            </div>
                                            <select class="form-select w-auto" id="selectOldPalliativeCare" aria-label="Default select example" >
                                                <option selected value="0">-------------------------</option>
                                                <option value="1">ปีงบประมาณ</option>
                                                <option value="2">กำหนดเอง</option>
                                            </select>
                                        </div>
                                    </form>
                                    <form id="number_of_old_patients_select_fiscal_years_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex aling-items-center justify-content-start row gx-5">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div class="col-auto">
                                                    <span class="me-2">ปี</span>
                                                </div>
                                                <div class="col-auto">
                                                    <select class="form-select w-auto" id="noopsfy_years" name="noopsfy_years" aria-label="Default select example">
                                                        <option selected value="0">-----</option>
                                                        <option value="2565">2565</option>
                                                        <option value="2566">2566</option>
                                                        <option value="2567">2567</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto ms-3">
                                                    <button type="submit" id="number_of_old_patients_select_fiscal_years_submit" class="btn btn-primary w-auto">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="patient_date_range_select_old_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-3">
                                            <div class="col-md-8 d-flex align-items-center">
                                                <!-- เลือกเดือน ตั้งแต่ -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                                    <input type="date" class="form-control" id="pdrso_1" name="pdrso_1" placeholder="pdrso_1" required>
                                                </div>

                                                <!-- ถึง -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                                    <input type="date" class="form-control" id="pdrso_2" name="pdrso_2" placeholder="pdrso_2" required>
                                                </div>

                                                <!-- ยืนยัน -->
                                                <div class="ms-3">
                                                    <button type="submit" id="patient_date_range_select_old_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="container" id="show-number-of-old-patients"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger zoom-card action-button" mode="reset_form_number_of_old_patients_select" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- จำนวนผู้ป่วยรายใหม่ End --}}
        {{-- จำนวนผู้ป่วย Palliative Care ที่มีอาการปวด ( Pain ) Start --}}
            <div class="modal fade " id="palliative-care-patients-with-pain-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="palliative-care-patients-with-pain-title">ผู้ป่วย Palliative Care ที่มีอาการปวด ( Pain )</h5>
                            <button type="button" class="btn-close zoom-card action-button" mode="reset_form_palliative_care_patients_with_pain" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container mb-4">
                                <form id="palliative_care_patients_with_pain_form" class="me-3">
                                    @csrf
                                    <div class="mb-3 d-flex align-items-center row">
                                        <div class="col-1 d-flex align-items-center me-5">
                                            <span class="me-3">ปี</span>
                                            <select class="form-select" id="pcpwp_years" name="pcpwp_years" aria-label="Default select example"
                                                style="min-width: 100px;">
                                                <option selected value="0">-----</option>
                                                <option value="2565">2565</option>
                                                <option value="2566">2566</option>
                                                <option value="2567">2567</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-flex align-items-center me-2">
                                            <span class="me-3">เดือน</span>
                                            <select class="form-select ms-2 me-2" id="pcpwp_month" name="pcpwp_month" aria-label="Default select example"
                                                style="min-width: 210px;">
                                                <option selected value="0">-------------------------</option>
                                                <option value="01">มกราคม</option>
                                                <option value="02">กุมภาพันธ์</option>
                                                <option value="03">มีนายน</option>
                                                <option value="04">เมษายน</option>
                                                <option value="05">พฤษภาคม</option>
                                                <option value="06">มิถุนายน</option>
                                                <option value="07">กรกฏาคม</option>
                                                <option value="08">สิงหาคม</option>
                                                <option value="09">กันยายน</option>
                                                <option value="10">ตุลาคม</option>
                                                <option value="11">พฤศจิกายน</option>
                                                <option value="12">ธันวาคม</option>
                                            </select>
                                        </div>
                                        <div class="col-1 d-flex align-items-center ms-5">
                                            <button type="submit" id="palliative_care_patients_with_pain_submit" class="btn btn-primary ms-3 zoom-card">ยืนยัน</button>
                                        </div>
                                        <div class="spinner-border loadingIcon " style="" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="container" id="show-palliative-care-patients-with-pain"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger zoom-card action-button" mode="reset_form_palliative_care_patients_with_pain" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- จำนวนผู้ป่วย Palliative Care ที่มีอาการปวด ( Pain ) End --}}
    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง End -->
    <main class="main-content" id="main">
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
                <div class="">
                    <h1 class="h2">Palliative Care</h1>
                </div>
                <div class="d-flex">
                    <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                    <p>&nbsp;&nbsp;&nbsp;</p>
                    <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        <div class="mt-2 d-flex justify-content-between align-items-center border-bottom full-width-bar">
            <div class="d-flex align-items-center">
                {{-- Form Select สำหรับเลือกรายการ Start --}}
                    <form id="selectForm" class="me-3">
                        @csrf
                        <div class="mb-3 d-flex align-items-center">
                            <span class="w-100">รายการ</span>
                            <select class="form-select ms-2 me-2" id="select" aria-label="Default select example"
                                style="min-width: 210px;">
                                <option selected value="0">-------------------------</option>
                                <option value="1">ดูจำนวนผู้เสียชีวิต</option>
                                <option value="2">ดูรายชื่อ Palliative Care</option>
                            </select>
                        </div>
                    </form>
                {{-- Form Select สำหรับเลือกรายการ End --}}
                <div class="px-2">
                    {{-- Button แสดงทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว Start --}}
                        <button type="button" class="btn btn-warning eclaim-received-money mb-3 d-flex align-items-center zoom-card action-button" data-bs-toggle="modal" data-bs-target="#eclaim-received-money-modal">
                            ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว
                        </button>
                    {{-- Button แสดงทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว End --}}
                </div>
                <div class="px-2">
                    {{-- Button แสดงผู้ปู่วย Palliative Care รายใหม่ Start --}}
                        <button type="button" class="btn btn-warning number-of-new-patients mb-3 d-flex align-items-center zoom-card action-button" data-bs-toggle="modal" data-bs-target="#number-of-new-patients-modal">
                            ผู้ป่วย Palliative Care รายใหม่
                        </button>
                    {{-- Button แสดงผู้ปู่วย Palliative Care รายใหม่ End --}}
                </div>
                <div class="px-2">
                    {{-- Button แสดงผู้ปู่วย Palliative Care รายเก่า Start --}}
                        <button type="button" class="btn btn-warning number-of-old-patients mb-3 d-flex align-items-center zoom-card action-button" data-bs-toggle="modal" data-bs-target="#number-of-old-patients-modal">
                            ผู้ป่วย Palliative Care รายเก่า
                        </button>
                    {{-- Button แสดงผู้ปู่วย Palliative Care รายเก่า End --}}
                </div>
                <div class="px-2">
                    {{-- Button แสดงผู้ปู่วย Palliative Care ที่มีอาการปวด ( Pain ) Start --}}
                        <button type="button" class="btn btn-warning palliative-care-patients-with-pain mb-3 d-flex align-items-center zoom-card action-button" data-bs-toggle="modal" data-bs-target="#palliative-care-patients-with-pain-modal">
                            ผู้ป่วย Palliative Care ที่มีอาการปวด( Pain )
                        </button>
                    {{-- Button แสดงผู้ปู่วย Palliative Care ที่มีอาการปวด ( Pain ) End --}}
                </div>
            </div>
            <div class="">

            </div>
        </div>

        <div class="mt-3 d-flex align-item-center justify-content-start">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between">
                    {{-- Form ดึงจำนวนคนไข้ที่เสียชีวิต Palliative Care แยกตาม Diag Start --}}
                    <form id="palliative_count_death_form" class="text-start">
                        @csrf
                        <div class="mb-3 d-flex align-items-center row">
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 80px;">
                                    <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                                </div>
                                <div>
                                    <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 70px;">
                                    <span class="" style="width: 100%;">ถึงวันที่</span>
                                </div>
                                <div>
                                    <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <button type="button" id="palliative_count_death_submit" class="btn btn-primary ms-3 zoom-card">ยืนยัน</button>
                            </div>
                            <div class="spinner-border loadingIcon " style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                    {{-- Form ดึงจำนวนคนไข้ที่เสียชีวิต Palliative Care แยกตาม Diag End --}}
                    {{-- Form ดึงรายชื่อคนไข้ Palliative Care Start --}}
                    <form id="palliative_list_name_form">
                        @csrf
                        <div class="mb-3 d-flex align-items-center row">
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 80px;">
                                    <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                                </div>
                                <div>
                                    <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 70px;">
                                    <span class="" style="width: 100%;">ถึงวันที่</span>
                                </div>
                                <div>
                                    <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 120px;">
                                    <span class="" style="width: 100%;">เลือกหน่วยบริการ</span>
                                </div>
                                <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="service_unit" name="service_unit" aria-label="Default select example"
                                    style="min-width: 200px;">
                                    <option selected value="0">------------</option>
                                    <option value="99999">ทั้งหมด</option>
                                    <option value="11111">นอกเขตบริการ</option>
                                    @foreach($zbm_rpst_name as $zrn)
                                        <option value="{{ $zrn->rpst_id }}">{{ $zrn->rpst_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="" style="min-width: 80px;">
                                    <span class="" style="width: 100%;">เลือกสถานะ</span>
                                </div>
                                <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="death_type" name="death_type" aria-label="Default select example"
                                    style="min-width: 200px;">
                                    <option selected value="0">------------</option>
                                    <option value="99999">ทั้งหมด</option>
                                    <option value="Y">เสียชีวิต</option>
                                    <option value="N">ยังมีชีวิต</option>
                                </select>
                            </div>
                            <div class="col d-flex align-items-center">
                                <button type="button" id="palliative_list_name_submit" class="btn btn-primary ms-1 zoom-card">ยืนยัน</button>
                            </div>
                            <div class="spinner-border loadingIcon " style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                    {{-- Form ดึงรายชื่อคนไข้ Palliative Care End --}}
                </div>
            </div>
        </div>

        {{-- แสดงข้อมูลเสียชีวิต Palliative Care ตาม Diag แบบ Chart Start --}}
            <div class="mt-3 card shadow-lg w-auto" id="palliative_count_death_all_chart">
                <div class="row">
                    {{-- แสดงข้อมูลของจำนวนผู้ป่วย Start --}}
                    <p class="text-end p-5"><span id="setText"></span><span id="setCount"></span></p>
                    {{-- แสดงข้อมูลของจำนวนผู้ป่วย End --}}
                    <div class="col-12">
                        <div class="container">
                            <div class="my-5">
                                <canvas id="palliative_my_chart" width="300" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูลเสียชีวิต Palliative Care ตาม Diag แบบ Chart End --}}
        {{-- แสดงข้อมูล Palliative Care ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="palliative_list_name_table">
                <div class="row w-100">
                    <div class="col-12 w-auto">
                        <div class="mx-5 w-auto">
                            <div class="my-5 ms-0 w-auto">
                                <div class="w-auto" id="fetch-list-name"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูล Palliative Care ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table End --}}

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // เริ่มต้น Hide Start
                $('#palliative_count_death_all_chart').hide();
                $('#palliative_count_death_form').hide();
                $('#palliative_list_name_form').hide();
                $('#palliative_list_name_table').hide();
                $('.loadingIcon').hide();

                $('#number_of_new_patients_select_fiscal_years_form').hide();
                $('#patient_date_range_select_form').hide();
            // เริ่มต้น Hide End

            // จาก form ID "select" เลือกแบบ Realtime Start
                $('#select').change(function() {
                    var selectForm = $('#select').val();
                    if (selectForm != '0' && selectForm == '1') {
                        $('#palliative_count_death_form').show();
                        $('#palliative_list_name_form').hide();
                    } else if (selectForm != '0' && selectForm == '2') {
                        $('#palliative_list_name_form').show();
                        $('#palliative_count_death_form').hide();
                    } else {
                        $('#palliative_list_name_form').hide();
                        $('#palliative_count_death_form').hide();
                    }
                });

                $('#selectFormNewPalliativeCare').change(function() {
                    var selectForm = $('#selectNewPalliativeCare').val();
                    if(selectForm != '0' && selectForm == '1') {
                        $('#number_of_new_patients_select_fiscal_years_form').show();
                        $('#patient_date_range_select_form').hide();
                    } else if(selectForm != '0' && selectForm == '2') {
                        $('#patient_date_range_select_form').show();
                        $('#number_of_new_patients_select_fiscal_years_form').hide();
                    } else {
                        $('#number_of_new_patients_select_fiscal_years_form').hide();
                        $('#number_of_new_patients_select_fiscal_years_form')[0].reset();
                        $('#patient_date_range_select_form').hide();
                        $('#patient_date_range_select_form')[0].reset();
                    }
                });

                $('#selectFormOldPalliativeCare').change(function() {
                    var selectForm = $('#selectOldPalliativeCare').val();
                    if(selectForm != '0' && selectForm == '1') {
                        $('#number_of_old_patients_select_fiscal_years_form').show();
                        $('#patient_date_range_select_old_form').hide();
                    } else if(selectForm != '0' && selectForm == '2') {
                        $('#patient_date_range_select_old_form').show();
                        $('#number_of_old_patients_select_fiscal_years_form').hide();
                    } else {
                        $('#number_of_old_patients_select_fiscal_years_form').hide();
                        $('#number_of_old_patients_select_fiscal_years_form')[0].reset();
                        $('#patient_date_range_select_old_form').hide();
                        $('#patient_date_range_select_old_form')[0].reset();
                    }
                });
            // จาก form ID "select" เลือกแบบ Realtime End

            // Icon Download Start
                function showLoadingIcon() {
                    $('.loadingIcon').show();
                }

                function hideLoadingIcon() {
                    $('.loadingIcon').hide();
                }
            // Icon Download End

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีคนไข้ Palliative Care ที่เสียชีวิต');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนคนไข้ Palliative Care ทั้งหมดที่เสียชีวิตแยกตาม Diag ทั้งหมด : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#palliative_list_name_table').hide();
                    $('#palliative_count_death_all_chart').hide();
                    $('#palliative_list_name_table').hide();
                    $('#palliative_count_death_all_chart').hide();
                    $('#palliative_count_death_form').hide();
                    $('#palliative_list_name_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // Reset Form Start
                $('.action-button').click(function() {
                    var mode = $(this).attr('mode');

                    if(mode === 'reset_form_number_of_new_patients_select') {
                        // Palliative Care รายใหม่ ตามค่าที่ส่งไป
                        $('#number_of_new_patients_select_fiscal_years_form').hide();
                        $('#number_of_new_patients_select_fiscal_years_form')[0].reset();
                        $('#patient_date_range_select_form').hide();
                        $('#patient_date_range_select_form')[0].reset();
                        $('#selectFormNewPalliativeCare')[0].reset();
                    } else if(mode === 'reset_form_number_of_old_patients_select') {
                        $('#number_of_old_patients_select_form').hide();
                        $("#number_of_old_patients_select_form")[0].reset();
                        $('#patient_date_range_select_old_form').hide();
                        $('#patient_date_range_select_old_form')[0].reset();
                        $('#selectFormOldPalliativeCare')[0].reset();
                    } else if(mode === 'reset_form_palliative_care_patients_with_pain') {
                        $("#palliative_care_patients_with_pain_form")[0].reset();
                    } else {
                        // Reset Form บนหน้าเว็บทุกตัว
                        $("#number_of_new_patients_select_fiscal_years_form")[0].reset();
                        $("#patient_date_range_select_form")[0].reset();
                        $("#palliative_count_death_form")[0].reset();
                        $("#palliative_list_name_form")[0].reset();
                        $("#selectForm")[0].reset();
                        $('#selectFormNewPalliativeCare')[0].reset();
                        $('#patient_date_range_select_form').hide();
                        $('#number_of_new_patients_select_fiscal_years_form').hide();
                        $('#selectFormOldPalliativeCare')[0].reset();
                        $('#patient_date_range_select_old_form').hide();
                        $('#number_of_old_patients_select_fiscal_years_form').hide();
                    }
                });
            // Reset Form End

            // ตัวแปรเก็บ Chart Start
                var chart;
            // ตัวแปรเก็บ Chart End

            // ดึงข้อมูลเสียชีวิต Palliative Care ตาม Diag แสดงแบบ Chart Start
                $('#palliative_count_death_submit').click(function(e) {
                    // ป้องกันการ Reload ของหน้าเว็บใหม่
                    e.preventDefault();

                    // ดึงข้อมูลจาก Form ด้วย ID
                    var formData = $('#palliative_count_death_form').serialize();

                    $('#palliative_list_name_table').hide();
                    $('#palliative_count_death_all_chart').hide();
                    $('#setText').hide();
                    $('#setCount').hide();
                    // เรียกใช้งาน Function เพื่อแสดง Icon Download
                    showLoadingIcon();

                    $.ajax({
                        // ส่งคำขอข้อมูลไปยัง Route
                        url: '{{ route('getPalliativeCareSelectData') }}',
                        // Method Get
                        type: 'GET',
                        // ส่งข้อมูลด้วยตัวแปร formData
                        data: formData,
                        // เมื่อมีการส่ง Response กลับมา
                        success: function(response) {
                            // เรียกใช้งาน Function เพื่อปิด Icon Download
                            hideLoadingIcon();

                            if(response.status === 400) {
                                // แสดงข้อมูลแบบ Sweet Alert 2 Start
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                                // แสดงข้อมูลแบบ Sweet Alert 2 End
                                $('#palliative_count_death_all_chart').hide();
                                $('#palliative_list_name_table').hide();
                            } else {
                                $('#palliative_count_death_all_chart').show();
                                $('#palliative_list_name_table').hide();
                                // Reset Form ที่มี ID ตามด้านล่าง
                                $("#palliative_list_name_form")[0].reset();

                                // นำ Response ที่มี Chart นำไปเก็บไว้ในตัวแปร chart_count_death
                                var chart_count_death = response.chart_count_death;

                                // Check ว่ามี Chart หรือไม่
                                if (chart) {
                                    chart.destroy();
                                }

                                // เข้าถึง ID ตามด้านล่างเพื่อทำให้ ID นั้นๆ แสดงรูปแบบ Chart ออกมา
                                var ctx = document.getElementById('palliative_my_chart').getContext('2d');
                                chart = new Chart(ctx, {
                                    // แสดง Chart ในรูปแบบกราฟแท่ง
                                    type: 'bar',
                                    // ดึงข้อมูลจาก Response มาแสดง
                                    data: chart_count_death,
                                    // ดึงข้อมูลจาก Response ในส่วนของ Options มาแสดง
                                    options: chart_count_death.options
                                });

                                // ดึงข้อมูลจาก Response มารวมกันเพื่อหาผลรวมของข้อมูล
                                var total = chart_count_death.datasets[0].data.reduce(function(sum, value) {
                                    return sum + value;
                                }, 0).toLocaleString();

                                // ตรวจสอบข้อมูลว่า = 0 หรือไม่ แล้วค่าไปยัง Function setText เพื่อทำการ Set ข้อความและจำนวนข้อมูลที่ต้องการแสดง
                                if(parseInt(total) == 0) {
                                    setText(total);
                                } else {
                                    setText(total);
                                }
                            }
                        }
                    });
                });
            // ดึงข้อมูลเสียชีวิต Palliative Care ตาม Diag แสดงแบบ Chart End

            // ดึงข้อมูลรายชื่อคนไข้ Palliative Care ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต Start
                $('#palliative_list_name_submit').click(function(e) {
                    e.preventDefault();
                    var formData = $('#palliative_list_name_form').serialize();

                    $('#palliative_list_name_table').hide();
                    $('#palliative_count_death_all_chart').hide();
                    $('#setText').hide();
                    $('#setCount').hide();
                    showLoadingIcon();

                    $.ajax({
                        url: '{{ route('getPalliativeCareFetchListName') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#palliative_list_name_table').show();
                                $('#palliative_count_death_all_chart').hide();
                                $("#palliative_count_death_form")[0].reset();
                                $('#setText').hide();
                                $('#setCount').hide();
                                $("#fetch-list-name").html(response);
                                $("#table-fetch-list-name").DataTable({
                                    responsive: true,
                                    order: [0, 'desc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อคนไข้ Palliative Care ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต End

            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal Start
                $(document).on('click', '.home-visiting-information', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-home-visiting-information').hide();
                    $('#show-home-visiting-information-z718').hide();
                    $('#setText').hide();
                    $('#setCount').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getHomeVisitingInformation') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            hideLoadingIcon();
                            $('#show-home-visiting-information').show();
                            $("#show-home-visiting-information").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal End

            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal Start
                $(document).on('click', '.home-visiting-information-z718', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-home-visiting-information').hide();
                    $('#show-home-visiting-information-z718').hide();
                    $('#setText').hide();
                    $('#setCount').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getHomeVisitingInformationZ718') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            hideLoadingIcon();
                            $('#show-home-visiting-information-z718').show();
                            $("#show-home-visiting-information-z718").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal End

            // ดึงข้อมูลทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้วแสดงบน Modal Start
                $(document).on('click', '.eclaim-received-money', function (e) {
                    e.preventDefault();
                    $('#show-eclaim-received-money').hide();
                    hideForm();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getEclaimReceivedMoney') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIcon();
                            $('#show-eclaim-received-money').show();
                            $("#show-eclaim-received-money").html(response);
                            $("#table-eclaim-received-money").DataTable({
                                responsive: true,
                                order: [0, 'desc'],
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        targets: "_all",
                                        className: "dt-head-center dt-body-center"
                                    }
                                ],
                                dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                buttons: [
                                    {
                                        extend: 'copyHtml5',
                                        text: 'Copy'
                                    },
                                    {
                                        extend: 'csvHtml5',
                                        text: 'CSV'
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Excel'
                                    }
                                ]
                            });
                        }
                    });
                });
            // ดึงข้อมูลทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้วแสดงบน Modal End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ ค่าเริ่มต้น Start
                $(document).on('click', '.number-of-new-patients', function (e) {
                    e.preventDefault();
                    $('#show-number-of-new-patients').hide();
                    hideForm();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getNumberOfNewPatients') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIcon();
                            // console.log(response.message);
                            $('#show-number-of-new-patients').show();
                            $("#show-number-of-new-patients").html(response);
                            $("#table-number-of-new-patients").DataTable({
                                responsive: true,
                                order: [0, 'asc'],
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        targets: "_all",
                                        className: "dt-head-center dt-body-center"
                                    }
                                ],
                                dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                buttons: [
                                    {
                                        extend: 'copyHtml5',
                                        text: 'Copy'
                                    },
                                    {
                                        extend: 'csvHtml5',
                                        text: 'CSV'
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Excel'
                                    }
                                ]
                            });
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ ค่าเริ่มต้น End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ ของปีงบประมาณ ตามค่าที่ส่งไป Start
                $('#number_of_new_patients_select_fiscal_years_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#number_of_new_patients_select_fiscal_years_form').serialize();
                    $('#show-number-of-new-patients').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getNumberOfNewPatientsSelectFiscalYears') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#show-number-of-new-patients').show();
                                $("#show-number-of-new-patients").html(response);
                                $("#table-number-of-new-patients-select-fiscal-years").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ ของปีงบประมาณ ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ กำหนดเอง ตามค่าที่ส่งไป Start
                $('#patient_date_range_select_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#patient_date_range_select_form').serialize();
                    $('#show-number-of-new-patients').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getPatientDateRangeSelect') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#show-number-of-new-patients').show();
                                $("#show-number-of-new-patients").html(response);
                                $("#table-patient-date-range-select").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายใหม่ กำหนดเอง ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ค่าเริ่มต้น Start
                $(document).on('click', '.number-of-old-patients', function (e) {
                    e.preventDefault();
                    $('#show-number-of-old-patients').hide();
                    hideForm();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getNumberOfOldPatients') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIcon();
                            $('#show-number-of-old-patients').show();
                            $("#show-number-of-old-patients").html(response);
                            $("#table-number-of-old-patients").DataTable({
                                responsive: true,
                                order: [0, 'asc'],
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        targets: "_all",
                                        className: "dt-head-center dt-body-center"
                                    }
                                ],
                                dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                buttons: [
                                    {
                                        extend: 'copyHtml5',
                                        text: 'Copy'
                                    },
                                    {
                                        extend: 'csvHtml5',
                                        text: 'CSV'
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Excel'
                                    }
                                ]
                            });
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ค่าเริ่มต้น End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ของปีงบประมาณ ตามค่าที่ส่งไป Start
                $('#number_of_old_patients_select_fiscal_years_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#number_of_old_patients_select_fiscal_years_form').serialize();
                    $('#show-number-of-old-patients').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getNumberOfOldPatientsSelectFiscalYears') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#show-number-of-old-patients').show();
                                $("#show-number-of-old-patients").html(response);
                                $("#table-number-of-old-patients-select-fiscal-years").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ของปีงบประมาณ ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ของปีงบประมาณ ตามค่าที่ส่งไป Start
            $('#patient_date_range_select_old_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#patient_date_range_select_old_form').serialize();
                    $('#show-number-of-old-patients').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getPatientDateRangeSelectOld') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#show-number-of-old-patients').show();
                                $("#show-number-of-old-patients").html(response);
                                $("#table-patient-date-range-select-old").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ของปีงบประมาณ ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ค่าเริ่มต้น Start
                $(document).on('click', '.palliative-care-patients-with-pain', function (e) {
                    e.preventDefault();
                    $('#show-palliative-care-patients-with-pain').hide();
                    hideForm();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getPalliativeCarePatientsPain') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIcon();
                            $('#show-palliative-care-patients-with-pain').show();
                            $("#show-palliative-care-patients-with-pain").html(response);
                            $("#table-palliative-care-patients-with-pain").DataTable({
                                responsive: true,
                                order: [0, 'asc'],
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        targets: "_all",
                                        className: "dt-head-center dt-body-center"
                                    }
                                ],
                                dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                buttons: [
                                    {
                                        extend: 'copyHtml5',
                                        text: 'Copy'
                                    },
                                    {
                                        extend: 'csvHtml5',
                                        text: 'CSV'
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Excel'
                                    }
                                ]
                            });
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ค่าเริ่มต้น End

            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ตามค่าที่ส่งไป Start
                $('#palliative_care_patients_with_pain_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#palliative_care_patients_with_pain_form').serialize();
                    $('#show-palliative-care-patients-with-pain').hide();
                    showLoadingIcon();
                    $.ajax({
                        url: '{{ route('getPalliativeCarePatientsPainSelect') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#show-palliative-care-patients-with-pain').show();
                                $("#show-palliative-care-patients-with-pain").html(response);
                                $("#table-palliative-care-patients-with-pain-select").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    columnDefs: [
                                        {
                                            targets: "_all",
                                            className: "dt-head-center dt-body-center"
                                        }
                                    ],
                                    dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                                    buttons: [
                                        {
                                            extend: 'copyHtml5',
                                            text: 'Copy'
                                        },
                                        {
                                            extend: 'csvHtml5',
                                            text: 'CSV'
                                        },
                                        {
                                            extend: 'excelHtml5',
                                            text: 'Excel'
                                        }
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ตามค่าที่ส่งไป End
        });
    </script>
@endsection
