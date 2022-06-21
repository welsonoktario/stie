<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use App\Models\JabatanStruktural;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JabatanStrukturalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $jabatans = JabatanStruktural::select('jabatan_strukturals.*', 'users.name as name', 'staffs.gelar_belakang as gelar_belakang', 'staffs.gelar_depan as gelar_depan')
            ->leftJoin('staffs', 'jabatan_strukturals.staff_id', '=', 'staffs.id')
            ->leftJoin('users', 'staffs.user_id', '=', 'users.id')
            ->paginate(100);
        return Inertia::render('Master/Akademik/JabatanStruktural/JabatanStruktural.vue',[
            'jabatans' => $jabatans,
        ]);

        dd($jabatans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
