@extends('blade.header')

@section('content')
    <row>

        <span class="btn-group">
            <a href="/general"><button type="primary" outline>主選單</button></a>
            <a href="/generalLogin"><button type="red" >登出</button></a>
        </span>

    </row>
    @if(isset($_SESSION['errorFileMIME']) && $_SESSION['errorFileMIME']  == 1)
    <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> 由於您上傳了系統所不允許的檔案，建言已自動撤銷。</div>
    @endif
    <row cols="1">

        <column cols="12">
            <div>
                <table>
                    <thead>
                    <tr>
                        <th class="width-4">反應主題</th>
                        <th class="width-3">反應日期</th>
                        <th class="width-3">處理狀態</th>
                        <th class="width-1">撤銷處理</th>
                    </tr>
                    <tbody>
                    @foreach($comment_detail as $comments_detail)
                        <tr>
                            <td><a href="viewCertainProcess/{{$comments_detail -> id}}">{{$comments_detail -> topic}}</a></td>
                            <td>{{$comments_detail -> resp_time}}</td>
                            <td>
                                @if($comments_detail -> cancel == 1)
                                    <div class="alert alert-error"><i class="fa fa-times"></i> 使用者已撤銷</div>
                                @elseif($comments_detail -> reply_OK == 0)
                                    <div class="alert alert-primary"><i class="fa fa-paper-plane"></i> 已發出意見</div>
                                @elseif($comments_detail -> reply_OK == 1)
                                    <div class="alert alert-warning"><i class="fa fa-share-square"></i> 已派送至相關單位處理</div>
                                @elseif($comments_detail -> reply_OK == 3)
                                    <div class="alert alert-success"><i class="fa fa-check"></i> 已回覆</div>
                                @elseif($comments_detail -> reply_OK == 4)
                                    <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> 因相關原因，不予回覆</div>
                                @endif
                            </td>
                            <td>
                                @if($comments_detail -> cancel == 1 )
                                    <div class="alert alert-error">已撤銷</div>
                                @elseif($comments_detail -> reply_OK == 0)
                                    {!! Form::open(['url' => 'general/cancelComment', 'class' => 'forms', 'method' => 'post']) !!}
                                    <input type="hidden" name="comment_id" value="{{$comments_detail -> id}}"/>
                                    {!! Form::submit('撤銷處理', ['class' => 'btn', 'type' => 'primary']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </column>

    </row>
@stop

@extends('blade.footer')