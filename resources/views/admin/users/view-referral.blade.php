@extends('admin.layout.main')
@section('title', 'User View Referral List')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User /</span> Details</h4>
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                @if (isset($user_details->image))
                                    @php
                                        $imageSrc = Str::startsWith($user_details->image, 'https') ? $user_details->image : config('constants.USER_PROFILE_IMAGES_FULL_PATH') . $user_details->image;
                                    @endphp

                                    <a href="{{ $imageSrc }}" target="_blank">
                                        <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                             src="{{ $imageSrc }}"
                                             height="120" width="120" alt="User Profile" />
                                    </a>
                                @else
                                    @if($user_details->gender == 'male')
                                        <a href="{{ asset('assets/img/avatars/male/5.png') }}" target="_blank">
                                            <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                                 src="{{ asset('assets/img/avatars/male/5.png') }}" height="120"
                                                 width="120"
                                                 alt="User Profile"/>
                                        </a>
                                    @else
                                        <a href="{{ asset('assets/img/avatars/female/5.png') }}" target="_blank">
                                            <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                                 src="{{ asset('assets/img/avatars/female/5.png') }}" height="120"
                                                 width="120"
                                                 alt="User Profile"/>
                                        </a>
                                    @endif
                                @endif
                                <div class="user-info text-center">
                                    <h4>{{ $user_details->name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap my-2 py-3">
                            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                                <div class="avatar"  style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/teamnew.png') }}" alt="team">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$user_total_team}}</h4>
                                    <span>Total team</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                                <div class="avatar"  style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/point.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{number_format($user_total_earning,2)}} Points</h4>
                                    <span>Total Earning</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 gap-3">
                                <div class="avatar" style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/point.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$availableBalance}} Points</h4>
                                    <span>Available Balance</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 gap-3">
                                <div class="avatar" style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/withdrawnew.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$withdrawBalance}} Points</h4>
                                    <span>Withdrawal Balance</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="pt-3 border-top mt-3">Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Status:</span>
                                    @if ($user_details->status == 1)
                                        <span class="badge bg-label-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger">
                                            Inactive
                                        </span>
                                    @endif
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">My Pin:</span>
                                    <span>
                                         @if (isset($user_details->pin))
                                            {{ $user_details->pin }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Referral Code:</span>
                                    <span>
                                        @if (isset($user_details->referral_code))
                                            {{ $user_details->referral_code }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Date  of joining:</span>
                                    <span>
                                        @if (isset($user_details->created_at))
                                            {{date("d M, Y",strtotime($user_details->created_at)) }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <h5 class="pt-3 border-top mb-3">Personal Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Email:</span>
                                    <span>{{ $user_details->email }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Mobile No:</span>
                                    <span>{{ $user_details->mobile_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Gender:</span>
                                    <span>
                                        @if (isset($user_details->gender))
                                            {{ $user_details->gender }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">DOB:</span>
                                    <span>
                                        @if (isset($user_details->dob))
                                            {{ $user_details->dob }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Address:</span>
                                    <span>
                                        @if (isset($user_details->city))
                                            {{ $user_details->city }} , {{ $user_details->state }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
{{--                                <li class="mb-3">--}}
{{--                                    <span class="fw-semibold text-heading me-2">Pincode:</span>--}}
{{--                                    <span>--}}
{{--                                        @if (isset($user_details->pincode))--}}
{{--                                            {{ $user_details->pincode }}--}}
{{--                                        @else--}}
{{--                                            ---}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                        <h5 class="pt-3 border-top mb-3">Device Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Device Name:</span>
                                    <span>
                                        @if (isset($user_details->device_info->mobile_name))
                                            {{ $user_details->device_info->mobile_name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Model:</span>
                                    <span>
                                        @if (isset($user_details->device_info->device_model))
                                            {{ $user_details->device_info->device_model }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Version:</span>
                                    <span>
                                        @if (isset($user_details->device_info->device_version))
                                            {{ $user_details->device_info->device_version }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
{{--                                <li class="mb-3">--}}
{{--                                    <span class="fw-semibold text-heading me-2">IMEI No:</span>--}}
{{--                                    <span>--}}
{{--                                        @if (isset($user_details->device_info->imei_number))--}}
{{--                                            {{ $user_details->device_info->imei_number }}--}}
{{--                                        @else--}}
{{--                                            ---}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->

            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Tabs -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link" id="earning-segment"
                           href="{{ url('admin/users/view-detail/earning-history/') }}/{{ $user_details->id }}"><i
                                class="me-1"> <img loading="lazy" src="{{ asset('assets/img/dashboard/earnings.png') }}" width="30"
                                                   alt="earning"></i>Earning History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="withdrawal-segment"
                           href="{{ url('admin/users/view-detail/withdrawal-history/') }}/{{ $user_details->id }}"><i
                                class="me-1"><img loading="lazy" src="{{ asset('assets/img/dashboard/withdrawnew.png') }}" alt="withdraw"
                                                  width="30">
                            </i>Withdrawal History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="team-segment"
                           href="{{ url('admin/users/view-detail/view-team/') }}/{{ $user_details->id }}"><i
                                class="me-1"><img loading="lazy" src="{{ asset('assets/img/dashboard/teamnew.png') }}" alt="team"
                                                  width="30">
                            </i>View Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="referral-segment"
                           href="{{ url('admin/users/view-detail/view-referral/') }}/{{ $user_details->id }}"><i
                                class="me-1"><img loading="lazy" src="{{ asset('assets/img/dashboard/referral.png') }}" alt="referral"
                                                  width="30">
                            </i>View Referral</a>
                    </li>
                </ul>
                </ul>
                <!--/ User Tabs -->

                <!-- View Team table -->
                <div class="card mb-4">
                    <h5 class="card-header"> View Referral List</h5>
                    <div class="card-body">
                        <div class="row mb-4 referral-select">
                            <div class="col-6 mb-4 parent_element_level_1">
                                @if(!empty($referral_user_details))
                                    <h5>Referral Level 1</h5>
                                @else
                                    <h5>Referral Level Not Found</h5>
                                @endif
                                @if(isset($referral_user_details))
                                    <div class="form-group">
                                        <select id="referral_level_1"
                                                class="form-select form-select-lg referral_level_1"
                                                onchange="setAllReferral('referral_level_1', 1,this)">
                                            <option value="0">Plese select email</option>
                                            @foreach ($referral_user_details as $referral_user_detail)
                                                <option
                                                    @if ($referral_user_detail->matching_referrals_count < 1) disabled
                                                    @endif
                                                    value="{{ $referral_user_detail->pin }}">
                                                    {{ $referral_user_detail->email }} -
                                                    ({{ $referral_user_detail->matching_referrals_count }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /View Team table -->

            </div>
            <!--/ User Content -->
        </div>


    </div>
    <!-- / Content -->
    @push('script')
        <script>
            window.onload = function () {
                // Get the dropdown element
                @if(!empty($referral_user_details))
                var dropdown = document.getElementById("referral_level_1");
                // Set the selectedIndex property to -1 to unselect the option
                dropdown.selectedIndex = 0;
                @endif
            };

            let new_level, temp_level, new_option_element;

            function setAllReferral(referral_level, level, element) {
                let pin = $(element).val();
                if (new_level > level) {
                    temp_level = level;
                    for (let i = level + 1; i <= new_level; i++) {
                        // new_level = new_level - 1;
                        // level = level - 1;
                        $(`.parent_element_level_${i}`).remove();
                    }
                    new_level = temp_level;
                    level = temp_level;
                }

                if (!(pin == '' || pin == null || typeof pin == 'undefined')) {
                    getReferralUser(pin, referral_level, level);
                }
            }

            function drawTreeInSelect(response_data, pin, referral_level, level) {

                new_level = level + 1;

                $.each(response_data, function (key, value) {
                    let disable = "";
                    if (value.matching_referrals_count < 1) {
                        disable = "disabled";
                    }

                    new_option_element +=
                        `<option ${disable} value="${value.pin}">${value.email} - (${value.matching_referrals_count})</option>`;
                });

                let html = `<div class="col-6 mb-4 parent_element_level_${new_level}">
                            <h5>Referral Level ${new_level}</h5>
                                <div class="form-group">
                                    <select name="referral_level_${new_level}" class="form-select form-select-lg ${new_level}" form-control" id="referral_level_${new_level}"  onchange="setAllReferral('referral_level_${new_level}', ${new_level},this)">
                                        <option value="0">Plese select email</option>
                                        ${new_option_element}
                                      </select>
                                </div>
                            </div>`;


                new_option_element = null;
                $(".referral-select").append(html);

            }

            function getReferralUser(pin, referral_level, level) {
                $.ajax({
                    url: "{{ url('admin/user-view-referral/get-list') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    method: 'POST',
                    data: {
                        pin: pin,
                    },
                    success: function (response) {
                        let status = response.status;
                        let data = response.data;

                        if (status == 200 && response.data.length > 0) {
                            drawTreeInSelect(response.data, pin, referral_level, level);
                        } else {
                            console.log(response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        </script>
    @endpush
@endsection
