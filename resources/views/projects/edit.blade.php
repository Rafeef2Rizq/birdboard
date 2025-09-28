<x-app-layout>

    <body>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-slot name="header">
                    <div class="flex justify-between item-center ">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                            {{ __('Edit project') }}
                        </h2>

                    </div>
                </x-slot>
                @include('projects.form')
            </div>
        </div>

    </body>

</x-app-layout>