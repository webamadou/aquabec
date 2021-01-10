<?php

namespace App\Forms;

use App\Models\Region;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class CityForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.cities.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.cities.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('region_id', 'entity',[
                'label' => 'Région',
                'class' => Region::class,
                'property' => 'name',
                'rules' => [
                    'required',
                    'numeric',
                    'exists:regions,id'
                ]
            ])
            ->add('prefix', 'select',[
                'label' => 'Préfix',
                'choices' => ['Saint' => 'Saint', 'Sainte' => 'Sainte'],
                'empty_value' => '=== Choisissez un préfix ===',
                'rules' => [
                    'nullable',
                ]
            ])
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => [
                    'required',
                    Rule::unique('regions')->ignore($this->getModel()->id)
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
