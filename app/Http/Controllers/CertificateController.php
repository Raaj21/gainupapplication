<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:certificate-list|certificate-create|certificate-edit|certificate-delete', ['only' => ['index','show']]);
         $this->middleware('permission:certificate-create', ['only' => ['create','store']]);
         $this->middleware('permission:certificate-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:certificate-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Certificate::latest()->paginate(5);
        return view('certificate.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = Product ::all();
        return view('certificate.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->input);
        request()->validate([
            'type_id' => 'required',
            'image' => 'required',
        ]);


        $arr = explode('.', $request->image);
        $product = new Certificate;
        $product->type_id = $request->input('type_id');
        $product->user_id = auth()->user()->id ;

        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;

            $file->move('uploads/formfill/', $filename);
            $product->image = $filename;
        }


        $product->save();

        return redirect()->route('certificate.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $product)
    {
        return view('certificate.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $product)
    {
        return view('certificate.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $product)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('certificate.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $product)
    {
        $product->delete();

        return redirect()->route('certificate.index')
                        ->with('success','Product deleted successfully');
    }
}