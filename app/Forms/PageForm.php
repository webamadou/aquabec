<?php

namespace App\Forms;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class PageForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.pages.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.pages.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('title', 'text',[
                'label' => 'Titre de la page',
                'rules' => [
                    'required',
                    Rule::unique('pages')->ignore($this->getModel()->id)
                ]
            ])
            ->add('subtitle', 'text',[
                'label' => 'sous-titre',
                'rules' => [
                    'nullable',
                ]
            ])
            ->add('content', 'textarea',[
                'label' => 'Contenu',
                'rules' => [
                    'nullable',
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
