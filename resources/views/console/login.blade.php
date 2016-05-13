@extends('blade.header')

@section('content')

    <row cols="1">
        <column cols="12">
            <div>
                {!! Form::open(['url' => 'consoleLogin', 'class' => 'forms', 'method' => 'post']) !!}
                {{ csrf_field() }}
                <fieldset>
                    <legend>Console Login data</legend>
                    <row cols="2">
                        <column cols="4">

                        </column>
                        <column cols="8">
                            @if(isset($alert_failed))
                                <div class="alert alert-error">帳號密碼錯誤或是帳戶尚未啟用</div>
                            @endif
                            <section>
                                {!! Form::label('account', '帳號') !!}
                                {!! Form::text('account', null, ['placeholder' => '您的帳號', 'class' => 'width-6']) !!}
                                @if ($errors->has('account')) <h5 class="text-danger">{{ $errors->first('account') }}</h5> @endif
                            </section>
                            <section>
                                {!! Form::label('password', '密碼') !!}
                                {!! Form::password('password', ['placeholder' => '您的密碼', 'class' => 'width-6']) !!}
                                @if ($errors->has('password')) <h5 class="text-danger">{{ $errors->first('password') }}</h5> @endif
                            </section>
                            <section>
                                {!! Form::submit('登入', ['class' => 'btn', 'type' => 'primary']) !!}
                            </section>
                        </column>
                    </row>

                </fieldset>
                {!! Form::close() !!}
            </div>
        </column>

    </row>
@stop

@extends('blade.footer')