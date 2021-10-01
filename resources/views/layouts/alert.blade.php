
@php
    $title = null;
    $class = null;
    if(session('success')){
        $title = 'Success!';
        $class = 'success';
    }elseif(session('warning')){
        $title = 'Warning!';
        $class = 'warning';
    }elseif(session('danger')){
        $title = 'Ooops!';
        $class = 'danger';
    }
@endphp

@isset($title)
<div class="alert alert-{{$class}} alert-dismissible fade show" role="alert">
    <strong>{{$title}}</strong> {{session($class)}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endisset