<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function requireAgency(Request $request): void
    {
        // 1 = agency, 2 = admin
        if ((int) $request->user()->permission < 1) {
            abort(403, 'Forbidden');
        }
    }

    protected function requireAdmin(Request $request): void
    {
        if ((int) $request->user()->permission < 2) {
            abort(403, 'Forbidden');
        }
    }
}
