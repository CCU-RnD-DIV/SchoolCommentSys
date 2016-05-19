@extends('blade.headerEmail')

@section('content')
    <row cols="1">

        <column cols="12">
            <div>
                <fieldset>
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
                            <h5>{{ $comment_user_detail[0]->name  }}</h5>
                        </column>
                        <column cols="3">
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
                </fieldset>
            </div>
        </column>

    </row>
@stop

@extends('blade.footer')