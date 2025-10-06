<div class="bg-white  p-5 rounded-lg shadow flex flex-col mt-3" >
                            <h3 class="font-normal text-xl py-4  mb-3 -ml-5 border-l-4 border-blue-300 pl-4"> 
                               Invite a user
                            </h3>
 
                                <form action="{{ $project->path().'/invatations' }}" method="POSt" >
                                    @csrf
                                    <input type="email" name="email" class="border border-grey-200 rounded w-full py-2 px-3 mb-4"
                                    placeholder="Email address" >
                                    <button type="submit" class="text-xs px-4 py-2 bg-blue-200" >Invite</button>
                                </form>
                                 
                                 @include('errors',['bag'=>'invatations'])
                        
                        </div>