<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CreditPackForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('banker.credit_pack.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('banker.credit_pack.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('pack_ref', 'hidden',[
                'rules' => [
                    'required',
                    Rule::unique('credit_packs')->ignore($this->getModel()->id)
                ],
                'value' => Str::random(50)
            ])
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => [
                    'required',
                    Rule::unique('credit_packs')->ignore($this->getModel()->id)
                ]
            ])
            ->add('pack_value', 'text',[
                'label'       => 'Valeur du pack',
                'rules'       => [ 'required', 'integer' ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
