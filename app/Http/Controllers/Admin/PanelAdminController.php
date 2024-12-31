<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelAdminController extends Controller
{
    public function index()
    {
        // Mostrar el panel de administración
        return view('admin.panel'); // Asegúrate de que esta vista exista
    }
}
