@extends('layouts.layout_application')
@section('PageTitle', "KMK Veri Güncelleme")

@section('PageVendorCSS')

@endsection

@section('PageCustomCSS')

@endsection

@section('Breadcrumb')
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('Dashboards.Administrators') }}" class="text-muted text-hover-primary">Oasis_Books_Data_Fetcher_v2.0</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 mb-5 mt-2">
        <div class="col-md-4">
            @if (session('result'))
                @include('components.jsonalert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card card-flush h-xl-100">
                    <!--begin::Heading-->
                    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-100px" style="background-image:url({{ asset('assets/media/svg/shapes/abstract-2-dark.svg') }})" data-bs-theme="light">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column text-white pt-5">
                            <span class="card-label fw-bold text-primary mb-2">{{ settings()->group('api_settings')->get('store_name') }}</span>
                            <div class="fs-6">
                            <span class="position-relative d-inline-block">
							    <span class="fw-bold d-block mb-1 text-warning">Oasis_Books_Data_Fetcher_v2.0</span>
                            </span>
                            </div>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Stats-->
                        <div class="position-relative">
                            <!--begin::Row-->
                            <div class="row g-3 g-lg-6">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-4 lh-1 ls-n1 mb-1">XML Kitap Sayısı</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-success fw-semibold fs-6">{{ $bookCount }}</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-4 lh-1 ls-n1 mb-1" id="totalPassiveDataCount">Mağaza Kitap Sayısı</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-danger fw-semibold fs-6">{{ $kmkBookCount }}</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                </div>

        </div>
        <!--begin::Col-->
        <div class="col-md-8">
            <!--begin::Engage widget 4-->
            <div class="card h-xl-100 shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-primary fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">@ KMK Ürün ve Stok Güncelleme</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <!--begin::Body-->
                <div class="card-body d-flex ps-xl-10">
                    <!--begin::Wrapper-->
                    <div class="m-0" style="width: 100%">
                        <!--begin::Title-->
                        <div class="position-relative z-index-2 card-label fw-bold text-primary mb-7">
                            <h4 class="mb-4"></h4>
                            <h6 class="mb-1">- Gerçekleştireceğiniz aktarımın güncel olabilmesi için bu işleme başlamadan önce <a href="{{ route('XMLFetch.Index') }}" class="text-primary">XML Aktarımı</a> modülünden güncel kitapları çekmelisiniz. </h6>
                            <h6 class="mb-1">- XML ürün stok bilgileri KMK tarafındaki ürünler ile ile eşleştirilecektir.</h6>
                            <h6 class="mb-1 text-danger">* Bu işlem geri alınamaz.</h6>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--begin::Wrapper-->
                    <!--begin::Illustration-->
                    <img src="{{ asset('assets/media/illustrations/sigma-1/17-dark.png') }}" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" />
                    <!--end::Illustration-->
                </div>
                <!--end::Body-->
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-success" id="updateKMKButton" name="updateKMKButton">
                        <span class="indicator-label">Güncellemeyi Başlat</span>
                        <span class="indicator-progress">Lütfen Bekleyiniz...<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
            <!--end::Engage widget 4-->
        </div>
        <!--end::Col-->
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script type="text/javascript">
        var updateKMKButton = document.querySelector("#updateKMKButton");

        updateKMKButton.addEventListener("click", function () {
            updateKMKButton.setAttribute("data-kt-indicator", "on");
            Swal.fire({
                title: 'KMK Ürün ve Stok Güncelleme Onayı',
                html: `Sistemde yer alan kitaplara ait stok bilgileri güncellenecektir. XML'de yeni kitap olması durumunda KMK tarafına yeni kitap eklenecektir. </br><span class="text-warning fw-bold">Bu işlem uzun sürebilir ve geri alınamaz.</span><br>Devam etmek istiyor musunuz?`,
                icon: "info",
                buttonsStyling: false,
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonText: "Tamam",
                cancelButtonText: 'Geri Dön',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger',
                    title: 'text-white'
                }
            }).then(function (result) {
                updateKMKButton.setAttribute("data-kt-indicator", "off");
                if (result.isConfirmed) {
                    let timerInterval;
                    clearInterval(timerInterval);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Güncelleme Başladı!',
                        html: `Aktarım işlemi tamamlanana kadar lütfen bu sayfayı kapatmayınız. Aktarım tamamlandığında sizi bilgilendireceğiz.</br></br><b></b>`,
                        timer: 2500000,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Math.floor(Swal.getTimerLeft()/1000) % 60}`+ " Saniye Kaldı!";
                            }, 100);
                        },
                        timerProgressBar: true,
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            title: 'text-white'
                        }
                    });
                    $.ajax({
                        url: '/ajax/dataupdater',
                        type: 'POST',
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data){
                            if(data.status == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Güncelleme Başarılı',
                                    html: 'Güncelleme işlemi başarı ile tamamlanarak KMK Mağazası\'nda yer alan kitapların stok bilgisi değiştirildi ve sisteme yeni kitaplar eklendi.',
                                    confirmButtonText: "Tamam",
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        title: 'text-white'
                                    }
                                })
                            } else if(data.status == "Failed") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Güncelleme Başarısız',
                                    html: `Girmiş olduğunuz bilgiler ile gerçekleştirilen ürün güncellemesi başarısız oldu.`,
                                    confirmButtonText: "Tamam",
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        title: 'text-white'
                                    }
                                })
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection

@section('PageModals')

@endsection
