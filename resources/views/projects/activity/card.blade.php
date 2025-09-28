   <div class="bg-white  p-5 rounded-lg shadow w-full mt-3">
     <ul class="text-xs list-reset">
       @foreach ($project->activity as $activity )
       <li>
         @include("projects.activity.$activity->description")
         <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null,true) }}</span>
     
       </li>
       @endforeach
     </ul>
   </div>