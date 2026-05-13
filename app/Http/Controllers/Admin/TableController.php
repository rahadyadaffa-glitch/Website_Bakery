<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $tables = \App\Models\Table::orderBy('id', 'asc')->get();
        return view('admin.tables.index', compact('tables'));
    }


    public function showQr(\App\Models\Table $table)
    {
        $tableNumber = $table->number;
        $url = url('/?table=' . urlencode($tableNumber));
        $qr = QrCode::size(300)->generate($url);
        
        return view('admin.tables.show', compact('qr', 'tableNumber', 'url'));
    }

    public function generateQr(Request $request)
    {
        $request->validate(['table_number' => 'required|string|max:10']);
        $tableNumber = $request->table_number;

        // Create table if it doesn't exist
        \App\Models\Table::firstOrCreate(
            ['number' => $tableNumber],
            ['status' => 'available']
        );

        $url = url('/?table=' . urlencode($tableNumber));
        
        $qr = QrCode::size(300)->generate($url);
        
        return view('admin.tables.show', compact('qr', 'tableNumber', 'url'));
    }
}
