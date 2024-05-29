<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;

class KpiController extends Controller
{
    public function index() 
    {
        return view("kpi.list", [
            "kpiList" => Kpi::all()
        ]);
    }

    public function store(Request $request)
    {
        $kpi = Kpi::create($request->all());
        $kpi->save();

        return redirect()->route("kpiList")->with("message", [
            'text' => 'KPI created',
            'status' => 'success'
        ]);
    }

    public function update(Request $request)
    {

        if ($kpi = Kpi::find($request->get('kpi_id'))) {
            $kpi->update($request->all());
        } else {
            $kpi = Kpi::create($request->all());
        $kpi->save();
        }
        

        return redirect()->route("kpiList")->with("message", [
            'text' => 'KPI updated',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $kpi = Kpi::find($request->get('kpi_delete_id'));
        $kpi->delete();

        return redirect()->route("kpiList")->with("message", [
            'text' => 'KPI deleted',
            'status' => 'success'
        ]);
    }
}
