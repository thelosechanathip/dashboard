<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pages\OvstController;
use App\Http\Controllers\Pages\ErRegistController;
use App\Http\Controllers\Pages\ReferOutController;
use App\Http\Controllers\Pages\ReferInController;
use App\Http\Controllers\Pages\IptController;
use App\Http\Controllers\Pages\OpdScreenController;
use App\Http\Controllers\Pages\WardController;
use App\Http\Controllers\Pages\HealthMedServiceController;
use App\Http\Controllers\Pages\HealthMedServiceDetailController;
use App\Http\Controllers\Pages\PhysicController;
use App\Http\Controllers\Pages\PhysicDetailController;
use App\Http\Controllers\Reportes\AuthenCodeController;
use App\Http\Controllers\Reportes\PCU\RPCUController;
use App\Http\Controllers\Reportes\PCU\ReportZ237Controller;
use App\Http\Controllers\Reportes\PCU\ReportZ242Controller;
use App\Http\Controllers\Reportes\PCU\ReportZ251Controller;
use App\Http\Controllers\Reportes\PCU\ReportPatientsUtilizingIcd10CodesController;
use App\Http\Controllers\Reportes\PCU\ReportCXR4100341004Controller;
use App\Http\Controllers\Reportes\PCU\ReportMixedBuildingController;
use App\Http\Controllers\Reportes\PCU\ReportMonkNunController;
use App\Http\Controllers\Program\ReceivingChartsController;
use App\Http\Controllers\Program\PalliativeCareController;
use App\Http\Controllers\Program\Sub_page\AdvanceCarePlanController;
use App\Http\Controllers\Program\Sub_page\PCCancerController;
use App\Http\Controllers\Program\Sub_page\PCStrokeController;
use App\Http\Controllers\Program\Sub_page\PCCKD5Controller;
use App\Http\Controllers\Program\Sub_page\PCCOPDController;
use App\Http\Controllers\Program\Sub_page\PCTBIController;
use App\Http\Controllers\Program\Sub_page\PCSCIController;
use App\Http\Controllers\Program\Sub_page\PCSenitityController;
use App\Http\Controllers\Program\Sub_page\PCDementiaController;
use App\Http\Controllers\Program\Sub_page\PCACSController;
use App\Http\Controllers\Program\Sub_page\PCSTEMIController;
use App\Http\Controllers\Program\Sub_page\PCAllPatientsController;
use App\Http\Controllers\Program\Sub_page\PCListOfDeceasedPatientsController AS DeceasedPatientsController;
use App\Http\Controllers\Program\Sub_page\PCListOfLivingPatientsController AS LivingPatientsController;
use App\Http\Controllers\Program\Sub_page\PCEClaimWithdrawalController;
use App\Http\Controllers\Program\AncQualityController;
use App\Http\Controllers\IT\ItHomeController;
use App\Http\Controllers\IT\RepairNotificationSystemController;
use App\Http\Controllers\IT\WorkingTypeController;
use App\Http\Controllers\IT\SystemInfoController;
use App\Http\Controllers\IT\TestAllController;
use App\Http\Controllers\Setting\ModuleAccessRightsController;
use App\Http\Controllers\Setting\SidebarMenuController;
use App\Http\Controllers\Setting\AnnouncementAndVersionController;

// Test Start
    use App\Http\Controllers\Alert\PttypeErrorController;
// Test End

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/verify-username', [AuthController::class, 'verifyUsername'])->name('verify-username');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.session.login'])->group(function() {
    Route::get('/', [AuthController::class, 'index'])->name('index');
});

