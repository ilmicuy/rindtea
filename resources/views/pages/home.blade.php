@extends('layouts.home')

@section('content')
    <!-- Hero -->
    <section class="bg-dark text-light py-5" id="home">
        @forelse ($hero_section as $hero)
            <div class="container">
                <div class="row min-vh-100 align-items-center">
                    <div class="col-lg-8 mx-auto text-center" data-aos="fade-up" data-aos-delay="100">
                        <h1 class="display-3 fw-bold mb-4">
                            <span class="text-primary">{{ $hero->span }}</span> {{ $hero->heading }}
                        </h1>
                        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200">
                            {{ $hero->subheading }}
                        </p>
                        <a href="#products" class="btn btn-primary btn-lg" data-aos="fade-up" data-aos-delay="300">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada data terbaru</p>
        @endforelse
    </section>

    <!-- About US -->
    <section class="py-5" id="about">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Tentang <span class="text-primary">Kami</span></h2>
            @forelse ($abouts as $about)
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="100">
                        <img src="{{ Storage::url($about->thumbnail) }}" alt="Tentang Kami" class="img-fluid rounded shadow" />
                    </div>
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                        <h3 class="mb-4">{{ $about->name }}</h3>
                        @forelse ($about->keypoints as $keypoint)
                            <p class="lead">
                                {{ $keypoint->keypoint }}
                            </p>
                        @empty
                            <p>Tidak ada data terbaru</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <p class="text-center">Tidak ada data terbaru</p>
            @endforelse
        </div>
    </section>

    <!-- Menu -->
    <section class="bg-light py-5" id="menu">
        <div class="container">
            <h2 class="text-center mb-3" data-aos="fade-up">
                <span class="text-primary">Menu</span> Kami
            </h2>
            <p class="text-center mb-5 lead" data-aos="fade-up" data-aos-delay="100">
                Rind Tea menawarkan berbagai varian teh dari kulit buah yang unik dan
                kaya manfaat. Setiap produk terbuat dari kulit salak asli, memberikan
                rasa dan manfaat alami yang istimewa.
            </p>
            <div class="row g-4">
                @forelse ($menus as $menu)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100 shadow-sm">
                            <img class="card-img-top" src="{{ Storage::url($menu->thumbnail) }}" alt="{{ $menu->name }}" />
                            <div class="card-body text-center">
                                <h3 class="card-title h5">- {{ $menu->name }} -</h3>
                                <p class="card-text text-primary fw-bold">Rp. {{ $menu->tagline }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada data terbaru</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Produk -->
    <section class="py-5" id="products">
        <div class="container">
            <h2 class="text-center mb-3" data-aos="fade-up">Produk <span class="text-primary">Kami</span></h2>
            <p class="text-center mb-5 lead" data-aos="fade-up" data-aos-delay="100">
                Rind Tea menawarkan berbagai varian teh dari kulit buah yang unik dan
                kaya manfaat. Setiap produk terbuat dari kulit salak asli, memberikan
                rasa dan manfaat alami yang istimewa.
            </p>

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ Storage::url($product->photos) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="position-absolute top-0 end-0 p-3">
                                    <a href="{{ route('shop-detail', $product->id) }}" class="btn btn-light btn-sm me-2">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                    <a href="#" class="btn btn-light btn-sm item-detail-button" id="{{ $product->id }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title h5">{{ $product->name }}</h3>
                                <p class="card-text text-primary fw-bold rupiah" data-price="{{ $product->price }}"></p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada data terbaru</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="item-detail-modal" tabindex="-1" aria-labelledby="itemDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-content">
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <section class="bg-light py-5" id="contact">
        <div class="container">
            <h2 class="text-center mb-3" data-aos="fade-up">
                <span class="text-primary">Kontak</span> Kami
            </h2>
            <p class="text-center mb-5 lead" data-aos="fade-up" data-aos-delay="100">
                Untuk informasi lebih lanjut atau pemesanan, hubungi kami di kolom Bawah ini. Kunjungi juga gerai kami di Jalan Parang Kusumo V, Desa/Kelurahan Tlogosari Kulon, Kec. Pedurungan, Kota Semarang, Provinsi Jawa Tengah, 50196
            </p>
            <div class="row g-4">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
                    <div id="contact-map" style="width: 100%; height: 400px; border-radius: 8px;"></div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <form id="contactForm">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="name" placeholder="Nama" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Email" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" name="phone" placeholder="No Telepon" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                <textarea class="form-control" name="message" rows="4" placeholder="Pesan" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            // Scroll spy functionality
            function updateActiveSection() {
                const sections = $('section[id]');  // Get all sections with IDs
                let currentSection = '';

                sections.each(function() {
                    const sectionTop = $(this).offset().top;
                    const sectionBottom = sectionTop + $(this).outerHeight();
                    const scrollPosition = $(window).scrollTop();
                    const buffer = 200; // Adjust this value to change when the section becomes active

                    // Check if we're scrolled into the section (accounting for navbar height)
                    if (scrollPosition >= sectionTop - buffer &&
                        scrollPosition < sectionBottom - buffer) {
                        currentSection = $(this).attr('id');
                        return false; // Break the loop
                    }
                });

                // Update navbar links active state
                $('.nav-scroll').removeClass('active');
                if (currentSection) {
                    $(`.nav-scroll[data-section="${currentSection}"]`).addClass('active');
                } else if ($(window).scrollTop() <= 100) {
                    // If at the top of the page, activate home
                    $('.nav-scroll[data-section="home"]').addClass('active');
                }
            }

            // Throttle scroll event for better performance
            let scrollTimeout;
            $(window).on('scroll', function() {
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }
                scrollTimeout = setTimeout(function() {
                    updateActiveSection();
                }, 50);
            });

            // Update on page load
            updateActiveSection();

            // Update on any dynamic content changes
            $(window).on('load', function() {
                updateActiveSection();
            });

            // Smooth scroll for anchor links
            $('.nav-scroll').on('click', function(e) {
                if (this.hash !== "") {
                    e.preventDefault();
                    const hash = this.hash;
                    const target = $(hash);

                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - 80
                        }, 800, function() {
                            updateActiveSection();
                        });
                    }
                }
            });

            // Initialize map
            var map = L.map('contact-map').setView([-6.986817, 110.454872], 16);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add marker for store location
            var storeMarker = L.marker([-6.986817, 110.454872]).addTo(map);

            // Add popup with store information
            storeMarker.bindPopup(`
                <strong>Rind Tea</strong><br>
                Jl. Parang Kusumo V<br>
                Tlogosari Kulon, Kec. Pedurungan<br>
                Kota Semarang, Jawa Tengah 50196
            `).openPopup();

            // Existing contact form code
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("contact.submit") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message
                            });
                            $('#contactForm')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan! Silakan coba lagi.'
                        });
                    }
                });
            });

            // Existing product detail code
            $(document).on('click', '.item-detail-button', function(e) {
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    type: 'POST',
                    url: '/product/detail',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    success: function(respond) {
                        $("#modal-content").html(respond);
                        var modal = new bootstrap.Modal(document.getElementById('item-detail-modal'));
                        modal.show();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endpush
