<form action="{{ isset($project) ? $project->path() : '/projects' }}" method="POST" class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    @csrf
    @if (isset($project))
        @method('PATCH')
    @endif

    <!-- Title Input -->
    <div class="mb-6">
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input 
            id="title" 
            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" 
            type="text" 
            required 
            name="title" 
            value="{{ isset($project) ? $project->title : '' }}" />
    </div>

    <!-- Description Input -->
    <div class="mb-6">
        <x-input-label for="description" :value="__('Description')" />
        <textarea 
            name="description" 
            id="description" 
            rows="4" 
            required 
            class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">{{ isset($project) ? $project->description : '' }}</textarea>
    </div>

    <!-- Submit and Cancel Buttons -->
    <div class="flex justify-between items-center mt-6">
        <button type="submit" class="px-6 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
            {{ isset($project) ? 'Update Project' : 'Create Project' }}
        </button>
        <a href="/" class="text-red-600 hover:text-red-800">Cancel</a>
    </div>

    <!-- Display Errors -->
    @if ($errors->any())
        <div class="mt-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
