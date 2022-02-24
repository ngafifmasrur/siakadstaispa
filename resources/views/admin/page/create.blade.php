@extends('layouts.app')
@section('title', 'Page Baru')

@section('content')
<x-header>
    Page Baru
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Page Baru</x-slot>
    

    <form action="{{ route('admin.page.store')}}" method="post" id="form_setting">
        @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="judul">Judul</label>
                    {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
                </div>
                <div class="form-group">
                    <label for="content">Konten</label>
                    {!! Form::textarea('content', null, ['class' => 'form-control '.($errors->has('content') ? 'is-invalid' : ''), 'id' => 'content', 'rows' => 5]) !!}
                </div>
                <div class="form-group">
                    <label for="is_active">Status</label>
                    {!! Form::select('is_active', array(1 => 'Publish', 0 => 'Unpublish') , ['class' => 'form-control '.($errors->has('is_active') ? 'is-invalid' : ''), 'id' => 'is_active']); !!}
                </div>
            </div>

            <button class="float-right btn btn-primary" type="submit">Simpan</button>
    </form>
</x-card-table>
@endsection

@push('js')
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
    var konten = document.getElementById("content");
        CKEDITOR.replace(konten,{
        language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
    editor = CKEDITOR.instances.content;
    </script>
@endpush