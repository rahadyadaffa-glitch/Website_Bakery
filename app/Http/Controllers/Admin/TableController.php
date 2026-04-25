<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        return view('admin.tables.index');
    }

    public function generateQr(Request $request)
    {
        $request->validate(['table_number' => 'required|string|max:10']);
        $tableNumber = $request->table_number;
        $url = url('/?table=' . urlencode($tableNumber));
        
        $qr = QrCode::size(300)->generate($url);
        
        return view('admin.tables.show', compact('qr', 'tableNumber', 'url'));
    }
}
