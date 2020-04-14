@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="check" method="POST">
                @csrf
                <div class="form-group text-center">
                    <input type="text" name="inn" placeholder="Введите ИНН" class="form-control my-1" required>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary my-1">Отправить</button>
                    @foreach($errors->all() as $message)
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @endforeach
                </div>
            </form>
            <div class="text-center">
                @if($checkedInn)
                    @if($checkedInn->response_status === 200)
                        <div class="text-success">
                            {{ $checkedInn->message }}
                        </div>
                    @else
                        <div class="text-danger">
                            {{ $checkedInn->message }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
