<?php

namespace App\Http\Controllers\cPanel;
use App\Http\Controllers\Controller;

use App\Http\Requests\PicRequest;
use App\Pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PicController extends Controller
{
    /**
     * Display a listing of the Pics
     *
     * @param  \App\Pic  $model
     * @return \Illuminate\View\View
     */
    public function index(Pic $model)
    {
        return view('Pic.index', ['Pics' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new Pic
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       /* $Pic = Pic::find(338);
        dd($Pic->posts()->get());*/
        return view('Pic.create');
    }

    /**
     * Store a newly created Pic in storage
     *
     * @param  \App\Http\Requests\PicRequest  $request
     * @param  \App\Pic  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PicRequest $request)
    {


        if ($request->hasFile('file'))
        {
            $img = $request->file;
            $file_name = uniqid().'.'.$img->getClientOriginalExtension();
            $img->storeAs('/public',$file_name);

           $pic =  Pic::create([
                'path' => $file_name ,
                ]);
            return response()->json([ 'id' => $pic->id , 'path' => $pic->path ], 200);
        }
        return redirect()->route('pic.index')->withStatus(__('Pic Failed  created.'));



    }
   public function getJson()
   {
       $data = Pic::get();
       return response()->json($data,200);
   }
    /**
     * Show the form for editing the specified Pic
     *
     * @param  \App\Pic  $Pic
     * @return \Illuminate\View\View
     */
    public function edit(Pic $Pic)
    {
        
        return view('Pic.edit', compact('Pic'));
    }

    /**
     * Update the specified Pic in storage
     *
     * @param  \App\Http\Requests\PicRequest  $request
     * @param  \App\Pic  $Pic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PicRequest $request, Pic  $Pic)
    {
        $Pic->update(
            $request->all()
        );

        return redirect()->route('Pic.index')->withStatus(__('Pic successfully updated.'));
    }

    /**
     * Remove the specified Pic from storage
     *
     * @param  \App\Pic  $Pic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request , $id)
    {

        $pic = Pic::find($id);
        $removed = File::delete('storage/'.$pic->path);
        if ($removed)
        {
            $pic->delete();
            return response()->json([ 'success' => 'well done '  ], 200);
        }

//        return redirect()->route('Pic.index')->withStatus(__('Pic successfully deleted.'));
    }
}
