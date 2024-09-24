@extends('layouts.layout_application')
@section('PageTitle', "API Ayarları")

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
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">@ API Ayarları Güncelleme</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('Dashboards.Administrators') }}" type="button" class="btn btn-sm btn-light-danger">Geri Dön</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('ApiSettings.Update') }}" id="updateForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12" id="input_group-xml_address">
                                <label for="input-xml_address" class="form-label required text-white mb-2">@ XML Adresi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-xml_address') is-invalid error-input @enderror fs-7" id="input-xml_address" name="input-xml_address" placeholder="XML Adresi Giriniz" value="{{ old('input-xml_address', settings()->group('api_settings')->get('xml_address'))  }}"/>
                                    @if ($errors->has('input-xml_address'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-xml_address') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6" id="input_group-store_code">
                                <label for="input-store_code" class="form-label required text-white mb-2">@ KMK Mağaza Kodu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-store_code') is-invalid error-input @enderror fs-7" id="input-store_code" name="input-store_code" placeholder="KMK Mağaza Kodu Giriniz" value="{{ old('input-store_code', settings()->group('api_settings')->get('store_code')) }}"/>
                                    @if ($errors->has('input-store_code'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-store_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6" id="input_group-store_name">
                                <label for="input-store_name" class="form-label required text-white mb-2">@ KMK Mağaza Adı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-store_name') is-invalid error-input @enderror fs-7" id="input-store_name" name="input-store_name" placeholder="KMK Mağaza Adı Giriniz" value="{{ old('input-store_name', settings()->group('api_settings')->get('store_name')) }}"/>
                                    @if ($errors->has('input-store_name'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-store_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6" id="input_group-category_name">
                                <label for="input-category_name" class="form-label required text-white mb-2">@ KMK Kategori Adı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-category_name') is-invalid error-input @enderror fs-7" id="input-category_name" name="input-category_name" placeholder="KMK Kategori Adı Giriniz" value="{{ old('input-category_name', settings()->group('api_settings')->get('category_name')) }}"/>
                                    @if ($errors->has('input-category_name'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-category_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6" id="input_group-brand_name">
                                <label for="input-brand_name" class="form-label required text-white mb-2">@ KMK Marka Adı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-brand_name') is-invalid error-input @enderror fs-7" id="input-brand_name" name="input-brand_name" placeholder="KMK Marka Adı Giriniz" value="{{ old('input-brand_name', settings()->group('api_settings')->get('brand_name')) }}"/>
                                    @if ($errors->has('input-brand_name'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-brand_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6" id="input_group-store_api_key">
                                <label for="input-store_api_key" class="form-label required text-white mb-2">@ KMK Mağaza API Adresi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-store_api_key') is-invalid error-input @enderror fs-7" id="input-store_api_key" name="input-store_api_key" placeholder="KMK Mağaza API Adresi Giriniz" value="{{ old('input-store_api_key', settings()->group('api_settings')->get('store_api_key')) }}"/>
                                    @if ($errors->has('input-store_api_key'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-store_api_key') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6" id="input_group-store_api_password">
                                <label for="input-store_api_password" class="form-label required text-white mb-2">@ KMK Mağaza API Parolası</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-store_api_password') is-invalid error-input @enderror fs-7" id="input-store_api_password" name="input-store_api_password" placeholder="KMK Mağaza API Parolası Giriniz" value="{{ old('input-store_api_password', settings()->group('api_settings')->get('store_api_password')) }}"/>
                                    @if ($errors->has('input-store_api_password'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-store_api_password') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6" id="input_group-api_key">
                                <label for="input-api_key" class="form-label required text-white mb-2">@ KMK API Adresi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-api_key') is-invalid error-input @enderror fs-7" id="input-api_key" name="input-api_key" placeholder="KMK API Adresi Giriniz" value="{{ old('input-api_key', settings()->group('api_settings')->get('api_key')) }}"/>
                                    @if ($errors->has('input-api_key'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-api_key') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6" id="input_group-api_password">
                                <label for="input-api_password" class="form-label required text-white mb-2">@ KMK API Parolası</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('input-api_password') is-invalid error-input @enderror fs-7" id="input-api_password" name="input-api_password" placeholder="KMK API Parolası Giriniz" value="{{ old('input-api_password', settings()->group('api_settings')->get('api_password')) }}"/>
                                    @if ($errors->has('input-api_password'))
                                        <div class="invalid-feedback">
                                            @ {{ $errors->first('input-api_password') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-warning me-2" id="updateButton" name="updateButton" form="updateForm">
                        <span class="indicator-label">Güncelle</span>
                        <span class="indicator-progress">Lütfen Bekleyiniz...<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="apiTestButton" name="apiTestButton">
                        <span class="indicator-label">Bağlantı Testi</span>
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
        const xmlAddress = $('#input-xml_address').val();
        const apiKey = $('#input-api_key').val();
        const apiPassword = $('#input-api_password').val();

        var updateButton = document.querySelector("#updateButton");
        var apiTestButton = document.querySelector("#apiTestButton");

        updateButton.addEventListener("click", function () {
            updateButton.setAttribute("data-kt-indicator", "on");
        });

        apiTestButton.addEventListener("click", function () {
            apiTestButton.setAttribute("data-kt-indicator", "on");
            Swal.fire({
                title: 'API Bağlantı Testi',
                html: `Girmiş olduğunuz bilgiler kullanılarak API Bağlantı Testi gerçekleştirilecektir. Devam etmek istiyor musunuz?`,
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
                apiTestButton.setAttribute("data-kt-indicator", "off");
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/ajax/apitest',
                        type: 'POST',
                        data: {
                            "apiKey": apiKey,
                            "apiPassword": apiPassword,
                            "xmlAddress": xmlAddress,
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data){
                            if(data.status == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'API Testi Başarılı',
                                    html: `Girmiş olduğunuz bilgiler ile gerçekleştirilen API Bağlantı Testi başarı ile tamamlandı.`,
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
                                    title: 'API Testi Başarısız',
                                    html: `Girmiş olduğunuz bilgiler ile gerçekleştirilen API Bağlantı Testi başarısız oldu. Lütfen girmiş olduğunuz bilgileri kontrol ediniz.`,
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
