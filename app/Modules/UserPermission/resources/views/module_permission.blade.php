 @foreach($modules as $module)
 <div class="d-flex mt-3 ">
     <input type="checkbox" value="{{ $module->id }}" name="modules[]" {{ isset($module_permission[$module->id]) ? 'checked' : '' }} class="form-check-input m-2  border  border-light-primary ">
     <div class="w-100">
         <button class="btn btn-primary w-100 text-start d-flex justify-content-start align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $module->slug }}" aria-expanded="false" aria-controls="{{ $module->slug }}">
             {{ $module->title }}
         </button>
         <div class="collapse mt-2 {{ isset($module_permission[$module->id]) ? 'show' : '' }}" id="{{ $module->slug }}">
             <div class="card card-body d-flex flex-row flex-wrap p-2">
                 @foreach($module->permissions as $permission)
                 <div class="d-flex justify-content-start align-items-center">
                     <input type="checkbox" value="{{ $permission->id }}" name="permissions[]" {{ isset($role_permissions[$permission->id]) ? 'checked' : '' }} class="form-check-input m-2  border  border-light-primary "> {{ $permission->title }}
                 </div>
                 @endforeach
             </div>
         </div>
     </div>
 </div>
 @endforeach

 <div class=" row justify-content-center pt-3">
     <button class=" col-md-4 btn btn-primary">Submit</button>
 </div>