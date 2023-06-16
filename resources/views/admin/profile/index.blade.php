@extends('layouts.admin')

@section('content')


<style>
    .select2-container{width: 100% !important}
    .switch {
      position: relative;
      display: inline-block;
      width: 35px;
      height: 22px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 15px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: #1bb99a;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px #1bb99a;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(13px);
      -ms-transform: translateX(13px);
      transform: translateX(13px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }
    
    .slider.round:before {
      border-radius: 50%;
    }

    /* label.error {display:none !important;} */
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('admin.franchises.list') }}">Franchise</a></li> --}}
                    <li class="breadcrumb-item active">Profile </li>
                </ol>
            </div>
            <h4 class="page-title">Profile-{{ $user_details->username }} </h4>
        </div>
    </div>
</div>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="personal_info_tab" data-toggle="tab" href="#personal_info" role="tab" aria-controls="personal_info" aria-selected="true" >Personal Info</a>
    </li>

    <li class="nav-item" role="presentation">
        {{-- <a class="nav-link" id="change_pass_tab" data-toggle="tab" href="#change_pass" role="tab" aria-controls="change_pass" aria-selected="true" >Change Password</a>
    </li> --}}
</ul>

<div class="tab-content pt-0" id="myTabContent">
    <div class="tab-pane fade show active" id="personal_info" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td style="vertical-align: middle;padding-top: 0;padding-bottom: 0;"><input type="text" class="form-control border-0" disabled name="name" id="name" data-ov="{{ $user_details->name }}" value="{{ $user_details->name }}"></td>
                            </tr>
                            <tr>
                                <th>NIC</th>
                                <td style="vertical-align: middle;padding-top: 0;padding-bottom: 0;"><input type="text" class="form-control border-0" disabled name="nic" id="nic" data-ov="{{ $user_details->nic }}" value="{{ $user_details->nic }}"></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td style="vertical-align: middle;padding-top: 0;padding-bottom: 0;">
                                    <div id="mobile_code">
                                        <input type="text" class="form-control border-0" disabled name="mobile" id="mobile" data-ov="{{ substr($user_details->mobile,2) }}"  value="{{ substr($user_details->mobile,2) }}">
                                        <div class="mobile_err w-100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td style="vertical-align: middle;padding-top: 0;padding-bottom: 0;"><input type="text" class="form-control border-0" disabled name="address" id="address" data-ov="{{ $user_details->address }}" value="{{ $user_details->address }}"></td>
                            </tr>
                            <tr>
                                <th>Credit Limit</th>
                                <td style="vertical-align: middle;padding-top: 0;padding-bottom: 0;"><input type="text" class="form-control border-0" disabled name="credit_limit" id="credit_limit" data-ov="{{ $user_details->credit_limit }}" value="{{ $user_details->credit_limit }}"></td>
                            </tr>
                            
                        </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="tab-pane fade" id="change_pass" role="tabpanel">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form action="{{ route('admin.profiles.update_password') }}" class="ajaxForm" method="post" enctype="multipart/form-data" novalidate id="change_pass_form">
                        @csrf
                        <div class="row">
                            <div class="form-group  col-md-6">
                                <label for="password">Connection Password<span class="text-danger">*</span></label>
                                <div class="input-group mpass">
                                    <input type="password" name="password" placeholder="Enter password" minlength="6" maxlength="12"  value="" class="form-control" id="password" ><span class="input-group-text pass-show"><a href="javascript:void(0)"><i class="fa fa-eye"></i></a></span><span class="input-group-text pass-hide d-none"><a href="javascript:void(0)"><i class="fa fa-eye-slash"></i></a></span>
                                </div>
                                
                            </div>
        
                            <div class="form-group col-md-6">
                                <label for="password_confirmation ">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" placeholder="Confirm password" minlength="6" maxlength="12" value="" class="form-control" id="password_confirmation" >
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="franchise_id" value="{{ $user_details->hashid }}">
                                <input type="submit" class="btn btn-primary float-right"value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@endsection
@section('page-scripts')
@include('admin.partials.datatable', ['load_swtichery' => true])