Route::middleware(['check.something'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('check_status', [DashboardController::class, 'check_status'])->name('check_status');
    Route::get('check_group_and_user', [DashboardController::class, 'check_group_and_user'])->name('check_group_and_user');
    Route::get('query_all_count_data', [DashboardController::class, 'query_all_count_data'])->name('query_all_count_data');
    Route::get('checkStatusSidebarMainMenu', [DashboardController::class, 'checkStatusSidebarMainMenu'])->name('checkStatusSidebarMainMenu');

    // Pages Start
        // Ovst Start
            Route::get('indexOvst', [OvstController::class, 'index'])->name('indexOvst');
            Route::get('showOvst', [OvstController::class, 'showOvst'])->name('showOvst');
            Route::get('getOvstData', [OvstController::class, 'getOvstData'])->name('getOvstData');
            Route::get('getOvstDailyData', [OvstController::class, 'getOvstDailyData'])->name('getOvstDailyData');
            Route::get('getOvstSelectData', [OvstController::class, 'getOvstSelectData'])->name('getOvstSelectData');
        // Ovst End
        
        // Opd Screen Start
            Route::get('indexOpdScreen', [OpdScreenController::class, 'index'])->name('indexOpdScreen');
            Route::get('showOpdScreen', [OpdScreenController::class, 'showOpdScreen'])->name('showOpdScreen');
            Route::get('getOpdScreenData', [OpdScreenController::class, 'getOpdScreenData'])->name('getOpdScreenData');
            Route::get('getOpdScreenDailyData', [OpdScreenController::class, 'getOpdScreenDailyData'])->name('getOpdScreenDailyData');
            Route::get('getOpdScreenSelectData', [OpdScreenController::class, 'getOpdScreenSelectData'])->name('getOpdScreenSelectData');
        // Opd Screen End

        // Er Regist Start
            Route::get('indexErRegist', [ErRegistController::class, 'index'])->name('indexErRegist');
            Route::get('showErRegist', [ErRegistController::class, 'showErRegist'])->name('showErRegist');
            Route::get('getErRegistData', [ErRegistController::class, 'getErRegistData'])->name('getErRegistData');
            Route::get('getErRegistDailyData', [ErRegistController::class, 'getErRegistDailyData'])->name('getErRegistDailyData');
            Route::get('getErRegistSelectData', [ErRegistController::class, 'getErRegistSelectData'])->name('getErRegistSelectData');
        // Er Regist End

        // Refer Out Start
            Route::get('indexReferOut', [ReferOutController::class, 'index'])->name('indexReferOut');
            Route::get('showReferOut', [ReferOutController::class, 'showReferOut'])->name('showReferOut');
            Route::get('getReferOutData', [ReferOutController::class, 'getReferOutData'])->name('getReferOutData');
            Route::get('getReferOutDailyData', [ReferOutController::class, 'getReferOutDailyData'])->name('getReferOutDailyData');
            Route::get('getReferOutSelectData', [ReferOutController::class, 'getReferOutSelectData'])->name('getReferOutSelectData');
        // Refer Out End

        // Refer In Start
            Route::get('indexReferIn', [ReferInController::class, 'index'])->name('indexReferIn');
            Route::get('showReferIn', [ReferInController::class, 'showReferIn'])->name('showReferIn');
            Route::get('getReferInData', [ReferInController::class, 'getReferInData'])->name('getReferInData');
            Route::get('getReferInDailyData', [ReferInController::class, 'getReferInDailyData'])->name('getReferInDailyData');
            Route::get('getReferInSelectData', [ReferInController::class, 'getReferInSelectData'])->name('getReferInSelectData');
        // Refer In End

        // Ipt Start
            Route::get('indexIpt', [IptController::class, 'index'])->name('indexIpt');
            Route::get('showIpt', [IptController::class, 'showIpt'])->name('showIpt');
            Route::get('getIptData', [IptController::class, 'getIptData'])->name('getIptData');
            Route::get('getIptDailyData', [IptController::class, 'getIptDailyData'])->name('getIptDailyData');
            Route::get('getIptSelectData', [IptController::class, 'getIptSelectData'])->name('getIptSelectData');
            Route::get('getIptNameDoctorData', [IptController::class, 'getIptNameDoctorData'])->name('getIptNameDoctorData');
            Route::get('getResultCountYearsDoctor', [IptController::class, 'getResultCountYearsDoctor'])->name('getResultCountYearsDoctor');
            Route::get('getResultCountMonthDoctor', [IptController::class, 'getResultCountMonthDoctor'])->name('getResultCountMonthDoctor');
            Route::get('getResultCountDateDoctor', [IptController::class, 'getResultCountDateDoctor'])->name('getResultCountDateDoctor');
            Route::get('checkStatusWard', [IptController::class, 'checkStatusWard'])->name('checkStatusWard');
            Route::get('getResultWard', [IptController::class, 'getResultWard'])->name('getResultWard');
            Route::get('getResultCountAdmissionPointsSummaryYears', [IptController::class, 'getResultCountAdmissionPointsSummaryYears'])->name('getResultCountAdmissionPointsSummaryYears');
            Route::get('getResultCountAdmissionPointsSummaryMonth', [IptController::class, 'getResultCountAdmissionPointsSummaryMonth'])->name('getResultCountAdmissionPointsSummaryMonth');
            Route::get('getResultCountAdmissionPointsSummaryDate', [IptController::class, 'getResultCountAdmissionPointsSummaryDate'])->name('getResultCountAdmissionPointsSummaryDate');
        // Ipt End

        // Ward Start
            Route::get('/ward/{wardId}', [WardController::class, 'show'])->name('ward.details');
            Route::get('getIptWardData', [WardController::class, 'getIptWardData'])->name('getIptWardData');
            Route::get('getIptWardDailyData', [WardController::class, 'getIptWardDailyData'])->name('getIptWardDailyData');
            Route::get('getIptWardSelectData', [WardController::class, 'getIptWardSelectData'])->name('getIptWardSelectData');
        // Ward End

        // Palliative Care Start
            Route::get('palliative_care/{id}', [PalliativeCareController::class, 'index'])->name('palliative_care');
            Route::get('getPalliativeCareSelectData', [PalliativeCareController::class, 'getPalliativeCareSelectData'])->name('getPalliativeCareSelectData');
            Route::get('getPalliativeCareFetchListName', [PalliativeCareController::class, 'getPalliativeCareFetchListName'])->name('getPalliativeCareFetchListName');
            Route::get('getHomeVisitingInformation', [PalliativeCareController::class, 'getHomeVisitingInformation'])->name('getHomeVisitingInformation');
            Route::get('getHomeVisitingInformationZ718', [PalliativeCareController::class, 'getHomeVisitingInformationZ718'])->name('getHomeVisitingInformationZ718');
            Route::get('getEclaimReceivedMoney', [PalliativeCareController::class, 'getEclaimReceivedMoney'])->name('getEclaimReceivedMoney');
            Route::get('getNumberOfNewPatients', [PalliativeCareController::class, 'getNumberOfNewPatients'])->name('getNumberOfNewPatients');
            Route::get('getNumberOfNewPatientsSelectFiscalYears', [PalliativeCareController::class, 'getNumberOfNewPatientsSelectFiscalYears'])->name('getNumberOfNewPatientsSelectFiscalYears');
            Route::get('getPatientDateRangeSelect', [PalliativeCareController::class, 'getPatientDateRangeSelect'])->name('getPatientDateRangeSelect');
            Route::get('getNumberOfOldPatients', [PalliativeCareController::class, 'getNumberOfOldPatients'])->name('getNumberOfOldPatients');
            Route::get('getNumberOfOldPatientsSelectFiscalYears', [PalliativeCareController::class, 'getNumberOfOldPatientsSelectFiscalYears'])->name('getNumberOfOldPatientsSelectFiscalYears');
            Route::get('getPatientDateRangeSelectOld', [PalliativeCareController::class, 'getPatientDateRangeSelectOld'])->name('getPatientDateRangeSelectOld');
            Route::get('getPalliativeCarePatientsPain', [PalliativeCareController::class, 'getPalliativeCarePatientsPain'])->name('getPalliativeCarePatientsPain');
            Route::get('getPalliativeCarePatientsWithPainFiscalYears', [PalliativeCareController::class, 'getPalliativeCarePatientsWithPainFiscalYears'])->name('getPalliativeCarePatientsWithPainFiscalYears');
            Route::get('getPalliativeCarePatientsWithPainDateRangeSelect', [PalliativeCareController::class, 'getPalliativeCarePatientsWithPainDateRangeSelect'])->name('getPalliativeCarePatientsWithPainDateRangeSelect');
            
            // Advance Care Plan Start
                Route::get('advance_care_plan', [AdvanceCarePlanController::class, 'index'])->name('advance_care_plan');
                Route::post('insertDataAdvanceCarePlan', [AdvanceCarePlanController::class, 'insertDataAdvanceCarePlan'])->name('insertDataAdvanceCarePlan');
                Route::get('showDataAdvanceCarePlanDetail', [AdvanceCarePlanController::class, 'showDataAdvanceCarePlanDetail'])->name('showDataAdvanceCarePlanDetail');
                Route::get('fetchAllAdvanceCarePlan', [AdvanceCarePlanController::class, 'fetchAllAdvanceCarePlan'])->name('fetchAllAdvanceCarePlan');
                Route::get('findOneAdvanceCarePlan', [AdvanceCarePlanController::class, 'findOneAdvanceCarePlan'])->name('findOneAdvanceCarePlan');
                Route::post('updateDataAdvanceCarePlan', [AdvanceCarePlanController::class, 'updateDataAdvanceCarePlan'])->name('updateDataAdvanceCarePlan');
                Route::delete('deleteAdvanceCarePlan', [AdvanceCarePlanController::class, 'deleteAdvanceCarePlan'])->name('deleteAdvanceCarePlan');
            // Advance Care Plan End

            // Cancer(โรคมะเร็ง) Start
                Route::get('pc_cancer_index/{id}', [PCCancerController::class, 'index'])->name('pc_cancer_index');
                Route::get('getCancerSelectData', [PCCancerController::class, 'getCancerSelectData'])->name('getCancerSelectData');
                Route::get('getCancerFetchListName', [PCCancerController::class, 'getCancerFetchListName'])->name('getCancerFetchListName');
                Route::get('getCancerHomeVisitingInformationZ718', [PCCancerController::class, 'getCancerHomeVisitingInformationZ718'])->name('getCancerHomeVisitingInformationZ718');
                Route::get('getCancerHomeVisitingInformation', [PCCancerController::class, 'getCancerHomeVisitingInformation'])->name('getCancerHomeVisitingInformation');
            // Cancer(โรคมะเร็ง) End

            // Stroke(โรคหลอดเลือดสมอง) Start
                Route::get('pc_stroke_index/{id}', [PCStrokeController::class, 'index'])->name('pc_stroke_index');
                Route::get('getStrokeSelectData', [PCStrokeController::class, 'getStrokeSelectData'])->name('getStrokeSelectData');
                Route::get('getStrokeFetchListName', [PCStrokeController::class, 'getStrokeFetchListName'])->name('getStrokeFetchListName');
                Route::get('getStrokeHomeVisitingInformationZ718', [PCStrokeController::class, 'getStrokeHomeVisitingInformationZ718'])->name('getStrokeHomeVisitingInformationZ718');
                Route::get('getStrokeHomeVisitingInformation', [PCStrokeController::class, 'getStrokeHomeVisitingInformation'])->name('getStrokeHomeVisitingInformation');
            // Stroke(โรคหลอดเลือดสมอง) End

            // CKD5(โรคไตเรื้อรังระยะสุดท้าย) Start
                Route::get('pc_ckd5_index/{id}', [PCCKD5Controller::class, 'index'])->name('pc_ckd5_index');
                Route::get('getCKD5SelectData', [PCCKD5Controller::class, 'getCKD5SelectData'])->name('getCKD5SelectData');
                Route::get('getCKD5FetchListName', [PCCKD5Controller::class, 'getCKD5FetchListName'])->name('getCKD5FetchListName');
                Route::get('getCKD5HomeVisitingInformationZ718', [PCCKD5Controller::class, 'getCKD5HomeVisitingInformationZ718'])->name('getCKD5HomeVisitingInformationZ718');
                Route::get('getCKD5HomeVisitingInformation', [PCCKD5Controller::class, 'getCKD5HomeVisitingInformation'])->name('getCKD5HomeVisitingInformation');
            // CKD5(โรคไตเรื้อรังระยะสุดท้าย) End

            // COPD(โรคหลอดลมอุดกั้นเรื้อรัง) Start
                Route::get('pc_copd_index/{id}', [PCCOPDController::class, 'index'])->name('pc_copd_index');
                Route::get('getCOPDSelectData', [PCCOPDController::class, 'getCOPDSelectData'])->name('getCOPDSelectData');
                Route::get('getCOPDFetchListName', [PCCOPDController::class, 'getCOPDFetchListName'])->name('getCOPDFetchListName');
                Route::get('getCOPDHomeVisitingInformationZ718', [PCCOPDController::class, 'getCOPDHomeVisitingInformationZ718'])->name('getCOPDHomeVisitingInformationZ718');
                Route::get('getCOPDHomeVisitingInformation', [PCCOPDController::class, 'getCOPDHomeVisitingInformation'])->name('getCOPDHomeVisitingInformation');
            // COPD(โรคหลอดลมอุดกั้นเรื้อรัง) End

            // TBI(Traumatic Brain Injury) Start
                Route::get('pc_tbi_index/{id}', [PCTBIController::class, 'index'])->name('pc_tbi_index');
                Route::get('getTBISelectData', [PCTBIController::class, 'getTBISelectData'])->name('getTBISelectData');
                Route::get('getTBIFetchListName', [PCTBIController::class, 'getTBIFetchListName'])->name('getTBIFetchListName');
                Route::get('getTBIHomeVisitingInformationZ718', [PCTBIController::class, 'getTBIHomeVisitingInformationZ718'])->name('getTBIHomeVisitingInformationZ718');
                Route::get('getTBIHomeVisitingInformation', [PCTBIController::class, 'getTBIHomeVisitingInformation'])->name('getTBIHomeVisitingInformation');
            // TBI(Traumatic Brain Injury) End
            
            // SCI(Spinal cord injury) Start
                Route::get('pc_sci_index/{id}', [PCSCIController::class, 'index'])->name('pc_sci_index');
                Route::get('getSCISelectData', [PCSCIController::class, 'getSCISelectData'])->name('getSCISelectData');
                Route::get('getSCIFetchListName', [PCSCIController::class, 'getSCIFetchListName'])->name('getSCIFetchListName');
                Route::get('getSCIHomeVisitingInformationZ718', [PCSCIController::class, 'getSCIHomeVisitingInformationZ718'])->name('getSCIHomeVisitingInformationZ718');
                Route::get('getSCIHomeVisitingInformation', [PCSCIController::class, 'getSCIHomeVisitingInformation'])->name('getSCIHomeVisitingInformation');
            // SCI(Spinal cord injury) End

            // Senitity(ผู้ป่วยสูงอายุ) Start
                Route::get('pc_senitity_index/{id}', [PCSenitityController::class, 'index'])->name('pc_senitity_index');
                Route::get('getSenititySelectData', [PCSenitityController::class, 'getSenititySelectData'])->name('getSenititySelectData');
                Route::get('getSenitityFetchListName', [PCSenitityController::class, 'getSenitityFetchListName'])->name('getSenitityFetchListName');
                Route::get('getSenitityHomeVisitingInformationZ718', [PCSenitityController::class, 'getSenitityHomeVisitingInformationZ718'])->name('getSenitityHomeVisitingInformationZ718');
                Route::get('getSenitityHomeVisitingInformation', [PCSenitityController::class, 'getSenitityHomeVisitingInformation'])->name('getSenitityHomeVisitingInformation');
            // Senitity(ผู้ป่วยสูงอายุ) End

            // Dementia(ผู้ป่วยภาวะสมองเสื่อม) Start
                Route::get('pc_dementia_index/{id}', [PCDementiaController::class, 'index'])->name('pc_dementia_index');
                Route::get('getDementiaSelectData', [PCDementiaController::class, 'getDementiaSelectData'])->name('getDementiaSelectData');
                Route::get('getDementiaFetchListName', [PCDementiaController::class, 'getDementiaFetchListName'])->name('getDementiaFetchListName');
                Route::get('getDementiaHomeVisitingInformationZ718', [PCDementiaController::class, 'getDementiaHomeVisitingInformationZ718'])->name('getDementiaHomeVisitingInformationZ718');
                Route::get('getDementiaHomeVisitingInformation', [PCDementiaController::class, 'getDementiaHomeVisitingInformation'])->name('getDementiaHomeVisitingInformation');
            // Dementia(ผู้ป่วยภาวะสมองเสื่อม) End

            // ACS(ผู้ป่วยภาวะกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน) Start
                Route::get('pc_acs_index/{id}', [PCACSController::class, 'index'])->name('pc_acs_index');
                Route::get('getACSSelectData', [PCACSController::class, 'getACSSelectData'])->name('getACSSelectData');
                Route::get('getACSFetchListName', [PCACSController::class, 'getACSFetchListName'])->name('getACSFetchListName');
                Route::get('getACSHomeVisitingInformationZ718', [PCACSController::class, 'getACSHomeVisitingInformationZ718'])->name('getACSHomeVisitingInformationZ718');
                Route::get('getACSHomeVisitingInformation', [PCACSController::class, 'getACSHomeVisitingInformation'])->name('getACSHomeVisitingInformation');
            // ACS(ผู้ป่วยภาวะกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน) End

            // STEMI(ผู้ป่วยหัวใจขาดเลือดเฉียบพลัน) Start
                Route::get('pc_stemi_index/{id}', [PCSTEMIController::class, 'index'])->name('pc_stemi_index');
                Route::get('getSTEMISelectData', [PCSTEMIController::class, 'getSTEMISelectData'])->name('getSTEMISelectData');
                Route::get('getSTEMIFetchListName', [PCSTEMIController::class, 'getSTEMIFetchListName'])->name('getSTEMIFetchListName');
                Route::get('getSTEMIHomeVisitingInformationZ718', [PCSTEMIController::class, 'getSTEMIHomeVisitingInformationZ718'])->name('getSTEMIHomeVisitingInformationZ718');
                Route::get('getSTEMIHomeVisitingInformation', [PCSTEMIController::class, 'getSTEMIHomeVisitingInformation'])->name('getSTEMIHomeVisitingInformation');
            // STEMI(ผู้ป่วยหัวใจขาดเลือดเฉียบพลัน) End

            // All Patients(ผู้ป่วยทั้งหมด) Start
                Route::get('pc_all_patients_index/{id}', [PCAllPatientsController::class, 'index'])->name('pc_all_patients_index');
                Route::get('getAllPatientsFetchListName', [PCAllPatientsController::class, 'getAllPatientsFetchListName'])->name('getAllPatientsFetchListName');
                Route::get('getAllPatientsHomeVisitingInformationZ718', [PCAllPatientsController::class, 'getAllPatientsHomeVisitingInformationZ718'])->name('getAllPatientsHomeVisitingInformationZ718');
                Route::get('getAllPatientsHomeVisitingInformation', [PCAllPatientsController::class, 'getAllPatientsHomeVisitingInformation'])->name('getAllPatientsHomeVisitingInformation');
            // All Patients(ผู้ป่วยทั้งหมด) End

            // List of deceased patients(ผู้ป่วยที่เสียชีวิต) Start
                Route::get('pc_list_of_deceased_patients_index/{id}', [DeceasedPatientsController::class, 'index'])->name('pc_list_of_deceased_patients_index');
                Route::get('getListOfDeceasedPatientsFetchListName', [DeceasedPatientsController::class, 'getListOfDeceasedPatientsFetchListName'])->name('getListOfDeceasedPatientsFetchListName');
                Route::get('getListOfDeceasedPatientsHomeVisitingInformation', [DeceasedPatientsController::class, 'getListOfDeceasedPatientsHomeVisitingInformation'])->name('getListOfDeceasedPatientsHomeVisitingInformation');
            // List of deceased patients(ผู้ป่วยที่เสียชีวิต) End

            // List of living patients(ผู้ป่วยที่ยังมีชีวิต) Start
                Route::get('pc_list_of_living_patients_index/{id}', [LivingPatientsController::class, 'index'])->name('pc_list_of_living_patients_index');
                Route::get('getListOfLivingPatientsFetchListName', [LivingPatientsController::class, 'getListOfLivingPatientsFetchListName'])->name('getListOfLivingPatientsFetchListName');
                Route::get('getListOfLivingPatientsHomeVisitingInformation', [LivingPatientsController::class, 'getListOfLivingPatientsHomeVisitingInformation'])->name('getListOfLivingPatientsHomeVisitingInformation');
            // List of living patients(ผู้ป่วยที่ยังมีชีวิต) End

            // E-claim withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) Start
                Route::get('pc_e_claim_withdrawal_index/{id}', [PCEClaimWithdrawalController::class, 'index'])->name('pc_e_claim_withdrawal_index');
                Route::get('getEClaimWithdrawalFetchListName', [PCEClaimWithdrawalController::class, 'getEClaimWithdrawalFetchListName'])->name('getEClaimWithdrawalFetchListName');
            // E-claim withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) End
        // Palliative Care End

        // Health Med Service Start
            Route::get('indexHealthMedService', [HealthMedServiceController::class, 'index'])->name('indexHealthMedService');
            Route::get('showHealthMedService', [HealthMedServiceController::class, 'showHealthMedService'])->name('showHealthMedService');
            Route::get('getHealthMedServiceData', [HealthMedServiceController::class, 'getHealthMedServiceData'])->name('getHealthMedServiceData');
            Route::get('getHealthMedServiceDailyData', [HealthMedServiceController::class, 'getHealthMedServiceDailyData'])->name('getHealthMedServiceDailyData');
            Route::get('getHealthMedServiceSelectData', [HealthMedServiceController::class, 'getHealthMedServiceSelectData'])->name('getHealthMedServiceSelectData');
            Route::get('checkStatusHealthMedService', [HealthMedServiceController::class, 'checkStatusHealthMedService'])->name('checkStatusHealthMedService');
            Route::get('getResultHealthMedService', [HealthMedServiceController::class, 'getResultHealthMedService'])->name('getResultHealthMedService');
            Route::get('getResultSexCountYears', [HealthMedServiceController::class, 'getResultSexCountYears'])->name('getResultSexCountYears');
            Route::get('getResultAgeCountYears', [HealthMedServiceController::class, 'getResultAgeCountYears'])->name('getResultAgeCountYears');
            Route::get('getResultPttypeCountYears', [HealthMedServiceController::class, 'getResultPttypeCountYears'])->name('getResultPttypeCountYears');
            Route::get('getResultTreatmentSubtypeCountYears', [HealthMedServiceController::class, 'getResultTreatmentSubtypeCountYears'])->name('getResultTreatmentSubtypeCountYears');
            Route::get('getResultICD10CountYears', [HealthMedServiceController::class, 'getResultICD10CountYears'])->name('getResultICD10CountYears');
            Route::get('getResultSexCountMonth', [HealthMedServiceController::class, 'getResultSexCountMonth'])->name('getResultSexCountMonth');
            Route::get('getResultAgeCountMonth', [HealthMedServiceController::class, 'getResultAgeCountMonth'])->name('getResultAgeCountMonth');
            Route::get('getResultPttypeCountMonth', [HealthMedServiceController::class, 'getResultPttypeCountMonth'])->name('getResultPttypeCountMonth');
            Route::get('getResultTreatmentSubtypeCountMonth', [HealthMedServiceController::class, 'getResultTreatmentSubtypeCountMonth'])->name('getResultTreatmentSubtypeCountMonth');
            Route::get('getResultICD10CountMonth', [HealthMedServiceController::class, 'getResultICD10CountMonth'])->name('getResultICD10CountMonth');
            Route::get('getResultSexCountDate', [HealthMedServiceController::class, 'getResultSexCountDate'])->name('getResultSexCountDate');
            Route::get('getResultAgeCountDate', [HealthMedServiceController::class, 'getResultAgeCountDate'])->name('getResultAgeCountDate');
            Route::get('getResultPttypeCountDate', [HealthMedServiceController::class, 'getResultPttypeCountDate'])->name('getResultPttypeCountDate');
            Route::get('getResultTreatmentSubtypeCountDate', [HealthMedServiceController::class, 'getResultTreatmentSubtypeCountDate'])->name('getResultTreatmentSubtypeCountDate');
            Route::get('getResultICD10CountDate', [HealthMedServiceController::class, 'getResultICD10CountDate'])->name('getResultICD10CountDate');
        // Health Med Service End

        // Health Med Server Detail Start
            Route::get('IndexHealthMedServiceDetail', [HealthMedServiceDetailController::class, 'index'])->name('IndexHealthMedServiceDetail');
            Route::get('showHealthMedServiceDetail', [HealthMedServiceDetailController::class, 'showHealthMedServiceDetail'])->name('showHealthMedServiceDetail');
            Route::get('getHealthMedServiceDetailData', [HealthMedServiceDetailController::class, 'getHealthMedServiceDetailData'])->name('getHealthMedServiceDetailData');
            Route::get('getHealthMedServiceDetailDailyData', [HealthMedServiceDetailController::class, 'getHealthMedServiceDetailDailyData'])->name('getHealthMedServiceDetailDailyData');
            Route::get('getHealthMedServiceDetailSelectData', [HealthMedServiceDetailController::class, 'getHealthMedServiceDetailSelectData'])->name('getHealthMedServiceDetailSelectData');
            Route::get('getResultSexDetailCountYears', [HealthMedServiceDetailController::class, 'getResultSexDetailCountYears'])->name('getResultSexDetailCountYears');
            Route::get('getResultAgeDetailCountYears', [HealthMedServiceDetailController::class, 'getResultAgeDetailCountYears'])->name('getResultAgeDetailCountYears');
            Route::get('getResultPttypeDetailCountYears', [HealthMedServiceDetailController::class, 'getResultPttypeDetailCountYears'])->name('getResultPttypeDetailCountYears');
            Route::get('getResultTreatmentSubtypeDetailCountYears', [HealthMedServiceDetailController::class, 'getResultTreatmentSubtypeDetailCountYears'])->name('getResultTreatmentSubtypeDetailCountYears');
            Route::get('getResultICD10DetailCountYears', [HealthMedServiceDetailController::class, 'getResultICD10DetailCountYears'])->name('getResultICD10DetailCountYears');
            Route::get('getResultSexDetailCountMonth', [HealthMedServiceDetailController::class, 'getResultSexDetailCountMonth'])->name('getResultSexDetailCountMonth');
            Route::get('getResultAgeDetailCountMonth', [HealthMedServiceDetailController::class, 'getResultAgeDetailCountMonth'])->name('getResultAgeDetailCountMonth');
            Route::get('getResultPttypeDetailCountMonth', [HealthMedServiceDetailController::class, 'getResultPttypeDetailCountMonth'])->name('getResultPttypeDetailCountMonth');
            Route::get('getResultTreatmentSubtypeDetailCountMonth', [HealthMedServiceDetailController::class, 'getResultTreatmentSubtypeDetailCountMonth'])->name('getResultTreatmentSubtypeDetailCountMonth');
            Route::get('getResultICD10DetailCountMonth', [HealthMedServiceDetailController::class, 'getResultICD10DetailCountMonth'])->name('getResultICD10DetailCountMonth');
            Route::get('getResultSexDetailCountDate', [HealthMedServiceDetailController::class, 'getResultSexDetailCountDate'])->name('getResultSexDetailCountDate');
            Route::get('getResultAgeDetailCountDate', [HealthMedServiceDetailController::class, 'getResultAgeDetailCountDate'])->name('getResultAgeDetailCountDate');
            Route::get('getResultPttypeDetailCountDate', [HealthMedServiceDetailController::class, 'getResultPttypeDetailCountDate'])->name('getResultPttypeDetailCountDate');
            Route::get('getResultTreatmentSubtypeDetailCountDate', [HealthMedServiceDetailController::class, 'getResultTreatmentSubtypeDetailCountDate'])->name('getResultTreatmentSubtypeDetailCountDate');
            Route::get('getResultICD10DetailCountDate', [HealthMedServiceDetailController::class, 'getResultICD10DetailCountDate'])->name('getResultICD10DetailCountDate');
        // Health Med Server Detail End

        // Physic Start
            Route::get('indexPhysic', [PhysicController::class, 'index'])->name('indexPhysic');
            Route::get('showPhysic', [PhysicController::class, 'showPhysic'])->name('showPhysic');
            Route::get('getPhysicData', [PhysicController::class, 'getPhysicData'])->name('getPhysicData');
            Route::get('getPhysicDailyData', [PhysicController::class, 'getPhysicDailyData'])->name('getPhysicDailyData');
            Route::get('getPhysicSelectData', [PhysicController::class, 'getPhysicSelectData'])->name('getPhysicSelectData');
            Route::get('checkStatusPhysic', [PhysicController::class, 'checkStatusPhysic'])->name('checkStatusPhysic');
            Route::get('getResultPhysic', [PhysicController::class, 'getResultPhysic'])->name('getResultPhysic');
        // Physic End

        // Physic Detail Start
            Route::get('IndexPhysicDetail', [PhysicDetailController::class, 'index'])->name('IndexPhysicDetail');
            Route::get('showPhysicDetail', [PhysicDetailController::class, 'showPhysicDetail'])->name('showPhysicDetail');
            Route::get('getPhysicDetailData', [PhysicDetailController::class, 'getPhysicDetailData'])->name('getPhysicDetailData');
            Route::get('getPhysicDetailDailyData', [PhysicDetailController::class, 'getPhysicDetailDailyData'])->name('getPhysicDetailDailyData');
            Route::get('getPhysicDetailSelectData', [PhysicDetailController::class, 'getPhysicDetailSelectData'])->name('getPhysicDetailSelectData');
        // Physic Detail End

        //ANC Quality Start
            Route::get('IndexAncQuality/{id}', [AncQualityController::class, 'index'])->name('IndexAncQuality');
            Route::post('getResultAncQuality', [AncQualityController::class, 'getResult'])->name('getResultAncQuality');
            Route::get('exportPDFAncQuality', [AncQualityController::class, 'exportPDF'])->name('exportPDFAncQuality');
        //ANC Quality End

    // Pages End

    // Reportes Start
        // Authen Code Start
            Route::get('report_index_authen_code/{id}', [AuthenCodeController::class, 'index'])->name('report_index_authen_code');
            Route::get('getAuthenCodeCount', [AuthenCodeController::class, 'getAuthenCodeCount'])->name('getAuthenCodeCount');
            Route::get('authenCodeFetchAll', [AuthenCodeController::class, 'authenCodeFetchAll'])->name('authenCodeFetchAll');
            Route::get('exportNotAuthenCode', [AuthenCodeController::class, 'exportNotAuthenCode'])->name('exportNotAuthenCode');
            Route::get('downloadAuthenCode', [AuthenCodeController::class, 'downloadAuthenCode'])->name('downloadAuthenCode');
        // Authen Code End

        // Receiving Charts Start
            Route::get('report_index_receiving_charts/{id}', [ReceivingChartsController::class, 'index'])->name('report_index_receiving_charts');
            Route::get('dischangeDataFetchAll', [ReceivingChartsController::class, 'dischangeDataFetchAll'])->name('dischangeDataFetchAll');
            Route::get('receivingChartsDataSendFetchAll', [ReceivingChartsController::class, 'receivingChartsDataSendFetchAll'])->name('receivingChartsDataSendFetchAll');
            Route::get('receivingChartsDataReceiveFetchAll', [ReceivingChartsController::class, 'receivingChartsDataReceiveFetchAll'])->name('receivingChartsDataReceiveFetchAll');
            Route::get('fetchAllCountDischange', [ReceivingChartsController::class, 'fetchAllCountDischange'])->name('fetchAllCountDischange');
            Route::get('fetchAllCountReceivingChartsSending', [ReceivingChartsController::class, 'fetchAllCountReceivingChartsSending'])->name('fetchAllCountReceivingChartsSending');
            Route::get('fetchAllCountReceivingChartsReceive', [ReceivingChartsController::class, 'fetchAllCountReceivingChartsReceive'])->name('fetchAllCountReceivingChartsReceive');
            Route::get('fetchAllCountReceivingChartsSendBillingRoom', [ReceivingChartsController::class, 'fetchAllCountReceivingChartsSendBillingRoom'])->name('fetchAllCountReceivingChartsSendBillingRoom');
            Route::get('receivingChartsDataSendBillingRoomFetchAll', [ReceivingChartsController::class, 'receivingChartsDataSendBillingRoomFetchAll'])->name('receivingChartsDataSendBillingRoomFetchAll');
            Route::get('getReceivingChartsDataSendBillingRoomSelectDate', [ReceivingChartsController::class, 'getReceivingChartsDataSendBillingRoomSelectDate'])->name('getReceivingChartsDataSendBillingRoomSelectDate');
            Route::get('getDischangeDataSelectDate', [ReceivingChartsController::class, 'getDischangeDataSelectDate'])->name('getDischangeDataSelectDate');
            Route::get('getReceivingChartsDataSelectDate', [ReceivingChartsController::class, 'getReceivingChartsDataSelectDate'])->name('getReceivingChartsDataSelectDate');
            Route::get('getReceivingChartsDataReceiveSelectDate', [ReceivingChartsController::class, 'getReceivingChartsDataReceiveSelectDate'])->name('getReceivingChartsDataReceiveSelectDate');
            Route::get('searchDataFromAn', [ReceivingChartsController::class, 'searchDataFromAn'])->name('searchDataFromAn');
            Route::post('/report_index_receiving_charts/receivingChartsInsert', [ReceivingChartsController::class, 'receivingChartsInsert'])->name('receivingChartsInsert');
            Route::post('/report_index_receiving_charts/receivingChartsUpdate', [ReceivingChartsController::class, 'receivingChartsUpdate'])->name('receivingChartsUpdate');
            Route::post('/report_index_receiving_charts/receivingChartsUpdateBillingRoom', [ReceivingChartsController::class, 'receivingChartsUpdateBillingRoom'])->name('receivingChartsUpdateBillingRoom');
            Route::get('getBuildingFromReceivingCharts', [ReceivingChartsController::class, 'getBuildingFromReceivingCharts'])->name('getBuildingFromReceivingCharts');
        // Receiving Charts End

        // PCU Start
            Route::get('r_pcu_index/{id}', [RPCUController::class, 'index'])->name('r_pcu_index');

            // Report Z237 Start
                Route::get('report_z237_index/{id}', [ReportZ237Controller::class, 'index'])->name('report_z237_index');
                Route::get('getReportZ237FetchYear', [ReportZ237Controller::class, 'getReportZ237FetchYear'])->name('getReportZ237FetchYear');
                Route::get('getReportZ237FetchAll', [ReportZ237Controller::class, 'getReportZ237FetchAll'])->name('getReportZ237FetchAll');
            // Report Z237 End

            // Report Z242 Start
                Route::get('report_z242_index/{id}', [ReportZ242Controller::class, 'index'])->name('report_z242_index');
                Route::get('getReportZ242FetchYear', [ReportZ242Controller::class, 'getReportZ242FetchYear'])->name('getReportZ242FetchYear');
                Route::get('getReportZ242FetchAll', [ReportZ242Controller::class, 'getReportZ242FetchAll'])->name('getReportZ242FetchAll');
            // Report Z242 End
            
            // Report Z251 Start
                Route::get('report_z251_index/{id}', [ReportZ251Controller::class, 'index'])->name('report_z251_index');
                Route::get('getReportZ251FetchYear', [ReportZ251Controller::class, 'getReportZ251FetchYear'])->name('getReportZ251FetchYear');
                Route::get('getReportZ251FetchAll', [ReportZ251Controller::class, 'getReportZ251FetchAll'])->name('getReportZ251FetchAll');
            // Report Z251 End

            // Report Patients Utilizing ICD10 codes Start
                Route::get('report_patients_utilizing_icd10_codes_index/{id}', [ReportPatientsUtilizingIcd10CodesController::class, 'index'])->name('report_patients_utilizing_icd10_codes_index');
                Route::get('query_icd10', [ReportPatientsUtilizingIcd10CodesController::class, 'query_icd10'])->name('query_icd10');
                Route::get('getReportPatientsUtilizingIcd10CodesFetch', [ReportPatientsUtilizingIcd10CodesController::class, 'getReportPatientsUtilizingIcd10CodesFetch'])->name('getReportPatientsUtilizingIcd10CodesFetch');
            // Report Patients Utilizing ICD10 codes End
            
            // Report CXR 41003 & 41004 Start
                Route::get('report_cxr_41003_41004_index/{id}', [ReportCXR4100341004Controller::class, 'index'])->name('report_cxr_41003_41004_index');
                Route::post('getReportCXR4100341004FetchYear', [ReportCXR4100341004Controller::class, 'getReportCXR4100341004FetchYear'])->name('getReportCXR4100341004FetchYear');
                Route::post('getReportCXR4100341004FetchSelectDate', [ReportCXR4100341004Controller::class, 'getReportCXR4100341004FetchSelectDate'])->name('getReportCXR4100341004FetchSelectDate');
            // Report CXR 41003 & 41004 End
            
            // Report Mixed Building Start
                Route::get('report_mixed_building_index/{id}', [ReportMixedBuildingController::class, 'index'])->name('report_mixed_building_index');
                Route::get('getReportMixedBuildingFetchYear', [ReportMixedBuildingController::class, 'getReportMixedBuildingFetchYear'])->name('getReportMixedBuildingFetchYear');
                Route::get('getReportMixedBuildingFetchSelectDate', [ReportMixedBuildingController::class, 'getReportMixedBuildingFetchSelectDate'])->name('getReportMixedBuildingFetchSelectDate');
            // Report Mixed Building End
            
            // Report Monk & Nun( พระและแม่ชี ) Start
                Route::get('report_monk_nun_index/{id}', [ReportMonkNunController::class, 'index'])->name('report_monk_nun_index');
                Route::get('getReportMonkNunFetchYear', [ReportMonkNunController::class, 'getReportMonkNunFetchYear'])->name('getReportMonkNunFetchYear');
                Route::get('getReportMonkNunFetchSelectDate', [ReportMonkNunController::class, 'getReportMonkNunFetchSelectDate'])->name('getReportMonkNunFetchSelectDate');
            // Report Monk & Nun( พระและแม่ชี ) End
        // PCU End
    // Reportes End

    // IT Start
        // IT Home Start
            Route::get('/it_index', [ItHomeController::class, 'index'])->name('it_index');
        // IT Home End

        // Test All Start
            Route::get('/test_all_index', [TestAllController::class, 'index'])->name('test_all_index');
        // Test All End

        // Repair Notification System Start
            Route::get('/repair_notification_system_index', [RepairNotificationSystemController::class, 'index'])->name('repair_notification_system_index');
            Route::get('/fetchAllDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'fetchAllDataRepairNotificationSystem'])->name('fetchAllDataRepairNotificationSystem');
            Route::post('/insertDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'insertDataRepairNotificationSystem'])->name('insertDataRepairNotificationSystem');
            Route::get('/findOneDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'findOneDataRepairNotificationSystem'])->name('findOneDataRepairNotificationSystem');
            Route::post('/updateDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'updateDataRepairNotificationSystem'])->name('updateDataRepairNotificationSystem');
            Route::delete('/deleteDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'deleteDataRepairNotificationSystem'])->name('deleteDataRepairNotificationSystem');
            Route::get('/detailDataRepairNotificationSystem', [RepairNotificationSystemController::class, 'detailDataRepairNotificationSystem'])->name('detailDataRepairNotificationSystem');
        // Repair Notification System End

        // Working Type Start
            Route::get('/working_type_index', [WorkingTypeController::class, 'index'])->name('working_type_index');
            Route::get('fetchAllDataWorkingType', [WorkingTypeController::class, 'fetchAllDataWorkingType'])->name('fetchAllDataWorkingType');
            Route::post('insertDataWorkingType', [WorkingTypeController::class, 'insertDataWorkingType'])->name('insertDataWorkingType');
            Route::get('findOneDataWorkingType', [WorkingTypeController::class, 'findOneDataWorkingType'])->name('findOneDataWorkingType');
            Route::post('updateDataWorkingType', [WorkingTypeController::class, 'updateDataWorkingType'])->name('updateDataWorkingType');
            Route::delete('deleteDataWorkingType', [WorkingTypeController::class, 'deleteDataWorkingType'])->name('deleteDataWorkingType');
        // Working Type End

        // System Info Start
            Route::get('/system-info-index', [SystemInfoController::class, 'index'])->name('system_info_index');
            Route::get('/showSystemInfo', [SystemInfoController::class, 'showSystemInfo'])->name('showSystemInfo');
        // System Info End

    // IT End

    // Setting Start
        // Module Access Rights Start
            Route::get('mcarc_index', [ModuleAccessRightsController::class, 'index'])->name('mcarc_index');
            Route::get('fetchAllDataType', [ModuleAccessRightsController::class, 'fetchAllDataType'])->name('fetchAllDataType');
            Route::post('insertDataType', [ModuleAccessRightsController::class, 'insertDataType'])->name('insertDataType');
            Route::get('findOneDataType', [ModuleAccessRightsController::class, 'findOneDataType'])->name('findOneDataType');
            Route::post('updateDataType', [ModuleAccessRightsController::class, 'updateDataType'])->name('updateDataType');
            Route::delete('deleteDataType', [ModuleAccessRightsController::class, 'deleteDataType'])->name('deleteDataType');
            Route::get('fetchAllDataTypeAccessibility', [ModuleAccessRightsController::class, 'fetchAllDataTypeAccessibility'])->name('fetchAllDataTypeAccessibility');
            Route::post('insertDataTypeAccessibility', [ModuleAccessRightsController::class, 'insertDataTypeAccessibility'])->name('insertDataTypeAccessibility');
            Route::get('findOneDataTypeAccessibility', [ModuleAccessRightsController::class, 'findOneDataTypeAccessibility'])->name('findOneDataTypeAccessibility');
            Route::post('updateDataTypeAccessibility', [ModuleAccessRightsController::class, 'updateDataTypeAccessibility'])->name('updateDataTypeAccessibility');
            Route::delete('deleteDataTypeAccessibility', [ModuleAccessRightsController::class, 'deleteDataTypeAccessibility'])->name('deleteDataTypeAccessibility');
            Route::get('fetchAllDataStatus', [ModuleAccessRightsController::class, 'fetchAllDataStatus'])->name('fetchAllDataStatus');
            Route::post('insertDataStatus', [ModuleAccessRightsController::class, 'insertDataStatus'])->name('insertDataStatus');
            Route::get('findOneDataStatus', [ModuleAccessRightsController::class, 'findOneDataStatus'])->name('findOneDataStatus');
            Route::post('updateDataStatus', [ModuleAccessRightsController::class, 'updateDataStatus'])->name('updateDataStatus');
            Route::delete('deleteDataStatus', [ModuleAccessRightsController::class, 'deleteDataStatus'])->name('deleteDataStatus');
            Route::get('fetchAllDataModule', [ModuleAccessRightsController::class, 'fetchAllDataModule'])->name('fetchAllDataModule');
            Route::post('insertDataModule', [ModuleAccessRightsController::class, 'insertDataModule'])->name('insertDataModule');
            Route::get('findOneDataModule', [ModuleAccessRightsController::class, 'findOneDataModule'])->name('findOneDataModule');
            Route::post('updateDataModule', [ModuleAccessRightsController::class, 'updateDataModule'])->name('updateDataModule');
            Route::delete('deleteDataModule', [ModuleAccessRightsController::class, 'deleteDataModule'])->name('deleteDataModule');
            Route::post('ChangeStatusIdInModuleRealtime', [ModuleAccessRightsController::class, 'ChangeStatusIdInModuleRealtime'])->name('ChangeStatusIdInModuleRealtime');
            Route::get('findSelectForUserOrGroup', [ModuleAccessRightsController::class, 'findSelectForUserOrGroup'])->name('findSelectForUserOrGroup');
            Route::get('fetchAllDataAccessibility', [ModuleAccessRightsController::class, 'fetchAllDataAccessibility'])->name('fetchAllDataAccessibility');
            Route::post('insertDataAccessibility', [ModuleAccessRightsController::class, 'insertDataAccessibility'])->name('insertDataAccessibility');
            Route::get('findOneDataAccessibility', [ModuleAccessRightsController::class, 'findOneDataAccessibility'])->name('findOneDataAccessibility');
            Route::get('findSelectForModule', [ModuleAccessRightsController::class, 'findSelectForModule'])->name('findSelectForModule');
            Route::get('findSelectForSidebarSub1Menu', [ModuleAccessRightsController::class, 'findSelectForSidebarSub1Menu'])->name('findSelectForSidebarSub1Menu');
            Route::post('updateDataAccessibility', [ModuleAccessRightsController::class, 'updateDataAccessibility'])->name('updateDataAccessibility');
            Route::post('ChangeStatusIdInAccessibilityRealtime', [ModuleAccessRightsController::class, 'ChangeStatusIdInAccessibilityRealtime'])->name('ChangeStatusIdInAccessibilityRealtime');
            Route::delete('deleteDataAccessibility', [ModuleAccessRightsController::class, 'deleteDataAccessibility'])->name('deleteDataAccessibility');
        // Module Access Rights End

        // Sidebar Main Menu Start
            Route::get('sm_index', [SidebarMenuController::class, 'index'])->name('sm_index');
            Route::get('fetchAllDataSidebarMainMenu', [SidebarMenuController::class, 'fetchAllDataSidebarMainMenu'])->name('fetchAllDataSidebarMainMenu');
            Route::post('insertDataSidebarMainMenu', [SidebarMenuController::class, 'insertDataSidebarMainMenu'])->name('insertDataSidebarMainMenu');
            Route::get('findOneDataSidebarMainMenu', [SidebarMenuController::class, 'findOneDataSidebarMainMenu'])->name('findOneDataSidebarMainMenu');
            Route::post('updateDataSidebarMainMenu', [SidebarMenuController::class, 'updateDataSidebarMainMenu'])->name('updateDataSidebarMainMenu');
            Route::delete('deleteDataSidebarMainMenu', [SidebarMenuController::class, 'deleteDataSidebarMainMenu'])->name('deleteDataSidebarMainMenu');
            Route::post('ChangeStatusIdInSidebarMainMenuRealtime', [SidebarMenuController::class, 'ChangeStatusIdInSidebarMainMenuRealtime'])->name('ChangeStatusIdInSidebarMainMenuRealtime');
        // Sidebar Main Menu End

        // Sidebar Sub1 Menu Start
            Route::get('sm_index', [SidebarMenuController::class, 'index'])->name('sm_index');
            Route::get('fetchAllDataSidebarSub1Menu', [SidebarMenuController::class, 'fetchAllDataSidebarSub1Menu'])->name('fetchAllDataSidebarSub1Menu');
            Route::post('insertDataSidebarSub1Menu', [SidebarMenuController::class, 'insertDataSidebarSub1Menu'])->name('insertDataSidebarSub1Menu');
            Route::get('findOneDataSidebarSub1Menu', [SidebarMenuController::class, 'findOneDataSidebarSub1Menu'])->name('findOneDataSidebarSub1Menu');
            Route::post('updateDataSidebarSub1Menu', [SidebarMenuController::class, 'updateDataSidebarSub1Menu'])->name('updateDataSidebarSub1Menu');
            Route::delete('deleteDataSidebarSub1Menu', [SidebarMenuController::class, 'deleteDataSidebarSub1Menu'])->name('deleteDataSidebarSub1Menu');
            Route::post('ChangeStatusIdInSidebarSub1MenuRealtime', [SidebarMenuController::class, 'ChangeStatusIdInSidebarSub1MenuRealtime'])->name('ChangeStatusIdInSidebarSub1MenuRealtime');
        // Sidebar Sub1 Menu End

        // Announcement And Version Start
            Route::get('announcement_and_version_index', [AnnouncementAndVersionController::class, 'index'])->name('announcement_and_version_index');
            Route::get('fetchAllDataVersion', [AnnouncementAndVersionController::class, 'fetchAllDataVersion'])->name('fetchAllDataVersion');
            Route::post('insertDataVersion', [AnnouncementAndVersionController::class, 'insertDataVersion'])->name('insertDataVersion');
            Route::get('findOneDataVersion', [AnnouncementAndVersionController::class, 'findOneDataVersion'])->name('findOneDataVersion');
            Route::post('updateDataVersion', [AnnouncementAndVersionController::class, 'updateDataVersion'])->name('updateDataVersion');
            Route::delete('deleteDataVersion', [AnnouncementAndVersionController::class, 'deleteDataVersion'])->name('deleteDataVersion');
            Route::get('fetchAllDataVersionDetail', [AnnouncementAndVersionController::class, 'fetchAllDataVersionDetail'])->name('fetchAllDataVersionDetail');
            Route::post('insertDataVersionDetail', [AnnouncementAndVersionController::class, 'insertDataVersionDetail'])->name('insertDataVersionDetail');
            Route::get('findOneDataVersionDetail', [AnnouncementAndVersionController::class, 'findOneDataVersionDetail'])->name('findOneDataVersionDetail');
            Route::post('updateDataVersionDetail', [AnnouncementAndVersionController::class, 'updateDataVersionDetail'])->name('updateDataVersionDetail');
            Route::delete('deleteDataVersionDetail', [AnnouncementAndVersionController::class, 'deleteDataVersionDetail'])->name('deleteDataVersionDetail');
            Route::get('fetchAllDataFiscalYear', [AnnouncementAndVersionController::class, 'fetchAllDataFiscalYear'])->name('fetchAllDataFiscalYear');
            Route::post('insertDataFiscalYear', [AnnouncementAndVersionController::class, 'insertDataFiscalYear'])->name('insertDataFiscalYear');
            Route::get('findOneDataFiscalYear', [AnnouncementAndVersionController::class, 'findOneDataFiscalYear'])->name('findOneDataFiscalYear');
            Route::post('updateDataFiscalYear', [AnnouncementAndVersionController::class, 'updateDataFiscalYear'])->name('updateDataFiscalYear');
            Route::delete('deleteDataFiscalYear', [AnnouncementAndVersionController::class, 'deleteDataFiscalYear'])->name('deleteDataFiscalYear');
        // Announcement And Version End
    // Setting End
});

