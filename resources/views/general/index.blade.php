@extends('blade.header')

@section('content')

    <blocks cols="2" class="index-align">

        <div>
            <a href="general/addComment"><img src="/assets/img/add_comment.png" /></a>
            <p></p>
            <h5>新增建言</h5>
        </div>

        <div>
            <a href="general/viewProcess"><img src="/assets/img/process.png" /></a>
            <p></p>
            <h5>處理情形</h5>
        </div>

    </blocks>
    @stop

@extends('blade.footer')