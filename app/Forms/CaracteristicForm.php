<?php

namespace App\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class CaracteristicForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.caracteristics.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.caracteristics.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];
        $types = [
            '0' => 'Texte simple', '1' => 'Choix unique', '2' => 'Choix multiple'
        ];

        $this
            ->add('category_id', 'entity',[
                'label' => 'Parent *',
                'class' => Category::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez la catégorie parente ===',
                'rules' => [
                    'nullable',
                    'numeric',
                    'exists:categories,id'
                ]
            ])
            ->add('name', 'text',[
                'label' => 'Nom *',
                'rules' => [
                    'required',
                    /* Rule::unique('categories')->ignore($this->getModel()->id) */
                ]
            ])
            ->add('type', 'select',[
                'label' => "Type d'entrée *",
                'choices' => $types,
                'empty_value' => '=== Choisissez le type de catégorie ===',
                'rules' => [
                    'required',
                ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
