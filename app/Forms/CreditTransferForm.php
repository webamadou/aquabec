<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use App\Models\CreditPack;

class CreditTransferForm extends Form
{
    public $users = null;

    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('banker.credits.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('banker.credits.store');
            $method = 'POST';
        }

        $url = route('credits.transfer');
        $method = 'POST';

        $current_user       = auth()->user();//We need the current user's id for the generated_by field
        //Then we fetch all the users except current user
        $users = \App\Models\User::where('id', '!=', $current_user->id)->pluck('name','id');
        

        $this->formOptions  = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('sent_by', 'hidden',[
                'rules' => ['required' ],
                'value' => $current_user
            ])
            ->add('credit_pack_id', 'hidden',[
                'rules' => ['required' ],
                'value' => @$credit_pack_id->id
            ])
            ->add('sent_to', 'select',[
                'label'         => 'Destinataire',
                'choices'       => $users->toArray(),
                'wrapper'       => ['class' => 'choice-wrapper'],
                'label_attr'    => ['class' => 'label-class'],
                'empty_value'   => '=== Choisissez le destinataire ===',
                'rules'         => [
                        'required',
                    ]
            ]);
            if($current_user->hasRole("super-admin"))
            {
                $this->add('credit_type', 'radio',[
                    'label'         => 'Credit gratuit',
                    'value'         => 0,
                    'wrapper'       => ['class' => 'label'],
                    'label_attr'    => ['class' => 'label-class'],
                    'empty_value'   => '=== Choisissez le type de credit ===',
                    'rules'         => [
                            'required',
                        ]
                ]);
            }
            $this->add('valeur', 'number', [
                'label' => 'Valeur à transférer',
                "options" => ['placeholder' => 'Type de crédit'],
                'rules' => ['required','integer|min:1'],
            ])
            ->add('<i class="fa fa-save mr-2"></i>Transferer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
