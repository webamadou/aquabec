<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;

class PermissionForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.security.permissions.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.security.permissions.store');
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
                    Rule::unique('permissions')->ignore($this->getModel()->id)
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
