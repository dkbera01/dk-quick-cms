<?php
namespace DK\QuickCms\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('quick-cms::admin.dashboard');

    }
}
