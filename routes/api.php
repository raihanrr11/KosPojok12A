<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// WhatsApp Redirect Route
Route::get('/whatsapp/redirect/{type}', function ($type) {
    $whatsapp = \App\Models\Setting::get('dorm_whatsapp', '6282250372130');
    if (empty($whatsapp)) {
        $whatsapp = '6282250372130';
    }

    $whatsappClean = preg_replace('/[^0-9]/', '', $whatsapp);
    if (strpos($whatsappClean, '0') === 0) {
        $whatsappClean = '62' . substr($whatsappClean, 1);
    }

    if ($type === 'register') {
        $message = "Halo Admin Kos Pojok 12A 😊 Saya ingin berdiskusi terkait hunian di sana. Berikut perkenalan singkat saya:\n\n" .
            "Nama    : [Nama Lengkap]\n" .
            "Asal    : [Kota/Daerah Asal]\n" .
            "Perihal : [Topik yang ingin didiskusikan]\n\n" .
            "Terimakasih 🙏";
    } elseif ($type === 'emergency') {
        $message = "[DARURAT] Halo Admin Kos Pojok 12A\n\n" .
            "Saya sedang mengalami kendala darurat yang memerlukan tindakan cepat. Berikut informasi saya:\n\n" .
            "Nama    : [Nama Lengkap]\n" .
            "Kamar   : [Nomor Kamar]\n" .
            "Kendala : [Jelaskan kendala secara singkat]\n\n" .
            "Mohon segera dihubungi. Terima kasih🙏";
    } else {
        $message = "Halo Admin Kos Pojok 12A.";
    }

    return redirect("https://wa.me/{$whatsappClean}?text=" . urlencode($message));
})->name('whatsapp.redirect');
