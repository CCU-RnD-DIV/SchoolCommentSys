@extends('blade.header')

@section('content')

    <row cols="1">

        <span class="btn-group">
            <a href="/general"><button type="primary" outline>主選單</button></a>
            <a href="/generalLogin"><button type="red" >登出</button></a>
        </span>

    </row>

    <br>

    <row cols="1">

        <column cols="12">
            <div>
                {!! Form::open(['url' => 'general/addComment','files' => true, 'class' => 'forms', 'onsubmit' => "return confirm('確認送出？提醒您內容一經送出無法修改');"]) !!}
                {{ csrf_field() }}
                <fieldset>
                    <legend>注意事項</legend>
                    <section>
                        <ol>
                            <li>
                                請針對本校政策興革提出建言，陳情、反應或諮詢事項亦可，與校務無關之謾罵、惡意攻訐、情緒批評等，將逕予刪除。
                            </li>
                            <p></p>
                            <li>
                                請投書者自行至建言系統查詢案件處理狀況，本系統不主動將處理情形回覆至您的信箱。
                            </li>
                            <p></p>
                            <li>
                                本校管理者或業管單位可視案件需求，進一步透過電話聯繫或約請投書人面談、派員實地查證，以協助解決問題。
                                特別提醒您，冒用他人信箱或手機投書者，將負法律責任。
                            </li>
                            <p></p>
                            <li>
                                當您填寫本表單時，即視同您已同意遵守本表單個人資料之蒐集、處理與利用。詳閱「<a href="dataUsageANC" target="_blank">國立中正大學校務建言表單個人資料蒐集告知聲明</a>」。
                            </li>
                        </ol>
                    </section>
                </fieldset>
                <fieldset>
                    <legend>國立中正大學校務建言表單</legend>

                    <row>
                        <column cols="3">
                            <label>填寫日期</label>
                            <h5> {{ $now }} </h5>
                        </column>
                        <column cols="3">
                            <label>學號</label>
                            <h5>@if (isset($user_detail[0]->account)){{ $user_detail[0]->account }}@endif</h5>
                        </column>
                        <column cols="3">
                            <label>姓名</label>
                            <h5>@if (isset($user_detail[0]->name)){{ $user_detail[0]->name }}@endif</h5>
                        </column>
                        <column cols="3">
                            <label>系級</label>
                            <h5>@if (isset($dept_alias[0]->name)){{ $dept_alias[0]->name }} {{ $aca_user_detail[0]->stu_grade }}{{ $aca_user_detail[0]->stu_class }} @endif </h5>
                        </column>
                    </row>
                    <hr>
                    <row id="topic">
                        <column cols="12">

                            <div class="input-prepend">
                                @if ($errors->has('topic'))
                                    <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('topic') !!}</span>
                                @else
                                    <span class="alert alert-primary"> 反應主題</span>
                                @endif
                                {!! Form::text('topic', null, ['v-model' => 'message']) !!}

                                        <span v-show="!message" class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 請填寫您的反應主題，限填 20 字元</span>
                                        <span v-show="message.length > 20" class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> 超過 20 字元，請刪減</span>

                            </div>

                        </column>
                    </row>

                    <row>
                        <column cols="6" id="cellphone">

                            <div class="input-prepend">
                                @if ($errors->has('cellphone'))
                                    <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('cellphone') !!}</span>
                                @else
                                    <span class="alert alert-primary">聯絡電話</span>
                                @endif
                                <input type="text" name="cellphone" id="cellphone" v-model="cellphone" value="@if (isset($aca_user_detail_phone[0]->cellphone)){{ $aca_user_detail_phone[0]->cellphone }} @endif"/>
                                    <span v-show="!cellphone" class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 請填寫您的聯絡電話</span>
                            </div>
                            <div class="desc">若無手機，敬請留下方便聯繫您的通訊號碼</div>
                        </column>
                        <column cols="6" id="email">
                            <div class="input-prepend">
                                @if ($errors->has('email'))
                                    <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('email') !!}</span>
                                @else
                                    <span class="alert alert-primary">電子郵件</span>
                                @endif
                                <input type="text" name="email" id="email" v-model="email" value="@if (isset($aca_user_detail[0]->stu_email))<?= trim($aca_user_detail[0]->stu_email) ?>@endif"/>
                                    <span v-show="!email" class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 請填寫您的電子郵件</span>
                            </div>
                        </column>
                    </row>

                    <row>
                        <column cols="12" id="resptext">
                            <div class="input-prepend">
                                @if ($errors->has('resp-text'))
                                    <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-text') !!}</span>
                                @else
                                    <span class="alert alert-primary">反應事項</span>
                                @endif
                                {!! Form::textarea('resp-text', null, ['row' => 12, 'v-model' => 'resptext']) !!}
                                    <span v-show="!resptext" class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 請填寫您的反應事項</span>
                            </div>
                        </column>
                    </row>

                    <row>
                        <column cols="12" id="respexpect">
                            <label>針對反應事項，您認為合理的解決方案應為？ <span class="req">*</span> </label>
                            <div class="input-prepend">
                                @if ($errors->has('resp-expect'))
                                    <span class="alert alert-error center"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-expect') !!}</span>
                                @endif
                                {!! Form::textarea('resp-expect', null, ['row' => 12, 'v-model' => 'respexpect']) !!}
                                    <span v-show="!respexpect" class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 請填寫您認為合理的解決方案</span>
                            </div>
                        </column>
                    </row>

                    <row>
                        <column cols="12">
                            <label>附加檔案</label>
                            <hr>

                            1.<input type="file" name="resp-attachment1" /><br><br>
                            @if ($errors->has('resp-attachment1'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-attachment1') !!}</span>
                            @endif
                            2.<input type="file" name="resp-attachment2" /><br><br>
                            @if ($errors->has('resp-attachment2'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-attachment2') !!}</span>
                            @endif
                            3.<input type="file" name="resp-attachment3" /><br><br>
                            @if ($errors->has('resp-attachment3'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-attachment3') !!}</span>
                            @endif
                            4.<input type="file" name="resp-attachment4" /><br><br>
                            @if ($errors->has('resp-attachment4'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-attachment4') !!}</span>
                            @endif
                            5.<input type="file" name="resp-attachment5" /><br><br>
                            @if ($errors->has('resp-attachment5'))
                                <span class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {!! $errors->first('resp-attachment5') !!}</span>
                            @endif

                            <div class="desc">每份檔案容量需小於7MB，只接受 Word, Excel, PowerPoint, PDF, JPG, PNG, GIF, RAR, ZIP, 7z 等格式</div>
                        </column>
                    </row>
                    <section id="submit">
                        {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary', 'v-model' => 'submit']) !!}
                    </section>
                </fieldset>
                {!! Form::close() !!}
            </div>
        </column>

    </row>
    <script>
        new Vue({
            el: '#topic',
            data: {
                message: ''
            }
        });
        new Vue({
            el: '#cellphone',
            data: {
                message: ''
            }
        });
        new Vue({
            el: '#email',
            data: {
                message: ''
            }
        });
        new Vue({
            el: '#resptext',
            data: {
                message: ''
            }
        });
        new Vue({
            el: '#respexpect',
            data: {
                message: ''
            }
        });
        new Vue({
            el: '#submit',
            data: {
                message: ''
            }
        });
    </script>
@stop

@extends('blade.footer')