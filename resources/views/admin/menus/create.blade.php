@extends('layouts.back.admin')

@section('title','Gestion des pages')

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
                    <div class="form-group col-sm-12 col-md-6"> 
                        <label for="page_type" class="control-label">Type de page</label> 
                        <select class="form-control" name="page_type" type="text" id="page_type">
                            <option value="0" {{intval(old("page_type",@$page->page_type)) === 0?"selected":""}}> Page générique </option>
                            <option value="1" {{intval(old("page_type",@$page->page_type)) === 1?"selected":""}}> Page Aide </option>
                        </select>
                    </div> 
                    <div class="form-group col-sm-12 col-md-6"> 
                        <label for="is_public" class="control-label">Page public <small>Cocher si la page est accessible aux utilisateurs non-authentifiés</small> </label> 
                        <input class="form-control" name="is_public" type="checkbox" id="is_public" value="1" {{intval(old('is_public',@$page->is_public)) == 1?"selected":''}}"> 
                    </div> 
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label for="content" class="control-label">Contenu de la page</label> 
                        <textarea class="form-control ckeditor" name="content" cols="50" rows="10" id="content">{{old('content',@$page->content)}}</textarea> 
                    </div>
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

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')


@endpush
