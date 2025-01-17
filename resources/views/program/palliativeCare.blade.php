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
                                                        @foreach($fiscal_year AS $fy)
                                                            <option value="{{ $fy->fiscal_year_name + 543 }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                                        @endforeach
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
                                                        @foreach($fiscal_year AS $fy)
                                                            <option value="{{ $fy->fiscal_year_name + 543 }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                                        @endforeach
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
                            <div class="spinner-border loadingIcon ms-3" style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button type="button" class="btn-close zoom-card action-button" mode="reset_form_palliative_care_patients_with_pain" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="container mb-4 border-bottom row gx-1">
                                    <form id="selectFormPalliativeCarePatientsWithPain" class="col-auto">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-1">
                                            <div class="col-auto me-3">
                                                <span class="w-auto">รายการ</span>
                                            </div>
                                            <select class="form-select w-auto" id="selectPalliativeCarePatientsWithPain" aria-label="Default select example" >
                                                <option selected value="0">-------------------------</option>
                                                <option value="1">ปีงบประมาณ</option>
                                                <option value="2">กำหนดเอง</option>
                                            </select>
                                        </div>
                                    </form>
                                    <form id="palliative_care_patients_with_pain_fiscal_years_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex aling-items-center justify-content-start row gx-5">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div class="col-auto">
                                                    <span class="me-2">ปี</span>
                                                </div>
                                                <div class="col-auto">
                                                    <select class="form-select w-auto" id="pcpwpf_years" name="pcpwpf_years" aria-label="Default select example">
                                                        <option selected value="0">-----</option>
                                                        @foreach($fiscal_year AS $fy)
                                                            <option value="{{ $fy->fiscal_year_name + 543 }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-auto ms-3">
                                                    <button type="submit" id="palliative_care_patients_with_pain_fiscal_years_submit" class="btn btn-primary w-auto">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="palliative_care_patients_with_pain_date_range_select_form" class="col ms-3">
                                        @csrf
                                        <div class="mb-3 d-flex align-items-center row gx-3">
                                            <div class="col-md-8 d-flex align-items-center">
                                                <!-- เลือกเดือน ตั้งแต่ -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                                    <input type="date" class="form-control" id="pcpwpdrs_1" name="pcpwpdrs_1" placeholder="pcpwpdrs_1" required>
                                                </div>

                                                <!-- ถึง -->
                                                <div class="d-flex align-items-center me-3">
                                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                                    <input type="date" class="form-control" id="pcpwpdrs_2" name="pcpwpdrs_2" placeholder="pcpwpdrs_2" required>
                                                </div>

                                                <!-- ยืนยัน -->
                                                <div class="ms-3">
                                                    <button type="submit" id="palliative_care_patients_with_pain_date_range_select_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        {{-- Advance Care Plan Start --}}
            <div class="modal fade " id="advance_care_plan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advance_care_plan_title">Advance Care Plan</h5>
                            <div class="spinner-border loadingIcon ms-3" style="" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button type="button" class="btn-close zoom-card action-button" mode="" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="advance_care_plan_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="advance_care_plan_id_find_one" name="advance_care_plan_id_find_one">
                                <input type="hidden" id="vn" name="vn">
                                <div class="mb-3">
                                    <label for="acp_cid" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                    <input type="text" class="form-control" name="acp_cid" id="acp_cid" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_vn" class="form-label">หมายเลข Visit</label>
                                    <input type="text" class="form-control" name="acp_vn" id="acp_vn" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_hn" class="form-label">HN</label>
                                    <input type="text" class="form-control" name="acp_hn" id="acp_hn" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_fullname" class="form-label">ชื่อ - สกุล</label>
                                    <input type="text" class="form-control" name="acp_fullname" id="acp_fullname" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="detail_of_talking_with_patients" class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" placeholder="กรอกรายละเอียดการคุยกับคนไข้" id="detail_of_talking_with_patients" name="detail_of_talking_with_patients" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file_acp">เพิ่มไฟล์</label>
                                    <input type="file" name="file_acp" class="form-control">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card me-3" id="advance_care_plan_submit">บันทึกข้อมูล</button>
                                    <button type="button" class="btn btn-danger zoom-card action-button" mode="" data-bs-dismiss="modal">ยกเลิกการบันทึกข้อมูล</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        {{-- Advance Care Plan End --}}
        {{-- Advance Care Plan Detail Start --}}
            <div class="modal fade " id="advance_care_plan_detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advance_care_plan_detail_title">ข้อมูล Advance Care Plan</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="spinner-border loadingIcon" style="" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="container" id="show_advance_care_plan_detail"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Advance Care Plan Detail End --}}
        <!-- Modal สำหรับแสดงรูปภาพขนาดเต็ม -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="" id="imageModalSrc" class="img-fluid" alt="Full Size Image">
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง End -->

    {{-- Offcanvas Start --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="palliative_care_menu" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex justify-content-start align-items-center">
                    <ul class="text-white">
                        <li class="my-2 zoom-text"><a href="{{ route('pc_cancer_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนโรคมะเร็ง</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_stroke_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนโรคหลอดเลือดสมอง</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_ckd5_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนโรคไตเรื้อรังระยะสุดท้าย</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_copd_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนโรคหลอดลมอุดกั้นเรื้อรัง</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_tbi_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน Traumatic Brain Injury</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_sci_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน Spinal cord injury</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_senitity_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน Senitity</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_dementia_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน Dementia</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_acs_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน ACS</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_stemi_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียน STEMI</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_all_patients_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนผู้ป่วยทั้งหมด</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_list_of_deceased_patients_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนผู้ป่วยเสียชีวิต</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_list_of_living_patients_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">ทะเบียนผู้ป่วยที่ยังมีชีวิต</a></li>
                        <li class="my-2 zoom-text"><a href="{{ route('pc_e_claim_withdrawal_index', ['id' => $sidebar_sub1_menu_id]) }}" class="text-dark text-decoration-none p-2 pc_menu_offcanvas">รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย</a></li>
                    </ul>
                </div>
            </div>
        </div>
    {{-- Offcanvas End --}}
    
    <main class="main-content mb-5" id="main">
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="">
                        <h1 class="h2">Palliative Care</h1>
                    </div>
                    <div class="d-flex mt-3">
                        <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                        <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        {{-- All Button Tab Menu Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center mt-2">
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
                        <div class="px-2">
                            {{-- Button Advance Care Plan Start --}}
                                <a type="button" href="{{ route('advance_care_plan') }}" class="btn btn-warning mb-3 d-flex align-items-center zoom-card action-button">
                                    Advance Care Plan
                                </a>
                            {{-- Button Advance Care Plan End --}}
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        {{-- Button เรียกใช้งานตัว Offcanvas Start --}}
                            <div class="px-2">
                                <button class="btn btn-primary palliative-care-patients-with-pain mb-3 d-flex align-items-center zoom-card action-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#palliative_care_menu" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>
                            </div>
                        {{-- Button เรียกใช้งานตัว Offcanvas End --}}
                    </div>
                </div>
            </div>
        {{-- All Button Tab Menu End --}}

        {{-- Form Select Title Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex align-items-center mt-2">
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
                </div>
            </div>
        {{-- Form Select Title End --}}

        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" id="form_all">
                <div class="row mt-3">
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
        {{-- All Form Date End --}}

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

                $('#number_of_old_patients_select_fiscal_years_form').hide();
                $('#patient_date_range_select_old_form').hide();

                $('#palliative_care_patients_with_pain_fiscal_years_form').hide();
                $('#palliative_care_patients_with_pain_date_range_select_form').hide();

                $('#form_all').hide();
                $('#palliative_care_menu').offcanvas('hide');

                Swal.close();
            // เริ่มต้น Hide End

            // จาก form ID "select" เลือกแบบ Realtime Start
                $('#select').change(function() {
                    var selectForm = $('#select').val();
                    if (selectForm != '0' && selectForm == '1') {
                        $('#palliative_count_death_form').show();
                        $('#form_all').show();
                        $('#palliative_list_name_form').hide();
                    } else if (selectForm != '0' && selectForm == '2') {
                        $('#palliative_list_name_form').show();
                        $('#form_all').show();
                        $('#palliative_count_death_form').hide();
                    } else {
                        $('#palliative_list_name_form').hide();
                        $('#palliative_list_name_table').hide();
                        $('#palliative_count_death_form').hide();
                        $('#palliative_count_death_all_chart').hide();
                        $('#form_all').hide();
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

                $('#selectFormPalliativeCarePatientsWithPain').change(function() {
                    var selectForm = $('#selectPalliativeCarePatientsWithPain').val();
                    if(selectForm != '0' && selectForm == '1') {
                        $('#palliative_care_patients_with_pain_fiscal_years_form').show();
                        $('#palliative_care_patients_with_pain_date_range_select_form').hide();
                    } else if(selectForm != '0' && selectForm == '2') {
                        $('#palliative_care_patients_with_pain_date_range_select_form').show();
                        $('#palliative_care_patients_with_pain_fiscal_years_form').hide();
                    } else {
                        $('#palliative_care_patients_with_pain_fiscal_years_form').hide();
                        $('#palliative_care_patients_with_pain_fiscal_years_form')[0].reset();
                        $('#palliative_care_patients_with_pain_date_range_select_form').hide();
                        $('#palliative_care_patients_with_pain_date_range_select_form')[0].reset();
                    }
                });
            // จาก form ID "select" เลือกแบบ Realtime End

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
                $('#advance_care_plan_modal').on('hidden.bs.modal', function () {
                    $('#advance_care_plan_form')[0].reset();
                });
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
                        $('#number_of_old_patients_select_fiscal_years_form').hide();
                        $("#number_of_old_patients_select_fiscal_years_form")[0].reset();
                        $('#patient_date_range_select_old_form').hide();
                        $('#patient_date_range_select_old_form')[0].reset();
                        $('#selectFormOldPalliativeCare')[0].reset();
                    } else if(mode === 'reset_form_palliative_care_patients_with_pain') {
                        $('#palliative_care_patients_with_pain_fiscal_years_form').hide();
                        $("#palliative_care_patients_with_pain_fiscal_years_form")[0].reset();
                        $('#palliative_care_patients_with_pain_date_range_select_form').hide();
                        $('#palliative_care_patients_with_pain_date_range_select_form')[0].reset();
                        $('#selectFormPalliativeCarePatientsWithPain')[0].reset();
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
                        $('#selectFormPalliativeCarePatientsWithPain')[0].reset();
                        $('#palliative_care_patients_with_pain_fiscal_years_form').hide();
                        $('#palliative_care_patients_with_pain_date_range_select_form').hide();
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
                        // ส่งคำขอข้อมูลไปยัง Route
                        url: '{{ route('getPalliativeCareSelectData') }}',
                        // Method Get
                        type: 'GET',
                        // ส่งข้อมูลด้วยตัวแปร formData
                        data: formData,
                        // เมื่อมีการส่ง Response กลับมา
                        success: function(response) {
                            Swal.close();

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

            function getPalliativeCareFetchListName() {
                var formData = $('#palliative_list_name_form').serialize();

                $('#palliative_list_name_table').hide();
                $('#palliative_count_death_all_chart').hide();
                $('#setText').hide();
                $('#setCount').hide();
                
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
                    url: '{{ route('getPalliativeCareFetchListName') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        Swal.close();
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
                                ],
                                "scrollX": true
                            });
                        }
                    }
                });
            }

            // ดึงข้อมูลรายชื่อคนไข้ Palliative Care ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต Start
                $('#palliative_list_name_submit').click(function(e) {
                    e.preventDefault();
                    getPalliativeCareFetchListName();
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
                        url: '{{ route('getHomeVisitingInformation') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
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
                        url: '{{ route('getHomeVisitingInformationZ718') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
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
                        url: '{{ route('getEclaimReceivedMoney') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $('#show-eclaim-received-money').show();
                            $("#show-eclaim-received-money").html(response);
                            $("#table-eclaim-received-money").DataTable({
                                responsive: true,
                                order: [5, 'desc'], // เลขตัวหน้าคือ Column, เลขตัวหลัง ASC => เรียงจากน้อยไปมาก, DESC => เรียงจากมากไปน้อย
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
                                ],
                                "scrollX": true
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
                        url: '{{ route('getNumberOfNewPatients') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
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
                                ],
                                "scrollX": true
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
                        url: '{{ route('getNumberOfNewPatientsSelectFiscalYears') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
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
                        url: '{{ route('getPatientDateRangeSelect') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
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
                        url: '{{ route('getNumberOfOldPatients') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
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
                                ],
                                "scrollX": true
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
                        url: '{{ route('getNumberOfOldPatientsSelectFiscalYears') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า ของปีงบประมาณ ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า กำหนดเอง ตามค่าที่ส่งไป Start
                $('#patient_date_range_select_old_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#patient_date_range_select_old_form').serialize();
                    $('#show-number-of-old-patients').hide();
                    
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
                        url: '{{ route('getPatientDateRangeSelectOld') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care รายเก่า กำหนดเอง ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ค่าเริ่มต้น Start
                $(document).on('click', '.palliative-care-patients-with-pain', function (e) {
                    e.preventDefault();
                    $('#show-palliative-care-patients-with-pain').hide();
                    hideForm();
                    
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
                        url: '{{ route('getPalliativeCarePatientsPain') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
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
                                ],
                                "scrollX": true
                            });
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ค่าเริ่มต้น End

            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ของปีงบประมาณ ตามค่าที่ส่งไป Start
                $('#palliative_care_patients_with_pain_fiscal_years_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#palliative_care_patients_with_pain_fiscal_years_form').serialize();
                    $('#show-palliative-care-patients-with-pain').hide();
                    
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
                        url: '{{ route('getPalliativeCarePatientsWithPainFiscalYears') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) ของปีงบประมาณ ตามค่าที่ส่งไป End

            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) กำหนดเอง ตามค่าที่ส่งไป Start
                $('#palliative_care_patients_with_pain_date_range_select_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#palliative_care_patients_with_pain_date_range_select_form').serialize();
                    $('#show-palliative-care-patients-with-pain').hide();
                    
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
                        url: '{{ route('getPalliativeCarePatientsWithPainDateRangeSelect') }}',
                        method: 'get',
                        data: formData,
                        success: function(response) {
                            Swal.close();
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลผู้ป่วย Palliative Care ที่มีอาการปวด( Pain ) กำหนดเอง ตามค่าที่ส่งไป End

            // Advance Care Plan Setting Insert Start
                $(document).on('click', '.advance_care_plan_add', function (e) {
                    e.preventDefault();
                    let vn = $(this).attr('id');
                    var fullname = $(this).data('fullname');
                    var hn = $(this).data('hn');
                    var cid = $(this).data('cid');

                    $('#acp_cid').val(cid);
                    $('#acp_vn').val(vn);
                    $('#acp_hn').val(hn);
                    $('#acp_fullname').val(fullname);

                    $('#mode').attr('mode', 'add');
                    $('#advance_care_plan_title').text('เพิ่มข้อมูล');
                });
            // Advance Care Plan Setting Insert End

            // Advance Care Plan Insert Data Start
                $('#advance_care_plan_form').submit(function(e) {
                    const mode = $('#mode').attr('mode');

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

                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataAdvanceCarePlan') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                Swal.close(); // Close Swal when the request is successful
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        tile: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        getPalliativeCareFetchListName();
                                        $("#advance_care_plan_form")[0].reset();
                                        $("#advance_care_plan_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    }
                });
            // Advance Care Plan Insert Data End

            // Advance Care Plan Detail Start
                $(document).on('click', '.advance_care_plan_detail', function(e) {
                    e.preventDefault();
                    let vn = $(this).data('vn'); // ดึงค่า vn จาก data attribute
                    
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
                        url: '{{ route('showDataAdvanceCarePlanDetail') }}',
                        method: 'get',
                        data: { vn: vn }, // ส่ง vn เป็น key-value
                        dataType: 'json',
                        success: function(response) {
                            Swal.close(); // Close Swal when the request is successful
                            $('#show_advance_care_plan_detail').show();
                            $("#show_advance_care_plan_detail").html(response);
                        }
                    });
                });
            // Advance Care Plan Detail End

            // เมื่อผู้ใช้คลิกที่รูปภาพ ในส่วนของ Advance Care Plan Detail Start
                $('#imageModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // ปุ่มหรือรูปที่ถูกคลิก
                    var imgSrc = button.data('img'); // ดึง URL ของรูปจาก attribute data-img
                    var modal = $(this);
                    modal.find('#imageModalSrc').attr('src', imgSrc); // ตั้งค่า src ของรูปใน modal ให้ตรงกับรูปที่ถูกคลิก
                });
            // เมื่อผู้ใช้คลิกที่รูปภาพ ในส่วนของ Advance Care Plan Detail End
        });
    </script>
@endsection
