@extends('layouts.app')

@section('page_name', __('projects.project_details'))

@section('content')
    <style>
      .btn.btn-sm i {
        font-size: 1.2rem ;
      }
    </style>
    <div class="container-fluid py-4">
      <div class="row justify-content-around">
          <div class="col-12 col-xl-4 mb-4">
              <div class="card h-100">
                  <div class="card-header pb-0 p-3">
                      <div class="d-flex justify-content-between align-items-center">
                          <h6 class="mb-0">{{ __('app.owner_information') }}</h6>
                          <a href="{{ route('users.edit' , Auth::id()) }}">
                              <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" title="{{ __('app.edit_profile') }}"></i>
                          </a>
                      </div>
                  </div>
                  <div class="card-body p-3">
                      {{-- <p class="text-sm">
                          Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                      </p> --}}
                      <hr class="my-4">
                      <ul class="list-group list-group-flush {{ $textAlign }}">
                          <li class="list-group-item px-0 pt-0 text-sm"><strong>{{ __('app.full_name') }}:</strong> {{$user->name}} </li>
                          <li class="list-group-item px-0 text-sm"><strong>{{ __('app.email') }}:</strong>  {{$user->email}} </li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col-12 col-xl-4 mb-4">
              <div class="card h-100">
                  <div class="card-header pb-0 p-3">
                      <div class="d-flex justify-content-between align-items-center">
                          <h6 class="mb-0">{{ __('projects.project_information') }}</h6>
                          <a href="{{ route('projects.edit' , $project->id) }}">
                              <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" title="{{ __('projects.edit_project') }}"></i>
                          </a>
                      </div>
                  </div>
                  <div class="card-body p-3">
                      <p class="text-sm">
                          {{$project->description}}.
                      </p>
                      <hr class="my-4">
                      <ul class="list-group list-group-flush {{ $textAlign }}">
                          <li class="list-group-item px-0 pt-0 text-sm"><strong>{{ __('projects.project_name') }}:</strong> {{$project->name}} </li>
                          <li class="list-group-item px-0 text-sm"><strong>{{ __('projects.status') }}:</strong> {{$project->status}} </li>
                          <li class="list-group-item px-0 text-sm"><strong>{{ __('app.link') }}:</strong> {{$project->link}} </li>
                          <li class="list-group-item px-0 mt-5 text-sm"><strong></strong>
                            <img src="{{asset($project->qr_code)}}" alt="{{$project->name}}  QR CODE">

                          </li>

                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </div>
@endsection