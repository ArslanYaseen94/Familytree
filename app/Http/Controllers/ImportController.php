<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Member;
use App\Models\FamilyTree;
use App\Exports\MembersExport;
use App\Exports\MembersImport;
use App\Imports\MembersImport as ImportsMembersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function index()
    {
        return view("user-view.import.index");
    }

    public function export()
    {
        $userId = Auth::guard('web')->id();
        $families = FamilyTree::where('ownerId', $userId)
            ->where('Status', '!=', 2)
            ->orderBy('id', 'desc')
            ->get(['id', 'familyid']);

        return view("user-view.import.export", compact('families'));
    }
    public function exportMembers(Request $request)
    {
        $userId = Auth::guard('web')->id();
        $ownedFamilyIds = FamilyTree::where('ownerId', $userId)
            ->where('Status', '!=', 2)
            ->pluck('id')
            ->toArray();

        // Scope: one family or all families
        $request->validate([
            'export_scope' => 'required|in:one,all',
            'family_tree_id' => 'nullable|integer',
        ]);

        $query = Member::query()->whereIn('family_id', $ownedFamilyIds);

        if ($request->export_scope === 'one') {
            $request->validate([
                'family_tree_id' => 'required|integer',
            ]);

            $familyId = (int) $request->family_tree_id;
            if (!in_array($familyId, $ownedFamilyIds, true)) {
                return response()->json(['message' => __('messages.Unauthorized')], 403);
            }
            $query->where('family_id', $familyId);
        }

        $filterType = $request->input('filter_type');

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
        } elseif ($filterType === 'all') {
            // no extra filters
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
