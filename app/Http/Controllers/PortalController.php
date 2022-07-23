<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Post;
use App\Models\Slider;
use App\Models\User;
use App\Models\Mainmenu;

class PortalController extends Controller
{
    //

public function index(Request $request)
{
    $data['sliders']        = Slider::where('status', 1)->get();
    $data['posts']          = Post::where('status', 1)->get();
    $data['latestposts']    = Post::where('status', 1)->limit(5)->get();
    $data['headline']       = Post::where('status', 1)->where('is_headline', 1)->get();
    $data['category']       = Categories::get();

    return view('portal.index', compact('data'));
}
public function about()
{
    $idAdmin = session('admin_id');

    $data['isLogin'] = ($idAdmin != null ? true : false);
    $data['posts']          = Post::where('status', 1)->get();
    $data['latestposts']    = Post::where('status', 1)->limit(5)->get();
    $data['category']       = Categories::get();
    $data['user']           = User::find($idAdmin);

    return view('portal.about', compact('data'));
}
public function post()
{
    $data['posts']          = Post::where('status', 1)->get();
    $data['latestposts']    = Post::where('status', 1)->limit(5)->get();
    $data['category']       = Categories::get();

    return view('portal.post', compact('data'));
}
}
