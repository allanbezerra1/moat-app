<?php

namespace App\Http\Controllers;

use App\Services\AlbumService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    private $albumServices;

    public function __construct(AlbumService $albumServices)
    {
        $this->middleware('permission:album-list|album-create|album-edit|album-delete', ['only' => ['index','store']]);
        $this->middleware('permission:album-create', ['only' => ['create','store']]);
        $this->middleware('permission:album-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:album-delete', ['only' => ['destroy']]);
        $this->albumServices = $albumServices;
    }

    public function index(){
        $album = $this->albumServices->all();
        return view('album.index', compact('album'));
    }

    public function create(){

        $newArtist = $this->albumServices->artist();
        return view('album.create', compact('newArtist'));

    }

    public function edit($id)
    {
        $album = $this->albumServices->FindById($id);
        $newArtist = $this->albumServices->artist();
        return view('album.edit',compact('album', 'newArtist'));
    }

    public function store(Request $request)
    {

        $data = $request->only('artist','name','year');
        $validator = Validator::make($data, [
            'artist' => 'required|string',
            'name' => 'required|string',
            'year' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            DB::beginTransaction();
            //Request is valid, create new album
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $this->albumServices->Create($input);
            DB::commit();
            return redirect()->route('album.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->only('artist','name','year');
        $validator = Validator::make($data, [
            'artist' => 'required|string',
            'name' => 'required|string',
            'year' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            DB::beginTransaction();
            //Request is valid, create new user
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $this->albumServices->update($id, $input);
            DB::commit();
            return redirect()->route('album.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors($th->getMessage());
        }
    }
    public function show($id)
    {
        $album = $this->albumServices->findByid($id);
        return view('album.show', compact('album'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
                $album = $this->albumServices->destroy($id);
                DB::commit();
                return redirect()->route('album.index')->with('success deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('album.index')->with($th->getMessage());
        }
    }


}
