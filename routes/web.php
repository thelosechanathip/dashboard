<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pages\OvstController;
use App\Http\Controllers\Pages\ErRegistController;
use App\Http\Controllers\Pages\ReferOutController;
use App\Http\Controllers\Pages\ReferInController;
use App\Http\Controllers\Pages\IptController;
use App\Http\Controllers\Pages\PalliativeCareController;
use App\Http\Controllers\Pages\OpdScreenController;
use App\Http\Controllers\Pages\WardController;
use App\Http\Controllers\Reportes\AuthenCodeController;
use App\Http\Controllers\Setting\ModuleAccessRightsController;
use App\Http\Controllers\Setting\SidebarMenuController;

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
        // Ipt End

        // Ward Start
            Route::get('/ward/{wardId}', [WardController::class, 'show'])->name('ward.details');
            Route::get('getIptWardData', [WardController::class, 'getIptWardData'])->name('getIptWardData');
            Route::get('getIptWardDailyData', [WardController::class, 'getIptWardDailyData'])->name('getIptWardDailyData');
            Route::get('getIptWardSelectData', [WardController::class, 'getIptWardSelectData'])->name('getIptWardSelectData');
        // Ward End

        // Palliative Care Start
            Route::get('palliative_care', [PalliativeCareController::class, 'index'])->name('palliative_care');
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
        // Palliative Care End
    // Pages End

    // Reportes Start
        // Authen Code Start
            Route::get('report_index_authen_code', [AuthenCodeController::class, 'index'])->name('report_index_authen_code');
            Route::get('getAuthenCodeCount', [AuthenCodeController::class, 'getAuthenCodeCount'])->name('getAuthenCodeCount');
            Route::get('authenCodeFetchAll', [AuthenCodeController::class, 'authenCodeFetchAll'])->name('authenCodeFetchAll');
            Route::get('exportNotAuthenCode', [AuthenCodeController::class, 'exportNotAuthenCode'])->name('exportNotAuthenCode');
            Route::get('downloadAuthenCode', [AuthenCodeController::class, 'downloadAuthenCode'])->name('downloadAuthenCode');
        // Authen Code End
    // Reportes End

    // Setting Start
        // Module Access Rights Start
            Route::get('mcarc_index', [ModuleAccessRightsController::class, 'index'])->name('mcarc_index');
            Route::get('fetchAllDataType', [ModuleAccessRightsController::class, 'fetchAllDataType'])->name('fetchAllDataType');
            Route::post('insertDataType', [ModuleAccessRightsController::class, 'insertDataType'])->name('insertDataType');
            Route::get('findOneDataType', [ModuleAccessRightsController::class, 'findOneDataType'])->name('findOneDataType');
            Route::post('updateDataType', [ModuleAccessRightsController::class, 'updateDataType'])->name('updateDataType');
            Route::delete('deleteDataType', [ModuleAccessRightsController::class, 'deleteDataType'])->name('deleteDataType');
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
        // Sidebar Main Menu End


        // Sidebar Sub1 Menu Start
            Route::get('sm_index', [SidebarMenuController::class, 'index'])->name('sm_index');
            Route::get('fetchAllDataSidebarSub1Menu', [SidebarMenuController::class, 'fetchAllDataSidebarSub1Menu'])->name('fetchAllDataSidebarSub1Menu');
            Route::post('insertDataSidebarSub1Menu', [SidebarMenuController::class, 'insertDataSidebarSub1Menu'])->name('insertDataSidebarSub1Menu');
            Route::get('findOneDataSidebarSub1Menu', [SidebarMenuController::class, 'findOneDataSidebarSub1Menu'])->name('findOneDataSidebarSub1Menu');
            Route::post('updateDataSidebarSub1Menu', [SidebarMenuController::class, 'updateDataSidebarSub1Menu'])->name('updateDataSidebarSub1Menu');
            Route::delete('deleteDataSidebarSub1Menu', [SidebarMenuController::class, 'deleteDataSidebarSub1Menu'])->name('deleteDataSidebarSub1Menu');
        // Sidebar Sub1 Menu End
    // Setting End
});

