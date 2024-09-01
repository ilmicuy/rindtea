@extends('layouts.home')

@section('content')
    <!-- Hero -->
    <section class="hero" id="home">
        @forelse ($hero_section as $hero)
            <main class="content">
                <h1><span>{{ $hero->span }}</span> {{ $hero->heading }}</h1>
                <p>
                    {{ $hero->subheading }}
                </p>
                <a href="#products" class="cta">Beli Sekarang</a>
            </main>
        @empty
            <p>Tidak ada data terbaru</p>
        @endforelse
    </section>

    <!-- About US -->
    <section class="about" id="about">
        <h2>Tentang <span>Kami</span></h2>
        <div class="row">
            @forelse ($abouts as $about)
                <div class="about-img">
                    <img src="{{ Storage::url($about->thumbnail) }}" alt="Tentang Kami" />
                </div>
                <div class="content">
                    <h3>{{ $about->name }}</h3>
                    @forelse ($about->keypoints as $keypoint)
                        <p>
                            {{ $keypoint->keypoint }}
                        </p>
                    @empty
                        <p>Tidak ada data terbaru</p>
                    @endforelse
                </div>
            @empty
                <p>Tidak ada data terbaru</p>
            @endforelse
        </div>
    </section>

    <!-- Menu -->
    <section class="menu" id="menu">
        <h2><span>Menu</span> Kami</h2>
        <p>
            Rind Tea menawarkan berbagai varian teh dari kulit buah yang unik dan
            kaya manfaat. Setiap produk terbuat dari kulit salak asli, memberikan
            rasa dan manfaat alami yang istimewa.
        </p>
        <div class="row">
            @forelse ($menus as $menu)
                <div class="menu-card">
                    <img class="menu-card-img" src="{{ Storage::url($menu->thumbnail) }}" alt="Teh Kulit Salak Celup" />
                    <h3 class="menu-card-title">- {{ $menu->name }} -</h3>
                    <p class="menu-card-price">Rp. {{ $menu->tagline }}</p>
                </div>
            @empty
                <p>Tidak ada data terbaru</p>
            @endforelse
        </div>
    </section>

    <!-- Produk -->
    <section class="products" id="products">
        <h2>Produk <span>Kami</span></h2>
        <p>
            Rind Tea menawarkan berbagai varian teh dari kulit buah yang unik dan
            kaya manfaat. Setiap produk terbuat dari kulit salak asli, memberikan
            rasa dan manfaat alami yang istimewa.
        </p>

        <div class="row">
            @forelse ($products as $product)
                <div class="product-card">
                    <div class="product-icons">
                        <a href="{{ route('shop-detail', $product->id) }}">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <use href="{{ asset('assets/img/feather-sprite.svg#shopping-cart') }}" />
                            </svg>
                        </a>
                        <a href="#" class="item-detail-button" id="{{ $product->id }}">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <use href="{{ asset('assets/img/feather-sprite.svg#eye') }}" />
                            </svg>
                        </a>
                    </div>
                    <div class="product-image">
                        <img src="{{ Storage::url($product->photos) }}" alt="">
                    </div>
                    <div class="product-content">
                        <h3>{{ $product->name }}</h3>
                        <div class="product-price">
                            <span class="rupiah" data-price="{{ $product->price }}"></span>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada data terbaru</p>
            @endforelse
        </div>
    </section>

    <!-- Modal Structure -->
    <div class="modal" id="item-detail-modal">
        <div class="modal-container">
            <a href="#" class="close-icon" data-dismiss="modal"><i data-feather="x"></i></a>
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <!-- Contact -->
    <section class="contact" id="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>
            Untuk informasi lebih lanjut atau pemesanan, hubungi kami di kolom Bawah ini. Kunjungi juga gerai kami di Jalan Parang Kusumo V, Desa/Kelurahan Tlogosari Kulon, Kec. Pedurungan, Kota Semarang, Provinsi Jawa Tengah, 50196
        </p>
        <div class="row">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.190591427269!2d110.45487167460662!3d-6.986816993014149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708cc449126cd7%3A0xdbbeca96fe6ac732!2sJl.%20Parang%20Kusumo%20V%2C%20Tlogosari%20Kulon%2C%20Kec.%20Pedurungan%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050196!5e0!3m2!1sid!2sid!4v1719762047373!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
            <form action="">
                <div class="input-group">
                    <i data-feather="user"></i>
                    <input type="text" placeholder="Nama" />
                </div>
                <div class="input-group">
                    <i data-feather="mail"></i>
                    <input type="email" placeholder="Email" />
                </div>
                <div class="input-group">
                    <i data-feather="phone"></i>
                    <input type="phone" placeholder="No Telepon" />
                </div>
                <button type="submit" class="btn">Kirim Pesan</button>
            </form>
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
                        $("#item-detail-modal").modal(
                            "show"); // Ensure this is after the content is loaded
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endpush
