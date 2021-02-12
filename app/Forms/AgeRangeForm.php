<?php

namespace App\Forms;

use App\Models\AgeRange;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class AgeRangeForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.age_ranges.update', $this->getModel());
            $method = 'PUT';
        } else {
            $url = route('admin.settings.age_ranges.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            /* ->add('parent_id', 'entity',[
                'label' => 'Parent',
                'class' => Category::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez la catégorie parente ===',
                'rules' => [
                    'nullable',
                    'numeric',
                    'exists:categories,id'
                ]
            ])
            ->add('type', 'select',[
                'label' => 'Type',
                'choices' => ['event' => 'Evènement', 'announcement' => 'Annonce'],
                'empty_value' => '=== Choisissez le type de catégorie ===',
                'rules' => [
                    'required',
                ]
            ]) */
            ->add('name', 'text',[
                'label' => 'Nom du groupe d\'age',
                'rules' => [
                    'required',
                    Rule::unique('categories')->ignore($this->getModel()->id)
                ]
            ])
            ->add('position', 'number',[
                'label' => 'position du groupe d\'age dans une liste',
                'rules' => [
                    'required','numeric'
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
