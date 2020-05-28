<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Odb;
use Illuminate\Http\Request;

class OdbsController extends Controller
{
    public function index(Request $request)
    {
        $odbs = Odb::query();

        if ($request->red) {
            $odbs->orWhere('status', 'like', '%Red%');
        }

        if ($request->yellow) {
            $odbs->orWhere('status', 'like', '%Yellow%');
        }

        if ($request->green) {
            $odbs->orWhere('status', 'like', '%Green%');
        }

        if ($request->black) {
            $odbs->orWhere('status', 'like', '%Black%');
        }

        $odbs = $odbs->get();
        return response()->json([
            'took' => round(microtime(true) - LARAVEL_START, 2),
            'status' => 'Success',
            'total' => count($odbs),
            'data' => $odbs,
        ]);
    }
}
