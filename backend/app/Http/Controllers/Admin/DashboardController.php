<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctors;
use App\Models\News;
use App\Models\Videos;
use App\Models\Promotions;

class DashboardController extends Controller
{
    //
    public function index(){
        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => User::count(),
                'total_doctors' => Doctors::count(),
                'total_news' => News::count(),
                'total_videos' => Videos::count(),
                'total_promotions' => Promotions::count(),
            ]
        ]);
    }
}
