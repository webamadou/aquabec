<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;
use App\Models\Role;

class RoleForm extends Form
{

  public $selected = '' ;
    public function __construct()
    {
      $this->selected = 'users';
    }
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.security.roles.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.security.roles.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('name', 'text',[
                'label' => 'Nom de la fonction',
                'rules' => [
                    'required',
                    Rule::unique('roles')->ignore($this->getModel()->id)
                ]
            ])
            /*->add('city_id','entity',[
                'label'     => 'Roles',
                'class'     => Role::class,
                'property'  => 'guard_name',
                'empty_value' => '=== Choisissez une ville ===',
                'attr' => [
                    'class' => 'form-control select2bs4'
                ],
                'rules' => [
                    'required',
                    'numeric',
                    'exists:cities,id'
                ]
            ])*/

            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
