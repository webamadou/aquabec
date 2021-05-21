<?php

namespace App\Forms;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class MenuForm extends Form
{
    public function buildForm()
    {
        $roles = Role::pluck('name','name')->all();
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.menus.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.menus.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('name', 'text',[
                'label' => "Nom du menu",
                'rules' => [
                    'required',
                    Rule::unique('menus')->ignore($this->getModel()->id)
                ]
            ])
            ->add('parent', 'entity',[
                'label' => 'Menu parent',
                'empty_value' => " --- ",
                'class' => Menu::class,
                'property' => 'name',
                'rules' => [
                    'nullable',
                    'numeric',
                    'exists:menus,id'
                ]
            ])
            ->add('visible', 'checkbox',[
                'label' => 'Visible',
                'rules' => [
                    'nullable',
                ]
            ])
            ->add('roles', 'select',[
                'label' => 'Role',
                'choices' => $roles,
                'empty_value' => '=== Selectionner un role si le menu est limite a une fonction ===',
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
