<?php

namespace App\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.categories.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.categories.store');
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
            ]) */
            ->add('type', 'select',[
                'label' => 'Type',
                'choices' => ['evènement' => 'Evènement', 'annonce' => 'Annonce'],
                'empty_value' => '=== Choisissez le type de catégorie ===',
                'rules' => [
                    'required',
                ]
            ])
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => [
                    'required',
                    Rule::unique('categories')->ignore($this->getModel()->id)
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
