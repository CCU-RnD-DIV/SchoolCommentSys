@extends('blade.header')

@section('content')

    <row>
        @if($user_auth == 0)
            <a href="/console/viewAllProcess"><button type="primary" outline >回首頁</button></a>
        @elseif ($user_auth == 1)
            <a href="/general/viewProcess"><button type="primary" outline >回首頁</button></a>
        @endif
    </row>

    <row cols="1">

        <column cols="12">
            <div>
                <fieldset>
                    <legend><i class="fa fa-info-circle"></i> 建言資訊</legend>

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
                            <h5>{{ $comment_user_detail[0]->name  }}</h5>
                        </column>
                        <column cols="3">
                            <label>系級</label>
                            <hr>
                            <h5>{{ $comment_user_detail[0]->dept  }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="6">
                            <label>聯絡手機 <span class="req">*</span> </label>
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
                    <hr>
                <fieldset>
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
                            <h5>{{ $comment_detail[0]->resp_text }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="12">
                            <label>針對所反應事項，您認為合理的解決方案應為？ <span class="req">*</span> </label>
                            <hr>
                            <h5>{{ $comment_detail[0]->resp_expect }}</h5>
                        </column>
                    </row>
                    <row>
                        <column cols="12">
                            <label>附加檔案</label>
                            <hr>
                            <h5><a href="/upload/attachments/{{$comment_detail[0]->resp_attachment }}" target="_blank"> {{ $comment_detail[0]->resp_attachment }}</a></h5>
                        </column>
                    </row>
                </fieldset>

                @if ($user_auth == 0)
                {!! Form::open(['url' => 'console/modifyStatus', 'class' => 'forms', 'method' => 'post']) !!}
                <fieldset>
                    <input type="hidden" id="comment_id" name="comment_id" value="{{$comment_detail[0] -> id}}" />
                    <legend>狀態更新</legend>
                    <section>
                        <label>狀態更新</label>
                        <hr>
                        <section>
                            <label class="checkbox"><input type="radio" name="status" value="0"> 秘書室已收件</label>
                            <label class="checkbox"><input type="radio" name="status" value="1"> 已分派至相關單位處理</label>
                            <label class="checkbox"><input type="radio" name="status" value="2"> 相關單位已回覆，本處統合中</label>
                            <label class="checkbox"><input type="radio" name="status" value="4"> 因相關原因，已撤銷本次建言</label>
                        </section>
                    </section>
                    <section>
                        {!! Form::submit('確認變更', ['class' => 'btn', 'type' => 'primary']) !!}
                    </section>
                </fieldset>
                {!! Form::close() !!}
                @endif

                @if (($user_auth == 2 || $user_auth == 0) && $comment_detail[0]-> reply_OK != 3)
                    {!! Form::open(['url' => 'console/commentReply','files' => true, 'class' => 'forms', 'method' => 'post']) !!}
                    <fieldset>
                        <input type="hidden" id="comment_id" name="comment_id" value="{{$comment_detail[0] -> id}}" />
                        <legend>回覆欄</legend>
                        <row>
                            <column cols="12">
                                <label>相關單位回覆 <span class="req">*</span> </label>
                                {!! Form::textarea('reply-text', null, ['placeholder' => '相關單位回覆', 'row' => 12]) !!}
                            </column>
                        </row>
                        <row>
                            <column cols="12">
                                <label>附加檔案</label>
                                <input type="file" id="reply-attachment" name="reply-attachment" />
                                <div class="desc">圖片、資料請自行壓縮一併上傳， 檔案容量需小於7MB </div>
                            </column>
                        </row>
                        <section>
                            {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary']) !!}
                        </section>
                        {!! Form::close() !!}
                    </fieldset>
                @elseif($comment_detail[0]-> reply_OK == 3)
                    <fieldset>
                        <legend>回覆欄</legend>
                        <row>
                            <column cols="12">
                                <label>相關單位回覆 <span class="req">*</span> </label>
                                <hr>
                                <h5>{{$comment_detail[0]-> reply_text}}</h5>
                            </column>
                        </row>
                        <row>
                            <column cols="12">
                                <label>附加檔案</label>
                                <h5><a href="/upload/attachments/{{$comment_detail[0]->reply_attachment }}" target="_blank"> {{ $comment_detail[0]->reply_attachment }}</a></h5>
                            </column>
                        </row>
                    </fieldset>
                @endif

                @if (0)
                    <?php $admin = ['1', '2', '3']; ?>
                    <fieldset>
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