<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('landing.index', compact('faqs'));
    }
}
