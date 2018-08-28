<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminMediasController extends Controller
{
    public function __construct()
    {
        $this->middleware('custom.auth');
    }
    public function index()
    {
        return view('admin.medias.index');
    }
    public function errorRedirect()
    {
        return view('admin.medias.error-redirect');
    }
}