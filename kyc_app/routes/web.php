<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\UploadFileController;
use App\Models\Files;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [AuthManager::class, 'login'])->name('login');
Route::post('/', [AuthManager::class, 'loginPost'])->name('login.post');

Route::get('/register', [AuthManager::class, 'registration'])->name('registration');
Route::post('/register', [AuthManager::class, 'registrationPost'])->name('registration.post');

Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('welcome');
    })->name('home');

    Route::get('/kyc/upload', function () {
        return view('upload');
    })->name('kyc-upload');

    Route::post('/kyc/upload', [UploadFileController::class, 'store'])->name('kyc.post');

    Route::get('/kyc/list', function () {
        $user = \Auth::user();
        $getAll = Files::where('user_id', $user->id)
            ->orderBy('updated_at')
            ->get();

        return view('list')->with("data", $getAll);
    })->name('doc-list');

    Route::get('/status/check/{block_uuid}', function (string $block_uuid) {
        $user = \Auth::user();

        $getAll = Files::where('block_uuid', $block_uuid)
            ->orderBy('updated_at')->first();
        if (($getAll->status == "completed") || ($getAll->status == "minting") || ($getAll->status == "minted")) {
            // Do nothing
        } else {
            $getData = Http::get(env('XRPL_API_HOST') . "kyc/status/" . $block_uuid);
            if ($getData->json()["status"] == "completed") {
                $getAll->status = "completed";
                $getAll->id_data = json_encode($getData->json());
                $getAll->save();
            }
        }
        return view('data')->with("data", $getAll);
    })->name('data-page');

    Route::get('/nft/mint/{block_uuid}', function (string $block_uuid) {
        $user = \Auth::user();

        $getAll = Files::where('block_uuid', $block_uuid)
            ->orderBy('updated_at')->first();

        if (($getAll->status == "completed") || ($getAll->status == "minting") || ($getAll->status == "minted")) {

            $idData = json_decode($getAll->id_data);
            $getDocFrontUUID = $idData->user_upload_data->doc_front->uuid;
            if ($getAll->status == "completed" || ($getAll->status == "minting") || ($getAll->status == "minted")) {
                // HardCoded for Prototype
                $mintFront = [
                    "application" => [
                        "app_encryption_key" => env("TEMP_APPLICATION_KEY"),
                    ],
                    "client" => [
                        "client_encryption_key" => env("TEMP_CLIENT_KEY"),
                        "client_wallet_seed" => env("TEMP_WALLTET_SEED"),
                        "client_wallet_seq" => env("TEMP_WALLET_SEQ"),
                    ],
                    "document_uuid" => "",
                ];

                // Mint Doc Front
                $mintFront["document_uuid"] = $getDocFrontUUID;
                $request = Http::withHeaders(
                    [
                        'Accept' => 'application/json',
                    ]
                );

                if (($getAll->status == "minting") || ($getAll->status == "minted")) {
                    if (($getAll->status == "minting")) {
                        $getData = Http::get(env('XRPL_API_HOST') . "block/status/" . $getDocFrontUUID);
                        $mintData = $getData->json();
                        if ($mintData["status"] == "compleated") {
                            $getAll->status = "minted";
                        }
                        $getAll->block_data = json_encode($getData->json());
                        $getAll->save();
                    }
                } else {
                    $request->withBody(json_encode($mintFront), 'application/json')->post(env("XRPL_API_HOST") . "block/create");
                    $getAll->status = "minting";
                    $getAll->save();
                }
            }

            return view('data')->with("data", $getAll);
        } else {
            return redirect('/status/check/' . $block_uuid)->with("data", $getAll)->with("error", "Minting not possible, Document is not verified.");
        }

    })->name('data-page');
});
