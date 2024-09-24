<?php

namespace App\Http\Controllers;

use App\Models\XMLBook;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class XMLBooksController extends Controller
{
    public function index(Request $request)
    {
        $data = XMLBook::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.xml_books.xml_books_index');
    }
}
