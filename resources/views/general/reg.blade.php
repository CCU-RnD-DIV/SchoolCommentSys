@extends('blade.header')

@section('content')
    <row cols="1">
        <column cols="12">
            <div>

                <fieldset>
                    <legend>Registration</legend>
                    <row cols="2">
                        <column cols="4">

                        </column>
                        <column cols="8" class="text-center">
                            @if(config('environment.studentManualLogin'))
                                {!! Form::open(['url' => 'generalReg', 'class' => 'forms', 'method' => 'post']) !!}
                                {{ csrf_field() }}
                                @if(isset($alert_failed))
                                    <div class="alert alert-error">有東西錯了</div>
                                @endif
                                <section>
                                    {!! Form::label('account', '學號') !!}
                                    {!! Form::text('account', null, ['placeholder' => '您的學號', 'class' => 'width-6']) !!}
                                    @if ($errors->has('account')) <h5 class="text-danger">{{ $errors->first('account') }}</h5> @endif
                                </section>
                                <section>
                                    {!! Form::label('name', '姓名') !!}
                                    {!! Form::text('name', null, ['placeholder' => '您的姓名', 'class' => 'width-6']) !!}
                                    @if ($errors->has('name')) <h5 class="text-danger">{{ $errors->first('name') }}</h5> @endif
                                </section>
                                <section>
                                    {!! Form::label('password', '密碼') !!}
                                    {!! Form::password('password', ['placeholder' => '您的密碼', 'class' => 'width-6']) !!}
                                    @if ($errors->has('password')) <h5 class="text-danger">{{ $errors->first('password') }}</h5> @endif
                                </section>
                                <section>
                                    {!! Form::label('crm_password', '確認密碼') !!}
                                    {!! Form::password('crm_password', ['placeholder' => '確認密碼', 'class' => 'width-6']) !!}
                                    @if ($errors->has('crm_password')) <h5 class="text-danger">{{ $errors->first('crm_password') }}</h5> @endif
                                </section>
                                <section>
                                    {!! Form::submit('註冊', ['class' => 'btn', 'type' => 'primary']) !!}
                                </section>
                                {!! Form::close() !!}
                            @endif
                            <figure>
                                <img src="/assets/img/ssoLogin.svg" width="45%" alt="" />
                                <figcaption></figcaption>
                            </figure>
                        </column>
                    </row>

                </fieldset>
            </div>
        </column>

    </row>
@stop

@extends('blade.footer')