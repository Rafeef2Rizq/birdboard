<x-app-layout>

    <body>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-slot name="header">
                    <div class="flex justify-between item-center ">
                        <p class="font-semibold text-xl text-gray-800 leading-tight ">
                            <a href="/projects"> {{ __('My projects') }}</a> / {{ $project->title }}
                        </p>
                        <a href="{{ $project->path().'/edit' }}"
                            class="bg-blue text-black no-underline rounded-lg text-sm py-2 px-5 shadow">Edit project</a>
                    </div>
                </x-slot>

                <main>
                    <div class="lg:flex -mx-3">
                        <div class="lg:w-3/4 px-3 mb-6">
                            <div class="mb-8">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3 ">
                                    {{ __('My tasks') }}
                                </h2>
                                <!-- tasks -->
                                @foreach ($project->tasks as $task )
                                <div class="bg-white  p-5 rounded-lg shadow w-full mb-3 ">
                                    <form action="{{ $task->path()}}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <div class="flex ">
                                            <input id="body" name="body" value="{{ $task->body }}" class="w-full border-none
                                            {{ $task->completed ?'text-red':'' }}">
                                            <input id="completed" name="completed" type="checkbox"
                                                onchange="this.form.submit()" {{ $task->completed ?'checked':'' }}>
                                        </div>
                                    </form>
                                </div>


                                @endforeach
                                <div class="bg-white  p-5 rounded-lg shadow w-full mb-3">
                                    <form action="{{ $project->path().'/tasks' }}" method="POST">
                                        @csrf
                                        <input type="text" placeholder="Add new task" name="body" class="w-full border-none">

                                    </form>

                                </div>
                            </div>
                            <div>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">
                                    {{ __('General notes') }}
                                </h2>
                                <!-- general notes -->
                                <form action="{{ $project->path() }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="notes" class="bg-white  p-5 rounded-lg shadow w-full  mb-3" style="min-height:200px"
                                        placeholder="Enter notes...">{{ $project->notes }}
                                    </textarea>
                                    <button type="submit" class="button">Save</button>

                                </form>
                                @if($errors->any())

                                <div class="filed mt-6 text-red-600">
                                    @foreach ($errors->all() as $error )
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="lg:w-1/4 px-3">
                            @include('components.card')
                         @include('projects.activity.card')
                        </div>
                    </div>
                </main>


            </div>
        </div>

    </body>

</x-app-layout>