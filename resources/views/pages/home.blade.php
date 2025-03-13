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
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.190591427269!2d110.45487167460662!3d-6.986816993014149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708cc449126cd7%3A0xdbbeca96fe6ac732!2sJl.%20Parang%20Kusumo%20V%2C%20Tlogosari%20Kulon%2C%20Kec.%20Pedurungan%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050196!5e0!3m2!1sid!2sid!4v1719762047373!5m2!1sid!2sid"
                        class="w-100 h-100 rounded" style="min-height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <form>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Nama" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Email" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" placeholder="No Telepon" />
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
