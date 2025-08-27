@extends('frontend.component.main')

@section('main')
    <section class="about-area pt-80 pb-80">
        <div class="container text-center mt-5">
            <h2 class="text-success">🎉 Payment Successful!</h2>
            <p>Thank you for your purchase. Your order is being processed..</p>

            <a href="{{ route('home') }}" class="mt-3"><i class="fa fa-home me-3"></i>Back to Home</a>
        </div>
    </section>
@endsection