<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use App\Models\CreditPack;

class CreditForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('banker.credits.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('banker.credits.store');
            $method = 'POST';
        }
        $current_user       = Auth::id();//We need the current user's id for the generated_by field
        $credit_pack_id     = CreditPack::select("id")->first();//Right now we just get the first pack 

        $this->formOptions  = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('ref', 'hidden',[
                'rules' => [
                    'nullable',
                    Rule::unique('credits')->ignore($this->getModel()->id)
                ],
                'value' => Str::random(20)
            ])
            ->add('generated_by', 'hidden',[
                'rules' => ['nullable' ],
                'value' => $current_user
            ])
            ->add('credit_pack_id', 'hidden',[
                'rules' => ['required' ],
                'value' => @$credit_pack_id->id
            ])
            ->add('value', 'number',[
                'label'       => 'Nombre de credit à générer',
                'rules'       => [ 'required', 'integer' ]
            ])
            ->add('credit_type', 'choice', [
                'label' => 'Selectionnez le type de crédit à générer',
                'choices' => [
                    '0' => 'Crédit gratuit',
                    '1' => 'Crédit payant'
                ],
                'empty_value' => 'Type de crédit',
                'rules' => ['required'],
            ])
            ->add('<i class="fa fa-save mr-2"></i>Générer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
