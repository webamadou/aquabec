<?php

namespace App\Forms;

use App\Models\MenuLink;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;

class MenuLinkForm extends Form
{
    public function buildForm()
    {
        $pages = Page::orderby('title')->pluck('title','id')->all();
        $menus = Menu::where('visible',1)
                        ->orderby('name')
                        ->pluck('name','id')
                        ->all();

        if ($this->getModel() && $this->getModel()->id) {
            $url = route('admin.settings.menu_links.update', $this->getModel()->id);
            $method = 'PUT';
        } else {
            $url = route('admin.settings.menu_links.store');
            $method = 'POST';
        }

        $this->formOptions = [
            'method' => $method,
            'url' => $url
        ];

        $this
            ->add('name', 'text',[
                'label' => "Nom du lien",
                'rules' => [
                    'required',
                    Rule::unique('menu_links')->ignore($this->getModel()->id)
                ]
            ])
            ->add('page_id', 'select',[
                'label' => 'Lier le lien à une page',
                'choices' => $pages,
                'empty_value' => ' --- ',
                'rules' => [
                    'nullable',
                ]
            ])
            ->add('menu_id', 'select',[
                'label' => 'Ajouter le lien dans un menu',
                'choices' => $menus,
                'empty_value' => ' --- ',
                'rules' => [
                    'nullable',
                ]
            ])
            /* ->add('custom_url', 'text',[
                'label' => "URL personalisé",
                'rules' => [
                    'nullable'
                ]
            ]) *
            ->add('menu_id', 'entity',[
                'label' => 'Ajouter le lien dans un menu',
                'empty_value' => " --- ",
                'class' => Menu::where('visible',1)->get(),
                'property' => 'name',
                'rules' => [
                    'nullable',
                    'numeric',
                    'exists:menus,id'
                ]
            ])
            /* ->add('visible', 'checkbox',[
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
            ]) */
            ->add('<i class="fa fa-save mr-2"></i>Enregistrer','submit',[
                'attr' => [
                    'class' => 'btn bg-primary float-right'
                ]
            ]);
    }
}
