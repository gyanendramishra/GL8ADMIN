<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Enquiry;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $userQuery = User::query();
        $enquiryQuery = Enquiry::query();
        return Inertia::render('Dashboard/Index', [
            'totalUsersCount' => $userQuery->count(),
            'activeUsersCount' => $userQuery->isActive()->count(),
            'newEnquiriesCount' => $enquiryQuery->ofIsRead(Enquiry::UN_READ)->count(),
            'userStatistics' => $this->userStatistics(),
            'enquiryStatistics' => $this->enquiryStatistics()
        ]);
    }

    /**
     * Get the user current year stats by month.
     * @param Request $request
     * @return Response
     */
    public function userStatistics()
    {
        $statistics = User::select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('count(*) as total'))
            ->whereYear('created_at', Carbon::now())
            ->groupBy('month')
            ->orderBy('created_at')
            ->pluck('total', 'month')
            ->all();
        return [
            'labels' => array_keys($statistics),
            'datasets' => [
                [
                    'backgroundColor' => 'rgba(99,179,237,0.4)',
                    'strokeColor' => '#63b3ed',
                    'pointColor' => '#fff',
                    'pointStrokeColor' => '#63b3ed',
                    'data' => array_values($statistics)
                ]
            ]
        ];
    }

    /**
     * Get the enquiry current year stats by month.
     * @param Request $request
     * @return Response
     */
    public function enquiryStatistics()
    {
        $statistics = Enquiry::select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('count(*) as total'))
            ->whereYear('created_at', Carbon::now())
            ->groupBy('month')
            ->orderBy('created_at')
            ->pluck('total', 'month')
            ->all();
        return [
            'labels' => array_keys($statistics),
            'datasets' => [
                [
                    'backgroundColor' => [
                        'rgba(99,179,237,0.4)',
                        'rgba(22, 101, 52, 0.4)',
                        'rgba(59, 130, 246, 0.4)',
                        'rgba(252, 165, 165, 0.4)',
                        'rgba(251, 146, 60, 0.4)',
                        'rgba(249, 168, 212, 0.4)'
                    ],
                    'borderColor' => [
                        'rgba(99,179,237)',
                        'rgba(22, 101, 52)',
                        'rgba(59, 130, 246)',
                        'rgba(252, 165, 165)',
                        'rgba(251, 146, 60)',
                        'rgba(249, 168, 212)'
                    ],
                    'borderWidth' => 1,
                    'strokeColor' => '#63b3ed',
                    'pointColor' => '#fff',
                    'pointStrokeColor' => '#63b3ed',
                    'data' => array_values($statistics)
                ]
            ]
        ];
    }
}
