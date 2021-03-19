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
                <div class="card-body">
                    @csrf
                    <div class="form-group has-error" data-children-count="1"> 
                        <label for="title" class="control-label required">Titre de la page</label> 
                        <input class="form-control" required="required" name="title" type="text" value="{{old('title',@$page->title)}}" id="title"> 
                    </div> 
                    <div class="form-group" data-children-count="1"> 
                        <label for="subtitle" class="control-label">Type de page</label> 
                        <select class="form-control" name="page_type" type="text" id="subtitle">
                            <option value="0" {{intval(old("page_type",@$page->page_type)) === 0?"selected":""}}> Page générique </option>
                            <option value="1" {{intval(old("page_type",@$page->page_type)) === 1?"selected":""}}> Page Aide </option>
                        </select>
                    </div> 
                    <div class="form-group" data-children-count="1"> 
                        <label for="subtitle" class="control-label">sous-titre</label> 
                        <input class="form-control" name="subtitle" type="text" id="subtitle" value="{{old('subtitle',@$page->subtitle)}}"> 
                    </div> 
                    <div class="form-group" data-children-count="1"> 
                        <label for="content" class="control-label">Contenu de la page</label> 
                        <textarea class="form-control ckeditor" name="content" cols="50" rows="10" id="content">{{old('content',@$page->content)}}</textarea> 
                    </div> 
                    <button class="btn bg-primary float-right" type="submit"><i class="fa fa-save mr-2"></i>Enregistrer</button>
                    <a class="btn bg-success float-right mx-4" href="{{route('admin.settings.pages.index')}}"><i class="fa fa-reply"></i> Annuler</a>
                </div>
                @if(Route::currentRouteName() == 'admin.settings.security.permissions.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.security.permissions.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle permission
                        </a>
                    </div>
                @endif
            </div>
            </form>
        </div>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}" defer></script>
    <script type="text/javascript" defer>
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>

@endpush
