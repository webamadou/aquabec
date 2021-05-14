<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq_group;
use App\Models\Faq;
class FaqGroupController extends Controller
{

    public function destroy(Faq_group $faq_group)
    {
        if($faq_group){
            $faqs = Faq::where('faq_group',@$faq_group->id);
            if($faqs){
                foreach ($faqs as $faq) {
                    $faq->delete();
                }
            }
            $faq_group->delete();
        }
        return redirect()->back()->with("success",'Element supprimé');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required',
            'page_id'   => 'required',
            'position'  => 'nullable',
        ]);
            // dd($data);
        Faq_group::create($data);

        return redirect()->back()->with("success","Titre enregistré");
    }
}
