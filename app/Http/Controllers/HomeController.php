<?php

namespace App\Http\Controllers;

use App\Models\UserCriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function downloadApps()
    {
        try {
            $file = storage_path('app/public') . '/application/app-armeabi-v7a-release.apk';
            $recentCriteria = UserCriteria::whereMonth('updated_at', Carbon::now()->month)->first();
            if ($recentCriteria) {
                $recentCriteria->count += 1;
                $recentCriteria->save();
            } else {
                $criteria = new UserCriteria();
                $criteria->name = 'download';
                $criteria->count = 1;
                $criteria->save();
            }
            return response()->download($file, 'lokalingo.apk', [
                'Content-Type' => 'application/vnd.android.package-archive',
                'Content-Disposition' => 'attachment; filename="android.apk"',
            ]);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json([
                'code' => '500',
                'info' => $e->getMessage(),
            ]);
        }
    }
}
