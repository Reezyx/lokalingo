<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Repositories\UserRepository;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository;
use Stevebauman\Location\Facades\Location;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $userRepo = new UserRepository();
        $data = $userRepo->getDataDashboard();
        $arr = explode('(', $request->userAgent());
        $agent = explode(";", $arr[1]);
        $area = Location::get();
        $limiter = app(RateLimiter::class);
        $totalRequest = $limiter->hit(
            $request->ip(),
            30 * 60
        );
        if ($totalRequest <= 1) {
            $device = new Device();
            $device->device = $agent[0];
            $device->area = $area->regionName;
            $device->save();
        }
        $users = Device::all();
        return view('dashboard')->with('data', $data)->with('users', $users);
    }

    public function getLanguage()
    {
        return view('pages.language.index');
    }

    public function getQuestion()
    {
        return view('pages.question.index');
    }

    public function getUser()
    {
        return view('pages.user.index');
    }

    public function getDatatableUser(Request $request)
    {
        if ($request->ajax()) {
            $tenantRepo = new UserRepository();
            return $tenantRepo->getDatatable($request);
        }
        abort(404);
    }
}
