<section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:{{ klien('email') }}">{{ klien('email') }}</a>
        <i class="bi bi-phone-fill phone-icon"></i> {{ klien('phone') }}
      </div>
      <div class="social-links d-none d-md-block">
        <a href="{{ klien('twitter') }}" class="twitter" target="_blank"><i class="bi bi-twitter"></i></a>
        <a href="{{ klien('facebook') }}" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
        <a href="{{ klien('youtube') }}" class="youtube" target="_blank"><i class="bi bi-youtube"></i></a>
        <a href="{{ klien('instagram') }}" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
        {{-- <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a> --}}
      </div>
    </div>
  </section>
