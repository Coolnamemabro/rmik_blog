<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mainmenu;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MainMenuController extends Controller
{
    //
    public function create()
    {
        $parent = Mainmenu::get();
        return view('admin.mainmenu.create', compact('parent'));
    }

    public function insert(Request $request)
    {
        $request->validate(Mainmenu::$rules);
        $requests = $request->all();
        $requests['file'] = "";
        if ($request->hasFile('file')) {
            $files = Str::random("20") . "-" . $request->file->getClientOriginalName();
            $request->file('file')->move("file/mainmenu/", $files);
            $requests['file'] = "file/mainmenu/" . $files;
        }
 
        $cat = Mainmenu::create($requests);
        if($cat){
            return redirect('admin/mainmenu')->with('status', 'Berhasil menambah data !');
        }
 
        return redirect('admin/mainmenu')->with('status', 'Gagal menambah data !');
    }
public function index()
{
    $data = Mainmenu::get();
    return view('admin.mainmenu.index', compact('data'));
}
public function delete($id)
{
    $data = Mainmenu::find($id);
    if ($data == null) {
        return redirect('admin/mainmenu')->with('status', 'Data tidak ditemukan !');
    }
    if ($data->file !== null || $data->file !== "") {
        File::delete("$data->file");
    }
    $delete = $data->delete();
    if ($delete) {
        return redirect('admin/mainmenu')->with('status', 'Berhasil hapus mainmenu !');
    }
    return redirect('admin/mainmenu')->with('status', 'Gagal hapus mainmenu !');
}
public function edit($id)
{
    $parent = Mainmenu::get();
    $data = Mainmenu::find($id);
    return view('admin.mainmenu.edit', compact('parent', 'data'));
}
public function update(Request $request, $id)
{
    
    $d = Mainmenu::find($id);
    if ($d == null) {
        return redirect('admin/mainmenu')->with('status', 'Data tidak ditemukan !');
    }

    $req = $request->all();

    if ($request->hasFile('thumbnail')) {
        if ($d->thumbnail !== null) {
            File::delete("$d->thumbnail");
        }
        $post = Str::random("20") . "-" . $request->thumbnail->getClientOriginalName();
        $request->file('thumbnail')->move("file/mainmenu/", $post);
        $req['thumbnail'] = "file/mainmenu/" . $post;
    }

    $data = Mainmenu::find($id)->update($req);
    if ($data) {
        return redirect('admin/mainmenu')->with('status', 'Mainmenu berhasil diedit !');
    }
    return redirect('admin/mainmenu')->with('status', 'Gagal edit mainmenu !');
}
}