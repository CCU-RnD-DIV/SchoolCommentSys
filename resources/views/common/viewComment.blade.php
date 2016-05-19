@extends('blade.header')

@section('content')
    <SCRIPT LANGUAGE="JavaScript">

        function varitext(text){
            text=document.getElementById('printPage').innerHTML;
            print(text);
        }
    </script>
    <span class="btn-group">
        @if($user_auth == 0)
            <a href="/console/viewAllProcess"><button type="primary" outline >回首頁</button></a>
        @elseif ($user_auth == 1)
            <a href="/general/viewProcess"><button type="primary" outline >回首頁</button></a>
        @endif
        <button id="printBtn" name="print" type="grey" ONCLICK="varitext()" outline>列印此頁</button>
    </span>

    <br><br><br>

    <row cols="1">

        <column cols="12">
            <div id="printPage">
                <fieldset>
                    @if($comment_detail[0] -> cancel == 1)
                        <div class="alert alert-error"><i class="fa fa-times"></i> 使用者已撤銷</div>
                    @elseif($comment_detail[0] -> reply_OK == 0)
                        <div class="alert alert-primary"><i class="fa fa-paper-plane"></i> 建言已建立，未審核</div>
                    @elseif($comment_detail[0] -> reply_OK == 1)
                        <div class="alert alert-warning"><i class="fa fa-share-square"></i> 已派送至相關單位處理</div>
                    @elseif($comment_detail[0] -> reply_OK == 3)
                        <div class="alert alert-success"><i class="fa fa-check"></i> 已回覆</div>
                    @elseif($comment_detail[0] -> reply_OK == 4)
                        <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> 本次建言因相關原因不予回覆，詳情請見回覆欄。</div>
                    @elseif($comment_detail[0] -> reply_OK == 5)
                        <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> 因上傳系統所禁止的檔案，不予回覆</div>
                    @endif
                    <legend><i class="fa fa-info-circle"></i> 建言者資訊</legend>

                    <row>
                        <column cols="3">
                            <label>填寫日期</label>
                            <hr>
                            <h5> {{ $comment_detail[0]->resp_time  }} </h5>
                        </column>
                        <column cols="3">
                            <label>學號</label>
                            <hr>
                            <h5>{{ $comment_user_detail[0]->account  }}</h5>
                        </column>
                        <column cols="3">
                            <label>姓名</label>
                            <hr>
                            <h5>@if (isset($comment_user_detail[0]->name)){{ $comment_user_detail[0]->name  }}@endif</h5>
                        </column>
                        <column cols="3">
                            <label>系級</label>
                            <hr>
                            <h5>@if (isset($dept_alias[0]->name)){{ $dept_alias[0]->name }} {{ $aca_user_detail[0]->stu_grade }}{{ $aca_user_detail[0]->stu_class }} @endif</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="6">
                            <label>聯絡電話 <span class="req">*</span> </label>
                            <hr>
                            <h5>{{ $comment_detail[0]->cellphone }}</h5>

                        </column>
                        <column cols="6">
                            <label>電子郵件 <span class="req">*</span> </label>
                            <hr>
                            <h5>{{ $comment_detail[0]->email }}</h5>

                        </column>
                    </row>
                </fieldset>

                <fieldset style="margin-top: 5%;">
                    <legend><i class="fa fa-align-left"></i> 建言內容</legend>
                    <row>
                        <column cols="12">
                            <label>反應主旨事項 <span class="req">*</span> <span class="desc">限填 20 字元</span></label>
                            <hr>
                            <h5>{{ $comment_detail[0]->topic }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="12">
                            <label>欲反應事項 <span class="req">*</span> </label>
                            <hr>
                            <h5 style="word-break:break-all">{{ $comment_detail[0]->resp_text }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="12">
                            <label>針對所反應事項，您認為合理的解決方案應為？ <span class="req">*</span> </label>
                            <hr>
                            <h5 style="word-break:break-all">{{ $comment_detail[0]->resp_expect }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="12">
                            <label>附加檔案</label>
                            <hr>
                            @foreach($comment_attachments as $comment_attachment)
                                @if($comment_attachment -> attachment_type == 0)
                                    <h5><a href="/upload/attachments/{{$comment_attachment->attachment }}" target="_blank"> {{ $comment_attachment->file_des }}</a></h5>
                                @endif
                            @endforeach
                        </column>
                    </row>
                </fieldset>

                @if ($user_auth == 0 && $comment_detail[0]-> reply_OK != 3 && $comment_detail[0]-> reply_OK != 4 && $comment_detail[0]-> cancel != 1 )
                    {!! Form::open(['url' => 'console/commentReply','files' => true, 'class' => 'forms', 'method' => 'post']) !!}
                    {{ csrf_field() }}
                    <fieldset style="margin-top: 5%;">
                        <legend>回覆欄</legend>
                        <section>
                            <label>狀態更新</label>
                            <hr>
                            <section>
                                <label class="checkbox"><input type="radio" name="status" value="1" checked> 已分派至相關單位處理</label>
                                <label class="checkbox"><input type="radio" name="status" value="3"> 已準備回覆</label>
                                <label class="checkbox"><input type="radio" name="status" value="4"> 因相關原因，已撤銷本次建言（請於回覆欄填寫撤銷原因）</label>
                            </section>
                            @if ($errors->has('status'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('status') !!}</span>
                            @endif
                        </section>
                        <input type="hidden" id="comment_id" name="comment_id" value="{{$comment_detail[0] -> id}}" />
                        <row>
                            <column cols="12">
                                <label>相關單位回覆 <span class="req">*</span> </label>
                                <hr>
                                <textarea rows="12" name="reply-text" placeholder="相關單位回覆">{{$comment_detail[0]->reply_text}}</textarea>
                                @if ($errors->has('reply-text'))
                                    <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('reply-text') !!}</span>
                                @endif
                            </column>
                        </row>
                        <row>
                            <column cols="12">
                                <label>附加檔案</label>
                                <hr>

                                1.<input type="file" name="resp-attachment1" /><br>
                                2.<input type="file" name="resp-attachment2" /><br>
                                3.<input type="file" name="resp-attachment3" /><br>
                                4.<input type="file" name="resp-attachment4" /><br>
                                5.<input type="file" name="resp-attachment5" /><br>

                                <div class="desc">每份檔案容量需小於7MB，只接受 Word, Excel, PowerPoint, PDF, JPG, PNG, GIF, RAR, ZIP, 7z 等格式</div>
                            </column>
                        </row>
                        <section>
                            {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary']) !!}
                        </section>
                        {!! Form::close() !!}
                    </fieldset>
                @elseif($comment_detail[0]-> reply_OK == 3 || $comment_detail[0]-> reply_OK == 4)
                    <fieldset style="margin-top: 5%;">
                        <legend>回覆欄</legend>
                        <row>
                            <column cols="12">
                                <label>相關單位回覆 <span class="req">*</span> </label>
                                <hr>
                                <h5 style="word-break:break-all">{{$comment_detail[0]-> reply_text}}</h5>
                            </column>
                        </row>
                        <row>
                            <column cols="12">
                                <label>附加檔案</label>
                                <hr>
                                @foreach($comment_attachments as $comment_attachment)
                                    @if($comment_attachment -> attachment_type == 1)
                                        <h5><a href="/upload/attachments/{{$comment_attachment->attachment }}" target="_blank"> {{ $comment_attachment->file_des }}</a></h5>
                                    @endif
                                @endforeach
                            </column>
                        </row>
                    </fieldset>
                @endif

                @if (0)
                    <?php $admin = ['1', '2', '3']; ?>
                    <fieldset style="margin-top: 5%;">
                        <input type="hidden" id="id" name="id" value="{{$comment_detail[0] -> id}}" />
                        <legend>分派相關單位</legend>
                        <section>
                            <label>分派相關單位</label>
                            {!! Form::select('reply-major[]', $admin, null, ['multiple' => true]) !!}
                        </section>
                        <section>
                            {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary']) !!}
                        </section>
                    </fieldset>
                @endif
            </div>
        </column>

    </row>
@stop

@extends('blade.footer')