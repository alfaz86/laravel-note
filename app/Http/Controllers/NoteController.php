<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::orderBy('updated_at', 'DESC')->get();
        return view('index', compact('notes'));
    }

    public function new()
    {
        return view('new');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->only(['title', 'body']);
            if (!$data['title']) $data['title'] = 'Tanpa Judul';
            Note::create($data);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return redirect(route('index'))->with('message', 'data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        return view('edit', compact('note'));
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->only(['title', 'body']);
            if (!$data['title']) $data['title'] = 'Tanpa Judul';
            Note::where('id', $id)->update($data);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return redirect(route('index'))->with('message', 'data berhasil diupdate!');
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            Note::wherein('id', $request->ids)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();
        \Session::flash('message', 'data berhasil dihapus!');
        return true;
    }
}
