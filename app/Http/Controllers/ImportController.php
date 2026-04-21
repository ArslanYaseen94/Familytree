<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Member;
use App\Exports\MembersExport;
use App\Exports\MembersImport;
use App\Imports\MembersImport as ImportsMembersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view("user-view.import.index");
    }

    public function export()
    {

        return view("user-view.import.export");
    }
    public function exportMembers(Request $request)
    {
        $filterType = $request->input('filter_type');
        $query = Member::query();

        if ($filterType === 'id') {
            $request->validate([
                'from_id' => 'required|integer',
                'to_id' => 'required|integer',
            ]);
            $query->whereBetween('id', [$request->from_id, $request->to_id]);
        } elseif ($filterType === 'date') {
            $request->validate([
                'from_date' => 'required|date',
                'to_date' => 'required|date',
            ]);
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $members = $query->get();

        $filename = 'members_export_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new MembersExport($members), $filename);
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ImportsMembersImport, $request->file('excel_file'));

        return back()
         ->with(__('messages.success'), __('messages.Members imported successfully.'));
    }
}
