<?php

namespace App\Forms;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class SubscriptionForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.subscriptions.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.subscriptions.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('title', 'text',[
                'label' => 'Titre',
                'rules' => [
                    'required',
                    Rule::unique('subscriptions')->ignore($this->getModel()->id)
                ]
            ])
            ->add('credit', 'number',[
                'label' => 'Crédit',
                'rules' => [
                    'required',
                    'numeric',
                ]
            ])
            ->add('price', 'number',[
                'label' => 'Coût',
                'attr' => [
                    'step' => '0.01'
                ],
                'rules' => [
                    'required',
                    'numeric',
                ]
            ])
            ->add('quota', 'number',[
                'label' => 'Quota d\'annonces',
                'rules' => [
                    'required',
                    'numeric',
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
