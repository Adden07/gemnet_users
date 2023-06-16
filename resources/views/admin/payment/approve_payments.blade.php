@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Finance</li>
                    <li class="breadcrumb-item active">Approve online payments</li>
                </ol>
            </div>
            <h4 class="page-title">Approve online payments</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="header-title">Filters</h4>
            </div>
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Status</label>
                            <select class="form-control" name="payement_status" id="payement_status">
                                <option value="">All</option>
                                <option value="1">Approved</option>
                                <option value="0" selected>Unapproved</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">From Date</label>
                            <input type="date" class="form-control" id="from_date">
                        </div>
                        <div class="col-md-4">
                            <label for="">To Date</label>
                            <input type="date" class="form-control" id="to_date">
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
<div class="row">
    
    <div class="col-lg-12">
        <div class="card-box">
            <form action="{{ route('admin.accounts.payments.approve_payment') }}" class="ajaxForm" method="POST">
                @csrf
                <input type="hidden" name="ids[]" id="ids">
                <input type="submit" class="btn btn-primary d-none" id="checkbox_submit" name="submit" value="Approve">
            </form>
            <table class="table table-bordered w-100 nowrap" id="payment_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="check_all"> <i class='fa fa-check'></i></th>
                        <th width="20">S.No</th>
                        <th>Date</th>
                        <th>Transaction <br />Date</th>
                        <th>Approved <br />Date</th>
                        <th>Receiver Name</th>
                        <th>Added By</th>
                        {{-- <th>Type</th> --}}
                        <th>Amount</th>
                        <th>Old Balance</th>
                        <th>New Balance</th>
                        <th>Image</th>
                        <th>Status</th>
                        @can('approve-payments')
                            <th>Approve</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tbody>
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="float-right"> 
                        {{-- {{ $transactions->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
@include('admin.partials.datatable', ['load_swtichery' => true])
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

<script>
    $(document).ready(function(){
        var table = $('#payment_table').DataTable({
                    processing: true, 
                    serverSide: true,
                    "order": [[ 0, "desc" ]],
                    "pageLength": 300,
                    "lengthMenu": [300,500,1000,1500],
                    "dom": '<"top"ifl<"clear">>rt<"bottom"ip<"clear">>',

                    ajax:{
                        url : "{{ route('admin.accounts.payments.approve_payments') }}",
                        data:function(d){
                            d.status    = $('#payement_status').val(),
                            d.from_date = $('#from_date').val(),
                            d.to_date   = $('#to_date').val()
                        },
                    },
                    drawCallback: function () {
                        var sum = $('#payment_table').DataTable().column(5).data().sum();
                        
                        internationalNumberFormat = new Intl.NumberFormat('en-US')
                        $('#total').html(internationalNumberFormat.format(sum));
                    },	
                    
                    columns : [
                        {data: 'checkbox', name: 'checkbox',orderable:false,searchable:false},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable:true,searchable:false},
                        {data:'date', name:'payments.created_at', orderable:true, searchable:true},  
                        {data:'online_date', name:'payments.online_date', orderable:true, searchable:true},  
                        {data:'approved_date', name:'payments.approved_date', orderable:true, searchable:true},  
                        {data:'reciever_name', name:'receiver.name',orderable:false,searchable:true},
                        {data:'added_by', name:'admin.name',orderable:false,searchable:true},
                        // {data:'type', name:'payments.type',orderable:true,searchable:true},
                        {data:'amount', name:'payments.amount',orderable:true,searchable:true},
                        {data:'old_balance', name:'payments.old_balance',orderable:true,searchable:true},
                        {data:'new_balance', name:'payments.new_balance',orderable:true,searchable:true},
                        {data:'image', name:'image',orderable:false,searchable:false},
                        {data:'status', name:'payments.status',orderable:false,searchable:false},
                        @can('approve-payments')
                            {data:'action', name:'payments.action',orderable:false,searchable:false},
                        @endcan

                    ],
                });


       $('#payement_status, #from_date, #to_date').change(function(){
            table.draw();
       });
    });
    //get dealers of selected franchise
    $('#franchise_id').change(function(){
        var id = $(this).val();
        var route = ""
        route = route.replace(':id',id);
        //send ajax request when value is set
        if(id.length != 0){
            getAjaxRequests(route,'','GET',function(resp){
                $('#dealer_id').html("<option value='' selected>Select Dealer</option>"+resp.html);
            });
        }
    });

    //get subdealers of selected dealer
    $('#dealer_id').change(function(){
        var id   = $(this).val();
        var route = "{{ route('admin.accounts.invoices.get_subdealers',':id') }}";
        var route = route.replace(':id',id);
        //send ajax request when value is set
        if(id.length != 0){
            getAjaxRequests(route, '', 'GET', function(resp){
                $('#subdealer_id').html("<option value=''>Select Sub Dealer</option>"+resp.html);
            });
        }
    });

    //select 2
    $('#username').select2({
        placeholder: 'Select Receiver'
    });

    function getCheckbox(){
          // Array to store the values of selected checkboxes
        var selectedCheckboxes = [];
        // Iterate over each checked checkbox
        $('input[name="checkbox[]"]:checked').each(function() {
            // Get the value of the checkbox (e.g., data ID)
            var value = $(this).val();-
            // Push the value to the selectedCheckboxes array
            selectedCheckboxes.push(value);
        });
        
        // Display the selected checkboxes (for demonstration purposes)
        if(selectedCheckboxes.length > 0){
            $('input[name="submit"]').removeClass('d-none');
        }else{
            $('#checkbox_submit').addClass('d-none');
        }  
        $('#ids').val(selectedCheckboxes);
    }
    $('#check_all').click(function(){
       if($(this).prop('checked')){
            $('input[name="checkbox[]"]').prop('checked', true)
       }else{
            $('input[name="checkbox[]"]').prop('checked', false)
       }
       getCheckbox();

    });
</script>
@endsection
