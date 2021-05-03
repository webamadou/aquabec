@extends('layouts.back.admin')

@section('title','Gestion des pages')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.create_section')
                        <h2 class="card-title font-weight-bold">Ajouter une section</h2>
                        <form action="{{route('admin.settings.store_section')}}" method="post">
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.edit_section')
                        <h2 class="card-title font-weight-bold">Modifier la section</h2>
                        <form action="{{route('admin.settings.update_section', $home_section->id)}}" method="post">
                        @method('PUT')
                    @endif
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-group has-error" data-children-count="1"> 
                        <label for="title" class="control-label required">Titre de la section</label> 
                        <input class="form-control" required="required" name="title" type="text" value="{{old('title',@$home_section->title)}}" id="title"> 
                    </div>
                    <div class="form-group" data-children-count="1"> 
                        <label for="content" class="control-label">Contenu de la section</label> 
                        <textarea class="form-control ckeditor" name="content" cols="50" rows="10" id="content">{{old('content',@$home_section->content)}}</textarea> 
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