<script>
    //which tab to open when page get reload
    var tabs_local_storage = localStorage.getItem('tab');
    // alert(tabs_local_storage);
    if(tabs_local_storage == null){
        tabs_local_storage = localStorage.setItem('tab','service_details');
    }
    $('#personal_info_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','personal_info_tab');
    });
    $('#change_pass_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','change_pass_tab');
    });
    $('#doc_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','doc_tab');
    });
    $('#record_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','record');
    });
    $('#service_details_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','service_details');
    });
    $('#packages_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','packages_tab');
    });
    $('#user_packages_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','user_packages_tab');
    });
    $('#user_payments_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','user_payments_tab');
    });
    $('#login_fail_tab').click(function(){
        tabs_local_storage = localStorage.setItem('tab','login_fail_tab');
    });
    

    if(tabs_local_storage == 'personal_info_tab'){
        $('#personal_info_tab').click();
    }else if(tabs_local_storage == 'change_pass_tab'){
        $('#change_pass_tab').click();
    }else if(tabs_local_storage == 'doc_tab'){
        $('#doc_tab').click();
    }else if(tabs_local_storage == 'record'){
        $('#record_tab').click();
    }else if(tabs_local_storage == 'service_details'){
        $('#service_details_tab').click();
    }else if(tabs_local_storage == 'packages_tab'){
        $('#packages_tab').click();
    }else if(tabs_local_storage == 'user_packages_tab'){
        $('#user_packages_tab').click();
    }else if(tabs_local_storage == 'user_payments_tab'){
        $('#user_payments_tab').click();
    }else if(tabs_local_storage == 'login_fail_tab'){
        $('#login_fail_tab').click();
    }


    //display password
    $('.pass-show').click(function(e){
        e.preventDefault();
        $('#password').attr('type','text');
        $('#password_confirmation').attr('type','text');
        $(this).addClass('d-none');
        $('.pass-hide').removeClass('d-none');
    });
    //hide pass
    $('.pass-hide').click(function(e){
        e.preventDefault();
        $('#password').attr('type','password');
        $('#password_confirmation').attr('type','password')
        $(this).addClass('d-none');
        $('.pass-show').removeClass('d-none');
    });

    

    //change password form validation
    $('#change_pass_form').validate({
        rules:{
            password:{
                required:true,
                minlength:6,
                maxlength:12
            },
            password_confirmation:{
                required:true,
                minlength:6,
                maxlength:12,
                equalTo:'#password',
            }
        },
        highlight:function(element){
            $(element).addClass('is-invalid');        
        },
        unhighlight:function(element){
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
    });

    $('#change_pass_form input[type="password"]').blur(function(){
        var id = $(this).attr('id');
        var validator = $('#change_pass_form').validate();
        validator.element('#'+id);
    });        
        
    var admin_id = "{{ @$user_details->hashid }}";

    $(document).ready(function(){
        var table = $('#payment_table').DataTable({
                    processing: true, 
                    serverSide: true,
                    "order": [[ 0, "desc" ]],
                    "pageLength": 300,
                    "lengthMenu": [300,500,1000,1500],
                    "dom": '<"top"ifl<"clear">>rt<"bottom"ip<"clear">>',

                    ajax:{
                        url : "{{ route('admin.profiles.index') }}",
                        data:function(d){
                                    d.username        = $('#username').val(),
                                    d.added_by        = $('#added_by').val(),
                                    d.from_date       = $('#from_date').val(),
                                    d.to_date         = $('#to_date').val(),
                                    d.search          = $('input[type="search"]').val()
                        },
                    },
                    
                    columns : [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable:true,searchable:false},
                        {data:'date', name:'payments.created_at', orderable:true, searchable:true},  
                        // {data:'reciever_name', name:'receiver.name',orderable:false,searchable:true},
                        {data:'added_by', name:'admin.name',orderable:false,searchable:true},
                        {data:'type', name:'payments.type',orderable:true,searchable:true},
                        {data:'amount', name:'payments.amount',orderable:true,searchable:true},
                        {data:'old_balance', name:'payments.old_balance',orderable:true,searchable:true},
                        {data:'new_balance', name:'payments.new_balance',orderable:true,searchable:true},
                    ],
                });


       $('#from_date,#to_date').change(function(){
            table.draw();
       });
    });

</script>
@endsection