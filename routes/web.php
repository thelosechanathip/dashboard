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
use App\Http\Controllers\Reportes\AuthenCodeController;

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

    // Pages Start
        // Ovst Start
        Route::get('indexOvst', [OvstController::class, 'index'])->name('indexOvst');
        Route::get('showOvst', [OvstController::class, 'showOvst'])->name('showOvst');
        Route::get('getOvstData', [OvstController::class, 'getOvstData'])->name('getOvstData');
        Route::get('getOvstDailyData', [OvstController::class, 'getOvstDailyData'])->name('getOvstDailyData');
        Route::get('getOvstSelectData', [OvstController::class, 'getOvstSelectData'])->name('getOvstSelectData');
        // Ovst End

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
        // Ipt End

        // Palliative Care Start
            Route::get('palliative_care', [PalliativeCareController::class, 'index'])->name('palliative_care');
            Route::get('getPalliativeCareSelectData', [PalliativeCareController::class, 'getPalliativeCareSelectData'])->name('getPalliativeCareSelectData');
            Route::get('getPalliativeCareFetchListName', [PalliativeCareController::class, 'getPalliativeCareFetchListName'])->name('getPalliativeCareFetchListName');
            Route::get('getHomeVisitingInformation', [PalliativeCareController::class, 'getHomeVisitingInformation'])->name('getHomeVisitingInformation');
            Route::get('getHomeVisitingInformationZ718', [PalliativeCareController::class, 'getHomeVisitingInformationZ718'])->name('getHomeVisitingInformationZ718');
            Route::get('getEclaimReceivedMoney', [PalliativeCareController::class, 'getEclaimReceivedMoney'])->name('getEclaimReceivedMoney');
            Route::get('getNumberOfNewPatients', [PalliativeCareController::class, 'getNumberOfNewPatients'])->name('getNumberOfNewPatients');
            Route::get('getNumberOfNewPatientsSelect', [PalliativeCareController::class, 'getNumberOfNewPatientsSelect'])->name('getNumberOfNewPatientsSelect');
            Route::get('getNumberOfOldPatients', [PalliativeCareController::class, 'getNumberOfOldPatients'])->name('getNumberOfOldPatients');
            Route::get('getNumberOfOldPatientsSelect', [PalliativeCareController::class, 'getNumberOfOldPatientsSelect'])->name('getNumberOfOldPatientsSelect');
            Route::get('getPalliativeCarePatientsPain', [PalliativeCareController::class, 'getPalliativeCarePatientsPain'])->name('getPalliativeCarePatientsPain');
            Route::get('getPalliativeCarePatientsPainSelect', [PalliativeCareController::class, 'getPalliativeCarePatientsPainSelect'])->name('getPalliativeCarePatientsPainSelect');
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
});

