@extends('layouts.back.admin')

@if(Route::currentRouteName() == 'admin.settings.pages.create')
    @section('title',"Création d'une nouvelle page")
    @section('page_title',"Création d'une nouvelle page")
@endif
@if(Route::currentRouteName() == 'admin.settings.pages.edit')
    @section('title',"Modification de la page ".@$page->title)
    @section('page_title',"Modification de la page ".@$page->title)
@endif

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.pages.create')
                        <h2 class="card-title font-weight-bold">Ajouter une page</h2>
                        <form action="{{route('admin.settings.pages.store')}}" method="post">
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.pages.edit')
                        <h2 class="card-title font-weight-bold">Modifier la page</h2>
                        <form action="{{route('admin.settings.pages.update', $page->id)}}" method="post">
                        @method('PUT')
                    @endif
                </div>
                <div class="card-body row">
                    @csrf
                    <div class="col-12 form-group has-error"> 
                        <label for="title" class="control-label required">Titre de la page</label> 
                        <input class="form-control" required="required" name="title" type="text" value="{{old('title',@$page->title)}}" id="title"> 
                    </div> 
                    <!-- for now we allow to check form type only on page creation -->
                    @if(Route::currentRouteName() == 'admin.settings.pages.create')
                    <div class="form-group col-sm-12 col-md-6"> 
                        <label for="page_type" class="control-label">Type de page</label>
                        <select class="form-control" name="page_type" type="text" id="page_type">
                            <option value="0" {{intval(old("page_type",@$page->page_type)) === 0?"selected":""}}> Page générique </option>
                            <option value="1" {{intval(old("page_type",@$page->page_type)) === 1?"selected":""}}> Page Aide </option>
                        </select>
                    </div> 
                    @else
                    <input type="hidden" name="page_type" value="{{@$page->page_type}}">
                    @endif
                    <div class="form-group col-sm-12 col-md-6"> 
                        <label for="is_public" class="control-label">Page public <small>Cocher si la page est accessible aux utilisateurs non-authentifiés</small> </label> 
                        <input class="form-control" name="is_public" type="checkbox" id="is_public" value="1" {{intval(old('is_public',@$page->is_public)) == 1?"selected":''}}"> 
                    </div>
                    <!-- we show the page content on if page type is generique -->
                    @if(intval(@$page->page_type) === 0)
                    <div class="form-group col-sm-12 col-md-12" id="content-page">
                        <label for="content" class="control-label">Contenu de la page</label> 
                        <textarea class="form-control ckeditor" name="content" cols="50" rows="10" id="content">{{old('content',@$page->content)}}</textarea> 
                    </div>
                    @endif
                    <!-- for now we display the faq section only on page edition with page type == 1 -->
                    @if(Route::currentRouteName() == 'admin.settings.pages.edit' && intval(@$page->page_type) === 1)
                    <div class="form-group col-sm-12 col-md-12" id="faqs-page">
                        <label for="content" class="control-label">Contenu de la page</label>
                        @php $i = 0; @endphp
                        <div class="col-12">
                            <a href="#" class="mx-2 text-sm btn btn-primary btn-sm add-faqg" data-toggle="modal" data-target="#faq-add-title" data-route="{{ route('admin.settings.faq_groups.store',@$faq->id) }}" data-page_id="{{@$page->id}}" data-position="{{@$page->faq_groups?@$page->faq_groups->count() + 1:1}}"><i class="fa fa-user-times"></i> Ajouter un titre </a>
                        </div>
                        <div id="faqgs">
                        @if(@$page)
                            @forelse(@$page->faq_groups()->orderby('position','asc')->get() as $faq_group)
                                @php ++$i ; $j = 0; @endphp
                                <div class="card-body my-2 faq_groups">
                                    <h5 class="row justify-content-between" id="faqg-{{$faq_group->id}}">
                                        <div class="col-10">
                                            <div class="faqg-title active">{{$faq_group->title}}</div>
                                            <div class="faqg-title-input">
                                                <input type="text" name="faqg_title_{{@$i}}" value="{{$faq_group->title}}" class="form-control">
                                                <input type="hidden" name="faqg_id_{{@$i}}" value="{{$faq_group->id}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-success btn-sm edit-faq_group edit-faq" data-id="{{$faq_group->id}}" id="faq_group{{$faq_group->id}}"><i class="fa fa-pen"></i></button>
                                            <a href="#" class="mx-2 text-sm btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('admin.settings.faq_groups.destroy',@$faq_group->id) }}" ><i class="fa fa-trash"></i></a>
                                            <a href="#" class="mx-2 text-sm btn btn-primary btn-sm add-faq" data-toggle="modal" data-target="#faq-add-faq" data-route="{{ route('admin.settings.faqs.store',@$faq_group->id) }}" data-faqg_id="{{$faq_group->id}}" data-position="{{@$faq_group->faq? @$faq_group->faq->count()+ 1 : 1}}"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </h5>
                                    <div id="accordion-{{$faq_group->id}}" class="accordion">
                                        @foreach($faq_group->faqs()->orderby('position','asc')->get() as $faq)
                                            @php ++$j ; @endphp
                                            <div class="group">
                                                <h3 id="panel_title_{{@$faq->id}}"> {{ @$faq->title }} </h3>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="hidden" class="form-control" name="faq_id_{{@$j}}" value="{{@$faq->id}}">
                                                        <input type="hidden" class="form-control" name="faq_position_{{@$j}}" value="{{@$faq->position}}">
                                                        <input type="text" class="form-control" name="faq_title_{{@$j}}" value="{{@$faq->title}}">
                                                    </div>
                                                    <div class="col-12">
                                                        <textarea class="form-control" name="faq_content_{{@$j}}" id="faq_content_{{@$faq->id}}" cols="30" rows="10">{!! @$faq->content !!}</textarea>
                                                    </div>
                                                    <div class="col-12 my-2">
                                                        <!-- <a href="#" class="mx-2 text-sm btn btn-success btn-sm edit-faq"  data-faq_group="{{ @$faq_group->id }}" data-id="{{@$faq->id}}"><i class="fa fa-pen"></i> Sauvegarder </a>
                                                        <a href="#" class="mx-2 text-sm btn btn-danger btn-sm edit-faq" data-toggle="modal" data-target="#modal-faq" data-title="{{ @$faq->title }}" data-whatever="{{ route('admin.settings.faqs.destroy',@$faq->id) }}"><i class="fa fa-trash"></i> Supprimer </a> -->

                                                        <a href="#" class="mx-2 text-sm btn btn-danger btn-sm edit-faq" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('admin.settings.faqs.destroy',@$faq->id) }}"    ><i class="fa fa-user-times"></i> Supprimer</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" class="form-control" name="faq_total_{{$faq_group->id}}" value="{{@$j}}">
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        @endif
                        </div>
                        <input type="hidden" name="faqg_total" value="{{$i}}">
                    </div>
                    @endif
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label for="is_public" class="control-label col-12">Page role <small>Sélectionner si la page doit être limitée à une fonction.</small> </label> 
                        <select class="form-control col-12" name="roles" id="roles">
                            <option value=""> --- </option>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}"> {{$role->name}} </option>
                            @endforeach
                        </select>
                    </div> 
                    <button class="btn bg-primary float-right" type="submit"><i class="fa fa-save mr-2"></i>Enregistrer</button>
                    <a class="btn bg-success float-right mx-4" href="{{route('admin.settings.pages.index')}}"><i class="fa fa-reply"></i> Annuler</a>
                </div>
            </div>
            </form>
        </div>
    </div>

    @include('layouts.back.alerts.faqs-form')
    @include('layouts.back.alerts.faq-form')

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')


@endpush
