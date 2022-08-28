@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Shop Details') }}</div>
                    <div class="table-responsive" id="table_data">


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: "{{ url('/api/auth/shops/'.$shop_id) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': "Bearer " + "{{$token}}"
                },
                success: function (response) {
                    var html = '';
                    html += '<div class="card-body">'
                    html += ' <div class="card">'
                    html += '<div class="card-body">'
                    html += '<h5 class="card-title">' + response.data.shop_name + '</h5>'
                    html += '<span class="badge badge-primary" style="background: #0a53be">' + response.data.shop_category.name + '</span>'
                    html += '<p class="card-title">' + response.data.shop_benefits + '</p>'
                    html += '<span class="glyphicon glyphicon-map-marker">Penang</span><br><br>'
                    if (response.data.shop_following !== null) {
                        if (response.data.shop_following.follow==1) {
                            html += '<div class="float-left"><a href="javascript:void(0)" class="btn btn-primary pull-right follow" shop_id="' + response.data.id + '" follow_status="' + response.data.shop_following.follow + '">Following</a></div>'
                        }else{
                            html += '<div class="float-left"><a href="javascript:void(0)" class="btn btn-primary pull-right follow" shop_id="' + response.data.id + '" follow_status="0">Follow</a></div>'
                        }
                    } else {
                        html += '<div class="float-left"><a href="javascript:void(0)" class="btn btn-primary pull-right follow" shop_id="' + response.data.id + '" follow_status="0">Follow</a></div>'
                    }
                    html += '</div>'
                    html += '</div>'
                    html += '</div>';

                    $('#table_data').html(html);

                    $('.follow').unbind().bind('click', function () {
                        var shop_id = $(this).attr('shop_id');
                        var follow_status = $(this).attr('follow_status');
                        var $this = $(this);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Authorization': "Bearer " + "{{$token}}"
                            },
                            type: "POST",
                            dataType: "json",
                            url: "{{ url('/api/auth/shops-follow-unfollow')}}",
                            data: {'shop_id': shop_id, 'follow': follow_status},
                            success: function (data) {
                                toastr.success(data.message);

                                if (follow_status == 1) {
                                    $($this).text("Follow");
                                    $('.follow').attr('follow_status', 0)
                                } else {
                                    $($this).text("Following");
                                    $('.follow').attr('follow_status', 1)
                                }


                            },
                            error: function (err) {
                                toastr.error(data.message);
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush
