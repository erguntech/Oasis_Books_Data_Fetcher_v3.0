@extends('layouts.layout_application')
@section('PageTitle', "XML Aktarımı")

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
        <div class="col-md-12">
            @if (session('result'))
                @include('components.jsonalert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card card-dashed">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">@ XML Aktarım Tablosu</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('Dashboards.Administrators') }}" type="button" class="btn btn-sm btn-light-danger">Geri Dön</a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="updateForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12" id="input_group-xml_address">
                                <label for="input-xml_address" class="form-label required text-white mb-2">@ XML Adresi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-xml_address') is-invalid error-input @enderror fs-7" id="input-xml_address" name="input-xml_address" placeholder="XML Adresi Giriniz" value="{{ settings()->group('api_settings')->get('xml_address') }}" disabled/>
                                    @if ($errors->has('input-xml_address'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-xml_address') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-warning me-2" id="updateXMLButton" name="updateXMLButton">
                        <span class="indicator-label">Güncelle</span>
                        <span class="indicator-progress">Lütfen Bekleyiniz...<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script type="text/javascript">
        var updateXMLButton = document.querySelector("#updateXMLButton");

        updateXMLButton.addEventListener("click", function () {
            updateXMLButton.setAttribute("data-kt-indicator", "on");
            Swal.fire({
                title: 'XML Aktarım Onayı',
                html: `API Ayarları kısmında girmiş olduğunuz XML\'de yer alan tüm kitaplar veritabanına aktarılacaktır. <span class="text-warning fw-bold">Bu işlem uzun sürebilir.</span><br>Devam etmek istiyor musunuz?`,
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
                updateXMLButton.setAttribute("data-kt-indicator", "off");
                if (result.isConfirmed) {
                    let timerInterval;
                    clearInterval(timerInterval);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aktarım Başladı!',
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
                        url: '/ajax/xmlfetch',
                        type: 'POST',
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data){
                            if(data.status == "XMLEmpty") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'XML Adresi Boş',
                                    html: `Lütfen API Ayarları kısmında girmiş olduğunuz XML Adresi'ni kontrol ediniz.`,
                                    confirmButtonText: "Tamam",
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        title: 'text-white'
                                    }
                                })
                            } else if(data.status == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'XML Aktarımı Başarılı',
                                    html: 'XML Aktarımı başarı ile tamamlanarak veritabanına toplamda <span class="text-success fw-bold">' + data.bookCount.toLocaleString('tr-TR') + '</span> adet kitap aktarıldı.',
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
                                    title: 'XML Aktarımı Başarısız',
                                    html: `Girmiş olduğunuz bilgiler ile gerçekleştirilen XML Aktarımı başarısız oldu.`,
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
