<?php

namespace App\Forms;

use App\Models\Category;
use App\Models\City;
use App\Models\Organisation;
use App\Models\Region;
use Kris\LaravelFormBuilder\Form;

class EventForm extends Form
{
    public function buildForm()
    {
        if ($this->getModel() && $this->getModel()->id) {
            $url = route('user.events.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('user.events.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('title','text',[
                'label' => 'Titre',
                'rules' => [
                    'required',
                    'string',
                    'min:10',
                    'max:250'
                ]
            ])
            ->add('description','textarea',[
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control textarea',
                ],
                'rules' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000'
                ]
            ])
            ->add('image', 'file',[
                'label' => 'Image',
                'attr' => [
                    'class' => 'custom-file-input',
                    'onchange' => 'readURL(this);'
                ],
                'rules' => [
                    'required',
                    'image',
                    'max:2048'
                ]
            ])
            ->add('postal_code','text',[
                'label' => 'Code postal',
                'rules' => [
                    'required',
                ]
            ])
            ->add('telephone','text',[
                'label' => 'Téléphone',
                'rules' => [
                    'required',
                    'numeric'
                ]
            ])
            ->add('region_id', 'entity',[
                'label' => 'Région',
                'class' => Region::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez une région ===',
                'attr' => [
                    'class' => 'form-control select2bs4',
                    'onchange' => 'showCity(this.value)'
                ],
                'rules' => [
                    'required',
                    'numeric',
                    'exists:regions,id'
                ]
            ])
            ->add('city_id','entity',[
                'label' => 'Ville',
                'class' => City::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez une ville ===',
                'attr' => [
                    'class' => 'form-control select2bs4'
                ],
                'rules' => [
                    'required',
                    'numeric',
                    'exists:cities,id'
                ]
            ])
            ->add('organisation_id', 'entity',[
                'label' => 'Organisation',
                'class' => Organisation::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez une organisation ===',
                'attr' => [
                    'class' => 'form-control select2bs4'
                ],
                'rules' => [
                    'required',
                    'numeric',
                    'exists:organisations,id'
                ]
            ])
            ->add('category_id', 'entity',[
                'label' => 'Catégorie',
                'class' => Category::class,
                'property' => 'name',
                'empty_value' => '=== Choisissez une catégorie ===',
                'attr' => [
                    'class' => 'form-control select2bs4'
                ],
                'rules' => [
                    'required',
                    'numeric',
                    'exists:categories,id'
                ]
            ])
            ->add('website', 'url',[
                'label' => 'Site Web',
                'rules' => [
                    'required',
                    'url'
                ]
            ])
            ->add('email', 'email',[
                'label' => 'Adresse email',
                'rules' => [
                    'required',
                    'email',
                    'max:250'
                ]
            ])
            ->add('dates', 'text',[
                'label' => 'Dates',
                'attr' => [
                    'class' => 'form-control float-right',
                    'id' => 'reservationtime'
                ],
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
