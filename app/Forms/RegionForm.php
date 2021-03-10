<?php

namespace App\Forms;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class RegionForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.regions.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.regions.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('region_number', 'number',[
                'label' => 'N° de Région',
                'rules' => [
                    'required',
                    'numeric',
                    /* Rule::unique('regions')->ignore($this->getModel()->id) */
                ]
            ])
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => [
                    'required',
                    /* Rule::unique('regions')->ignore($this->getModel()->id) */
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
