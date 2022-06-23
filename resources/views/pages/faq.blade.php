@extends('layouts.faq')
@section('content')
<section class="faq">
    <h1>Frequently Asked Questions</h1>
    <div class="container">
        <p class="text-justify">
            Halo Customer, <em>yuk</em>, temukan semua jawaban dari pertanyaan
            kamu seputar Bandeng Suyudono selama Covid-19 berlangsung di FAQ ini.
            Jangan lupa untuk <strong>#staydirumahaja</strong> dan biarkan Tim
            Kami bekerja.
        </p>
        <p class="text-justify">
            Untuk saat ini Bandeng Suyudono hanya dapat dihubungi melalui email di
            Bandengsuyudono@gmail.com untuk jawaban yang kamu butuhkan. Namun,
            bantu Tim kami,<em> yuk</em>, dengan melihat beberapa ketentuan atau
            jawaban yang dapat kamu cek terlebih dahulu dibawah ini :
        </p>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Bagaimana jika pesanan yang saya <br />
                                    terima tidak lengkap?
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body text-justify">
                                Pesanan yang tidak lengkap biasanya terjadi saat produk yang
                                kamu pesan sedang tidak tersedia.Kami akan melakukan
                                pengembalian dana dengan jumlah sesuai produk yang tidak
                                tersedia.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bagaimana mengecek ketersediaan produk?
                                </button>
                            </h2>
                        </div>

                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body text-justify">
                                Ketersediaan produk dapat dicek melalui website Bandeng
                                Suyudono pada halaman detail produk.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Bagaimana jika pesanan yang saya terima rusak?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body text-justify">
                                Pesanan rusak yang disebabkan oleh pihak kami dapat
                                diberitahukan melalui email Bandengsuyudono@gmail.com.
                                <br />
                                <strong>Format Pelaporan :</strong> <br />
                                <ol>
                                    <li>Kirimkan informasi produk: Invoice & nomor order</li>
                                    <li>Sertakan Bukti foto</li>
                                    <li>Kirim melalui email</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Apa saja metode pembayaran yang bisa digunakan?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body text-justify">
                                <ol>
                                    <li>Gopay</li>
                                    <li>Virtual Account BCA</li>
                                    <li>Virtual Account Permata</li>
                                    <li>Dll</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Bagaimana saya melacak pesanan saya?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body text-justify">
                                Kamu akan dihubungi oleh kurir pada saat perjalanan
                                mengantar pesanan ke rumah kamu.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{url('/images/faq.png')}}" alt="" srcset="" />
            </div>
        </div>
        <h2 class="mt-4">Tidak Menemukan Jawaban Kamu di halaman FAQ ini?</h2>
        <p class="text-justify mt-3">
            Jika tidak menemukan jawaban kamu di FAQ ini, kamu dapat menghubungi
            Bandeng Suyudono untuk pertanyaan atau hal – hal lain yang ingin kamu
            sampaikan.
        </p>
        <p class="text-justify">
            E-mail : <strong>Bandengsuyudono@gmail.com</strong>
        </p>
        <p><em>Keep fit &amp; stay healthy, ya!</em></p>
    </div>
</section>
@endsection