<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Spatie\Browsershot\Browsershot;

class ContractController extends Controller
{

    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }
    public function showUploadForm()
    {
        $contracts = Contract::all();
        return view('contracts.upload', compact('contracts'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'string',
            'contract' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $file = $request->file('contract');
        $path = $file->store('contracts');

        $contract = new Contract();
        $contract->name = $request->input('name');
        $contract->email = $request->input('email');
        $contract->description = $request->input('description');
        $contract->file_path = $path;
        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Contract uploaded successfully.');
    }

    public function exportPdf($id)
    {
        $contract = Contract::findOrFail($id);
        $data = [
            'name' => $contract->name,
            'email' => $contract->email,
            'description' => $contract->description,
        ];

        $html = view('pdf.pdf', $data)->render();
        $pdf = Browsershot::html($html)->pdf();

        return response()->streamDownload(
            fn () => print($pdf),
            'contract_' . $contract->id . '.pdf'
        );
    }
}
