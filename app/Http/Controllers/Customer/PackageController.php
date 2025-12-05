<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of available packages.
     */
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        
        return view('customer.packages.index', [
            'packages' => $packages,
        ]);
    }

    /**
     * Show the form for purchasing a package.
     */
    public function show(Package $package)
    {
        if (!$package->is_active) {
            abort(404);
        }

        return view('customer.packages.show', [
            'package' => $package,
        ]);
    }
}
