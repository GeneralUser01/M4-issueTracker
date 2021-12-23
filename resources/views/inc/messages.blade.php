@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="errorMessage">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="successMessage">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="errorMessage">
        {{session('error')}}
    </div>
@endif