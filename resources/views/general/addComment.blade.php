@extends('blade.header')

@section('content')

    <row cols="1">

        <column cols="12">
            <div>
                {!! Form::open(['url' => 'general/addComment','files' => true, 'class' => 'forms', 'method' => 'post']) !!}
                    <fieldset>
                        <legend>注意事項</legend>
                        <section>
                            <ol>
                                <li>
                                    請針對本校政策興革提出建言，陳情、反應或諮詢事項亦可，與校務無關之謾罵、惡意攻訐、情緒批評等，將逕予刪除。
                                </li>
                                <p></p>
                                <li>
                                    為確保您所反應之事項可確實收到回覆，務請再次確認所填寫電子信箱正確、能正常收信及未遭他人冒用。管理
                                    者或業管單位亦可視案件需求，進一步投過手機聯繫或約請投書人面談、派員實地查證，以協助解決。冒用他人
                                    信箱或手機投書者，亦將負法律責任，特別提醒您。
                                </li>
                                <p></p>
                                <li>
                                    當您填寫本表單時，即視同您已同意遵守本表單個人資料之蒐集、處理與利用。詳閱國立中正大學校務建言表單
                                    個人資料蒐集告知聲明。
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
                                <h5>{{ $user_detail[0]->account }}</h5>
                            </column>
                            <column cols="3">
                                <label>姓名</label>
                                <h5>{{ $user_detail[0]->name }}</h5>
                            </column>
                            <column cols="3">
                                <label>系級</label>
                                <h5>{{ $user_detail[0]->dept }}</h5>
                            </column>
                        </row>

                        <row>
                            <column cols="12">
                                <label>反應主旨事項 <span class="req">*</span> <span class="desc">限填 20 字元</span></label>
                                {!! Form::text('topic', null, ['placeholder' => '反應主旨事項']) !!}
                                <div class="desc">Description</div>
                            </column>
                        </row>

                        <row>
                            <column cols="6">
                                <label>聯絡手機 <span class="req">*</span> </label>
                                {!! Form::text('cellphone', null, ['placeholder' => '聯絡手機']) !!}
                                <div class="desc">Description</div>
                            </column>
                            <column cols="6">
                                <label>電子郵件 <span class="req">*</span> </label>
                                {!! Form::text('email', null, ['placeholder' => '電子郵件']) !!}
                                <div class="desc">Description</div>
                            </column>
                        </row>

                        <row>
                            <column cols="12">
                                <label>欲反應事項 <span class="req">*</span> </label>
                                {!! Form::textarea('resp-text', null, ['placeholder' => '欲反應事項', 'row' => 12]) !!}
                                <div class="desc">Description</div>
                            </column>
                        </row>

                        <row>
                            <column cols="12">
                                <label>針對所反應事項，您認為合理的解決方案應為？ <span class="req">*</span> </label>
                                {!! Form::textarea('resp-expect', null, ['placeholder' => '欲反應事項', 'row' => 12]) !!}
                                <div class="desc">Description</div>
                            </column>
                        </row>

                        <row>
                            <column cols="12">
                                <label>附加檔案</label>

                                <input type="file" id= "resp-attachment" name="resp-attachment" />

                                <div class="desc">圖片、資料請自行壓縮一併上傳， 檔案容量需小於7MB </div>
                            </column>
                        </row>
                        <section>
                            {!! Form::submit('確認送出', ['class' => 'btn', 'type' => 'primary']) !!}
                        </section>
                    </fieldset>
                {!! Form::close() !!}}
            </div>
        </column>

    </row>
    @stop

@extends('blade.footer')