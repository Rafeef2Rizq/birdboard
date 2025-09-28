<x-app-layout>

    <body>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

                <div class="flex item-center mb-3 ">
                    <x-slot  name="header"  >
                       <div class="flex justify-between item-center  ">
                         <h2 class="font-semibold text-xl text-blue-400 leading-tight ">
                            {{ __('My projects') }}
                        </h2>
                        <a href="/projects/create"
                         class="bg-blue text-black no-underline rounded-lg text-sm py-2 px-5 shadow">Add project</a>
                       </div>
                    </x-slot>
                </div>
                <div class="lg:flex lg:flex-wrap -mx-3">
                    @forelse($projects as $project)
                    <div class="lg:w-1/3 px-3 pb-6">
                        @include('components.card')
                    </div>
                    @empty
                    <div>No projects available</div>
                    @endforelse
                </div>

            </div>
        </div>

    </body>
</x-app-layout>