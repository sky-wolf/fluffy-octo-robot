@extends ('template.template')
@section('content')
<h1>Home</h1>
<p>Welcome to the home page!</p>
@if (count($users) === 1)
<p>I have one record!</p>
@elseif (count($users) > 1)
<p>I have multiple records!</p>
@else
<p>I don't have any records!</p>
@endif
@switch($a)
@case(1)
    <p>First case...</p>
@break
@case(2)
    <p>Second case...</p>
@break

@default
    <p>Default case...</p>
@endswitch
<p></p>
@for ($i = 0; $i < 10; $i++)
<p>The current value is {{ $i }}</p>
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach




<p> end test</p>
@endsection