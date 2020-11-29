<?php

namespace App\Forms;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class OrganisationForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.organisations.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.organisations.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => [
                    'required',
                    Rule::unique('organisations')->ignore($this->getModel()->id)
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
