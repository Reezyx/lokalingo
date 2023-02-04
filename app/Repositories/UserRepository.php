<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\Question;
use App\Models\QuestionExample;
use App\Models\Traffic;
use App\Models\User;
use App\Models\UserCriteria;
use App\Models\UserScore;
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
    $user = User::whereMonth('created_at', Carbon::now()->month)->count();

    // $lastWeekStart = date("Y-m-d", strtotime("last sunday midnight", strtotime("-1 week +1 day")));
    // $lastWeekEnd = date("Y-m-d", strtotime("next saturday", strtotime("last sunday midnight", strtotime("-1 week +1 day"))));
    $lastUser = User::whereMonth('created_at', Carbon::now()->subMonth()->month())->count();

    if ($lastUser == 0) {
      $percentage = (float) (($user) / 1) * 100;
    } else {
      $percentage = (float) (($user - $lastUser) / $lastUser) * 100;
    }

    $monthStart = Carbon::now()->startOfMonth();
    $monthEnd = Carbon::now()->endOfMonth();
    $traffic = Traffic::whereBetween('created_at', [$monthStart, $monthEnd])->count();

    $lastTraffic = Traffic::whereMonth('created_at', Carbon::now()->subMonth()->month())->count();

    if ($lastTraffic == 0) {
      $percentTraffic = (float) (($traffic) / 1) * 100;
    } else {
      $percentTraffic = (float) (($traffic - $lastTraffic) / $lastTraffic) * 100;
    }

    $newUsers = User::select(DB::raw("(COUNT(*)) as count"), DB::raw("(DATE_FORMAT(created_at, '%M-%Y')) as month"))->orderBy('created_at', 'asc')->groupBy('month')->limit(6)->get()->toArray();

    $count = [];
    $month = [];
    foreach ($newUsers as $newUser) {
      array_push($count, $newUser['count']);
      array_push($month, Carbon::parse($newUser['month'])->format('M Y'));
    }

    $userCount = implode(",", $count);
    $userMonth = implode(", ", $month);

    $activity = UserScore::whereMonth('created_at', Carbon::now()->month)->count();
    $lastActivity = UserScore::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

    if ($lastActivity == 0) {
      $percentActivity = (float) (($activity) / 1) * 100;
    } else {
      $percentActivity = (float) (($activity - $lastActivity) / $lastActivity) * 100;
    }

    $download = UserCriteria::whereMonth('created_at', Carbon::now()->month)->first();
    $lastDownload = UserCriteria::whereMonth('created_at', Carbon::now()->subMonth()->month)->first();

    if ($lastDownload && $download) {
      if ($lastDownload->count == 0) {
        $percentDownload = (float) (($download->count) / 1) * 100;
      } else {
        $percentDownload = (float) (($download->count - $lastDownload->count) / $lastDownload->count) * 100;
      }
    }  else if($download && !$lastDownload){
      $percentDownload = (float) ($download->count / 1) * 100;
    } else if (!$download && $lastDownload) {
      $percentDownload = (float) (0 / 1) * 100;
    } else {
      $percentDownload = (float) ($download->count / 1) * 100;
    }


    $response = [
      "user_current" => $user,
      "user_past" => $lastUser,
      "percentage" => ceil($percentage),
      "traffic_current" => $traffic,
      "traffic_past" => $lastTraffic,
      "percent_traffic" => ceil($percentTraffic),
      "user_count" => $userCount,
      "user_month" => $userMonth,
      "user_activity" => $activity,
      "activity_percent" => ceil($percentActivity),
      "download" => $download->count,
      "percent_download" => ceil($percentDownload),
    ];

    return $response;
  }
}
