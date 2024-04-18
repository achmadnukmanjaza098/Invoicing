@extends('layouts.master')

@section('title')
    @lang('translation.Form_Repeater')
@endsection

@section('css')
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            User
        @endslot
        @slot('li_2')
            <button type="button" class="btn btn-danger waves-effect btn-label waves-light"
                onclick="window.location='{{ route('brand') }}'">
                <i class="bx bx-arrow-back label-icon me-1"></i>
                Back
            </button>
        @endslot
        @slot('title')
            User Form
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session()->has('success'))
                    <div class="card-header alert alert-success alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> Data update success</span>
                        </div>
                    </div>
                @elseif(session()->has('failed'))
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            <span class="alert-text"><strong>Failed!</strong> Data update failed</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="card-header alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="text-left">
                            <span class="alert-icon"><i class="ni ni-cross"></i></span>
                            @foreach ($errors->all() as $error)
                                <span class="alert-text"><strong>Failed!</strong> {{ $error }}</span> <br>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <form method="post" action="{{ route('updateBrand', $brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name">Name * :</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $brand->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">Phone * :</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ $brand->phone }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address * :</label>
                                            <div>
                                                <textarea class="form-control" rows="3" id="address" name="address">{{ $brand->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" id="active_hidden" name="active_hidden" value="true">
                                            <input class="form-check-input" type="checkbox" id="active" name="active"
                                                {{ $brand->active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="logo">Logo :</label>
                                            <input type="file" class="form-control" id="logo" name="logo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_rekening">Rekening * :</label>
                                            <div style="display: flex;">
                                                <div class="me-3" style="flex-grow: 1;">
                                                    <input type="text" class="form-control" id="no_rekening"
                                                        name="no_rekening" placeholder="Enter Rekening...">
                                                </div>
                                                <div>
                                                    <button type="button" id="add" class="btn btn-success">
                                                        <i class="bx bx-plus label-icon me-1"></i>
                                                        Add Rekening
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="table-responsive">
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80%">Rekening</th>
                                                            <th style="width: 20%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detail_rekenings">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" style="margin-top: 27px;">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="file-preview"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var rowCount = 0;

            function detailRekenings() {
                var detail_rekenings = {!! json_encode($brand->no_rekening) !!};
                detail_rekenings = JSON.parse(detail_rekenings);

                detail_rekenings.forEach((rekening) => {
                    var newRow = `
                        <tr id="row${rowCount}">
                            <td>
                                <input type="text" class="form-control table-input-height" name="detail_rekening[${rowCount}][rekening]" value="${rekening.rekening}" disabled>
                                <input type="hidden" name="detail_rekening[${rowCount}][rekening]" value="${rekening.rekening}">
                            </td>
                            <td>
                                <button type="button" name="remove" id="remove${rowCount}" class="btn btn-danger btn_remove"><i class="bx bxs-trash"></i></button>
                            </td>
                        </tr>`;
                    $('#detail_rekenings').append(newRow);
                    rowCount++
                });
            }

            function checkShowPreview() {
                var logo_link = '{{ $brand->image }}';

                if (logo_link) {
                    var previewButton = $(
                        '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton"><i class="mdi mdi-eye"></i> Preview</button>'
                    );
                    previewButton.insertAfter('#logo');
                    previewButton.click(function() {
                        $('#previewModal').modal('show');
                    });

                    preview = '<img src="/assets/uploads/logo/' + logo_link +
                        '" style="max-width: 100%; max-height: 600px;" />';
                    $('#file-preview').html(preview);
                }

            }

            function addRow(no_rekening) {
                var newRow = `
                    <tr id="row${rowCount}">
                        <td>
                            <input type="text" class="form-control table-input-height" name="detail_rekening[${rowCount}][rekening]" value="${no_rekening}" disabled>
                            <input type="hidden" name="detail_rekening[${rowCount}][rekening]" value="${no_rekening}">
                        </td>
                        <td>
                            <button type="button" name="remove" id="remove${rowCount}" class="btn btn-danger btn_remove"><i class="bx bxs-trash"></i></button>
                        </td>
                    </tr>`;
                $('#detail_rekenings').append(newRow);
                rowCount++;
            }

            function checkActive() {
                var active = '{{ $brand->active }}';
                $('#active_hidden').val(active == 1 ? 1 : 0);
            }

            checkShowPreview();
            detailRekenings();
            checkActive();

            $('#add').click(function() {
                var no_rekening = $("#no_rekening").val()

                addRow(no_rekening);
                $("#no_rekening").val("")
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id").replace('remove', '');
                $('#row' + button_id).remove();
            });

            $('#logo').change(function() {
                var file = this.files[0];
                var fileType = file.type;
                var fileName = file.name;

                if (fileType.includes('image/')) {
                    var fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        preview = '<img src="' + e.target.result +
                            '" style="max-width: 100%; max-height: 600px;" />';

                        $('#file-preview').html(preview);
                        $('#previewButton').remove();
                        var previewButton = $(
                            '<button type="button" class="btn btn-sm btn-outline-info waves-effect mt-2" id="previewButton"><i class="mdi mdi-eye"></i> Preview</button>'
                        );
                        previewButton.insertAfter('#logo');
                        previewButton.click(function() {
                            $('#previewModal').modal('show');
                        });
                    };
                    fileReader.readAsDataURL(file);
                } else {
                    $(this).val('');
                    alert('Invalid file type. Please upload an image');
                }
            });

            $('#active').change(function() {
                var activeValue = $(this).prop('checked');
                $('#active_hidden').val(activeValue ? 1 : 0);
            });
        });
    </script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
