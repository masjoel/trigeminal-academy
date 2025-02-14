@extends('frontend.layout.main')
@section('style')
@endsection
@section('title', $title)
@section('main')
<section class="places-wrap mt-5">
    <div class="page-title page-title--small align-left">
      <div class="container">
        <div class="page-title__content">
          <h1 class="page-title__name">{{ $title }}</h1>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
          <h3>Terimakasih </h3>
        </div>
      </div>
    </div>
</section>
@endsection