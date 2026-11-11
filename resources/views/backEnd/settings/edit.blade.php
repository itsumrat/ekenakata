@extends('backEnd.layouts.master')
@section('title','General Setting Update')
@section('css')
<link href="{{asset('backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('settings.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">General Setting Update</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('settings.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$edit_data->id}}">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $edit_data->name}}" id="name" required="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					      <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="meta_description" class="form-label">Meta Description *</label>
                            <input type="text" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" value="{{ $edit_data->meta_description}}" id="meta_description" required="">
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					
										      <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="meta_keyword" class="form-label">Meta Keyword *</label>
                            <input type="text" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword" value="{{ $edit_data->meta_keyword}}" id="meta_keyword" required="">
                            @error('meta_keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					
					
					
										
										      <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="play_store" class="form-label">Google Play Store Link *</label>
                            <input type="text" class="form-control @error('play_store') is-invalid @enderror" name="play_store" value="{{ $edit_data->play_store}}" id="play_store" required="">
                            @error('play_store')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					
					
					                    <!-- col-end -->
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="og_baner" class="form-label">OG Baner *</label>
                            <input type="file" class="form-control @error('og_baner') is-invalid @enderror" name="og_baner" value="{{ old('og_baner') }}"  id="og_baner" >
                            <img src="{{asset($edit_data->og_baner)}}" class="edit-image" alt="">
                            @error('og_baner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					
                    <!-- col-end -->
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="white_logo" class="form-label">White Logo *</label>
                            <input type="file" class="form-control @error('white_logo') is-invalid @enderror" name="white_logo" value="{{ old('white_logo') }}"  id="white_logo" >
                            <img src="{{asset($edit_data->white_logo)}}" class="edit-image" alt="">
                            @error('white_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="dark_logo" class="form-label">Dark Logo *</label>
                            <input type="file" class="form-control @error('dark_logo') is-invalid @enderror" name="dark_logo" value="{{ old('dark_logo') }}"  id="dark_logo" >
                            <img src="{{asset($edit_data->dark_logo)}}" class="edit-image" alt="">
                            @error('dark_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="favicon" class="form-label">Favicon Logo *</label>
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" value="{{ old('favicon') }}"  id="favicon" >
                            <img src="{{asset($edit_data->favicon)}}" class="edit-image" alt="">
                            @error('favicon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
                              <span class="slider round"></span>
                            </label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>

                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection


@section('script')
<script src="{{asset('backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });
</script>
@endsection