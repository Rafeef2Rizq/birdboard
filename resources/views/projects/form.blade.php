   <form action="{{isset($project) ? $project->path() :'/projects'}}" method="POST" class="flex">
     @csrf
     @if (isset($project))
     @method('PATCH')
     @endif
     <div class="field">
       <x-input-label for="text" :value="__('Title')" />
       <x-text-input id="title" class="block mt-1 w-full" type="text" required name="title" value="{{isset($project) ? $project->title :'' }}" />


       <div class="field">
         <label for="">Description</label>
         <div class="control">
           <textarea name="description" class="textarea" id="" required>
           {{isset($project)? $project->description :''}}
           </textarea>
         </div>
         <div class="field">
           <div class="control">
             <button type="submit">{{ isset($project) ?'Update Project':'Create Project' }}</button>
             <a href="{{isset($project)? $project->path():'' }}">Cancel</a>
           </div>
         </div>
   </form>
   <div class="filed">

   </div>
   @if($errors->any())

   <div class="filed mt-6 text-red-600">
     @foreach ($errors->all() as $error )
     <li>{{ $error }}</li>
     @endforeach
   </div>
   @endif