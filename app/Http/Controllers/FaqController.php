<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Faq;

class FaqController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveFaq(Request $request, $id = null)
    {
        $data = $request->validate([
            'title'         => 'required',
            'content'       => 'required',
            'faq_group_id'  => 'nullable',
            'id'            => 'nullable',
        ]);
        $faq = Faq::find(@$data['id']);
        $faq = $faq ?? new Faq();
            dd($data);
        $faq->title = $data['title'];
        $faq->content = $data['content'];

        $faq->save();
        return response()->json([
                                'title'     => $faq->title,
                                'content'   => $faq->content,
                                'status'    => 200,
                                'message'   => "La page a été enregistrée avec succès!"
                                ]
                            );
        return response()->json($data, 204);
        // return redirect()->route('admin.settings.pages.index')->with('success','La page a été enregistrée avec succès!');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required',
            'content'       => 'required',
            'faq_group_id'  => 'nullable',
        ]);
        /* $faq = Faq::find(@$data['id']);
        $faq = $faq ?? new Faq();
            dd($data);
        $faq->title = $data['title'];
        $faq->content = $data['content']; */
        $faq = Faq::create($data);
        // dd($faq);
        return redirect()
                ->back()
                ->with('success','La page a été enregistrée avec succès!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->back()->with("success",'Element supprimé');
    }
}
