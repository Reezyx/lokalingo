<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\Question;
use App\Models\QuestionExample;
use App\Models\Traffic;
use App\Models\User;
use App\Repositories\RepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements RepositoryInterface
{
  public function getDatatable($request)
  {
    $mainQuery = DB::table('users')->select(
      'users.id',
      'users.full_name',
      'users.username',
      'users.email',
      'users.asal',
      'users.exp',
    );

    return DataTables::of($mainQuery)
      ->addIndexColumn()
      ->orderColumn('full_name', 'full_name $1')
      ->orderColumn('username', 'username $1')
      ->orderColumn('email', 'email $1')
      ->orderColumn('asal', 'asal $1')
      ->orderColumn('exp', 'exp $1')
      ->editColumn('action', function ($model) {
        $response = '<a class="btn" href="#"><i class="fa fa-eye"></i>
                </a>';
        return $response;
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
  }

  public function getDataDashboard()
  {
    $weekStart = Carbon::now()->startOfWeek();
    $weekEnd = Carbon::now()->endOfWeek();
    $user = User::whereBetween('created_at', [$weekStart, $weekEnd])->count();

    $lastWeekStart = date("Y-m-d", strtotime("last sunday midnight", strtotime("-1 week +1 day")));
    $lastWeekEnd = date("Y-m-d", strtotime("next saturday", strtotime("last sunday midnight", strtotime("-1 week +1 day"))));
    $lastUser = User::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

    $percentage = (float) (($user - $lastUser) / $lastUser) * 100;

    $monthStart = Carbon::now()->startOfMonth();
    $monthEnd = Carbon::now()->endOfMonth();
    $traffic = Traffic::whereBetween('created_at', [$monthStart, $monthEnd])->count();

    $lastTraffic = Traffic::whereMonth('created_at', Carbon::now()->subMonth()->month())->count();

    if ($lastTraffic == 0) {
      $percentTraffic = (float) (($traffic) / 1) * 100;
    } else {
      $percentTraffic = (float) (($traffic - $lastTraffic) / $lastTraffic) * 100;
    }

    $response = [
      "user_current" => $user,
      "user_past" => $lastUser,
      "percentage" => $percentage,
      "traffic_current" => $traffic,
      "traffic_past" => $lastTraffic,
      "percent_traffic" => $percentTraffic,
    ];

    return $response;
  }
}
