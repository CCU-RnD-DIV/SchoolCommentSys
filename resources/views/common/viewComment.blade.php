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
                            <h5> {{ $comment_detail[0]->resp_time  }} </h5>
                        </column>
                        <column cols="3">
                            <label>學號</label>
                            <h5>{{ $comment_user_detail[0]->account  }}</h5>
                        </column>
                        <column cols="3">
                            <label>姓名</label>
                            <h5>{{ $comment_user_detail[0]->name  }}</h5>
                        </column>
                        <column cols="3">
                            <label>系級</label>
                            <h5>{{ $comment_user_detail[0]->dept  }}</h5>
                        </column>
                    </row>
                    <hr>
                    <row>
                        <column cols="6">
                            <label>聯絡手機 <span class="req">*</span> </label>
                            <h5>{{ $comment_detail[0]->cellphone }}</h5>

                        </column>
                        <column cols="6">
                            <label>電子郵件 <span class="req">*</span> </label>
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
                            <h5>{{ $comment_detail[0]->topic }}</h5>

                        </column>
                    </row>
                    <hr>
                    <row>
                        <column cols="12">
                            <label>欲反應事項 <span class="req">*</span> </label>
                            <h5>{{ $comment_detail[0]->resp_text }}</h5>

                        </column>
                    </row>
                    <hr>
                    <row>
                        <column cols="12">
                            <label>針對所反應事項，您認為合理的解決方案應為？ <span class="req">*</span> </label>
                            <h5>{{ $comment_detail[0]->resp_expect }}</h5>

                        </column>
                    </row>
                    <hr>
                    <row>
                        <column cols="12">
                            <label>附加檔案</label>
                            <h5>{{ $comment_detail[0]->resp_attachment }}</h5>
                        </column>
                    </row>
                </fieldset>
                @if ($user_auth == 2 || $user_auth == 0)
                    {!! Form::open(['url' => 'general/addComment', 'class' => 'forms', 'method' => 'post']) !!}
                    <fieldset>
                        <legend>回覆欄</legend>
                        <row>
                            <column cols="12">
                                <label>相關單位回覆 <span class="req">*</span> </label>
                                {!! Form::textarea('resp-expect', null, ['placeholder' => '相關單位回覆', 'row' => 12]) !!}
                            </column>
                        </row>
                        <row>
                            <column cols="12">
                                <label>附加檔案</label>
                                <form action="/upload-target" class="dropzone">
                                    <input type="file" name="file" />
                                </form>
                                <div class="desc">圖片、資料請自行壓縮一併上傳， 檔案容量需小於7MB </div>
                            </column>
                        </row>
                        <section>
                            {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary']) !!}
                        </section>
                    </fieldset>
                @endif
                @if (0)
                    {!! Form::open(['url' => '/console/commentAssign', 'class' => 'forms', 'method' => 'post']) !!}
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