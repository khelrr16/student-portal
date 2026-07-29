<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Complete Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.complete-profile')
                </div>
            </div>
        </div>
    </div>

<form method="POST" action="{{ route('setup.profile') }}">

@csrf

<h2>Complete Profile</h2>

<label>Name</label>

<input
type="text"
name="name">

<br><br>

<label>Birthday</label>

<input
type="date"
name="birthday">

<div id="studentFields">

    <br>

    <label>Strand</label>

    <input
    type="text"
    name="strand">

    <br><br>

    <label>Year</label>

    <select name="year">

        <option>1</option>

        <option>2</option>

        <option>3</option>

        <option>4</option>

    </select>

</div>

<div id="facultyFields">

    <br>

    <label>Subjects</label>

    @foreach($subjects as $subject)

    <div>

        <input
        type="checkbox"
        name="subjects[]"
        value="{{ $subject->id }}">

        {{ $subject->subject_name }}

    </div>

    @endforeach

</div>

<button>

Save

</button>

</form>

</x-app-layout>

<script>

const role = document.getElementById('role');

const student = document.getElementById('studentFields');

const faculty = document.getElementById('facultyFields');

student.style.display="none";

faculty.style.display="none";

role.addEventListener('change',function(){

    if(this.value=="student"){

        student.style.display="block";

        faculty.style.display="none";

    }

    else if(this.value=="faculty"){

        student.style.display="none";
        faculty.style.display="block";

    }

    else{

        student.style.display="none";
        faculty.style.display="none";

    }

});

</script>