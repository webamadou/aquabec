<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Validation\Rule;

class PermissionForm extends Form
{
  public $persmission_group = [
    'base'      => 'Base',
    'general'   => 'Gestion générale',
    'users'     => 'Gestion des membres',
    'events'    => 'Gestion des Événements',
    'announcement' => 'Gestion des annonces classées',
    'banker'    => 'Bankier'
  ];
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
            ->add('permission_group', 'select',[
                'label'       => 'Groupe de permissions',
                'choices'     => $this->persmission_group,
                    'wrapper' => ['class' => 'choice-wrapper'],
                    'label_attr' => ['class' => 'label-class'],
                'empty_value' => '=== Choisissez une fonction ===',
                'rules'       => [
                        'required',
                        /*Rule::unique('permissions')->ignore($this->getModel()->id)*/
                    ]
            ])
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
