<?php
    require_once("helper/payment_report.php");
    $web_id = $_GET['web_id'];
    $payment_report = get_agency_payment_report($_SESSION['auth']->agency_id);
?>
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	    <div class="container-fluid">
	        <button type="button" id="sidebarCollapse" class="btn btn-info">
	            <i class="fas fa-align-left"></i>
	            <span>Toggle Sidebar</span>
	        </button>
	    </div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" name="agency_id" id="agency_id" value="<?=$_SESSION['auth']->agency_id?>">
                <input type="hidden" name="web_id" id="web_id" value="<?=$web_id?>">
			</div>
		</div>
        <div class="row">
            <div class="col-md-6">
                <p class=""> <?=$cur_lang["total-order"]?>: <strong><?=number_format($payment_report['total_order'])?></strong> </p>
                <p class=" text-red"> <?=$cur_lang["request-payment-order"]?>: <strong><?=number_format($payment_report['total_requested_order'])?></strong> </p>
                <p class=""> <?=$cur_lang["complete-payment-order"]?>: <strong><?=number_format($payment_report['total_completed_order'])?></strong> </p>
            </div>
            <div class="col-md-6">
                <p class=""> <?=$cur_lang["total-money"]?>: <strong><?=number_format($payment_report['total_money'])?></strong> </p>
                <p class=" text-red"> <?=$cur_lang["request-payment-money"]?>: <strong><?=number_format($payment_report['total_requested_money'])?></strong> </p>
                <p class=""> <?=$cur_lang["complete-payment-money"]?>: <strong><?=number_format($payment_report['total_completed_money'])?></strong> </p>
            </div>
        </div>
	</div>
	<div class="container-fluid">
		<div class="row tb-w100">
			<table id="datatable_web_list" class="table table-striped" style="width:100%">
				<thead class="thead-dark">
					<tr>
                        <th>PAYMENT ID</th>
                        <th><?=$cur_lang["total-order"]?></th>
                        <th><?=$cur_lang["total-money"]?></th>
                        <th><?=$cur_lang["order-date"]?></th>
                        <th><?=$cur_lang["payment-date"]?></th>
                        <th><?=$cur_lang["payment-status"]?></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	
$(document).on('change', "#lst_web", function(){
   InitializeTableWeb();
})
$(document).ready(function(){
    InitializeTableWeb();
})
function InitializeTableWeb() {
    var lst_web = $( "select#lst_web option:checked" ).val();
    var params={
    	
    };
    var agency_id = $("#agency_id").val();
    params.agency_id = agency_id;
    if(lst_web!='' && lst_web!='all'){
        params.web_id = lst_web;
    }
    $("#datatable_web_list").dataTable().fnDestroy();
    $('#datatable_web_list').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "type": "POST",
            "url": base_url + 'ajax/a_payment_list.php',
            "data": params
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": "payment_code",
                "render": function( data, type, row, meta ){
                    return "<a href='"+base_url+"index.php?route=order-list&id="+row.payment_code+"'>"+data+"</a>";
                }
            },
            {
                "targets": 1,
                "data": "total_order"
            },
            {
                "targets": 2,
                "data": "total_money",
                "render": function( data, type, row, meta ){
                    if(data!=undefined && data!=null && data!='')
                        return "<span>"+formatNumber(data)+"</span>";
                    return '0';
                }
            },
            {
                "targets": 3,
                "data": "create_date"
            },
            {
                "targets": 4,
                "data": "payment_date"
            },
            {
                "targets": 5,
                "data": "status",
                "render": function ( data, type, row, meta ) {
                    switch (row.status){
                        case 'REQUESTED':
                            return 'Chờ thanh toán';
                        case 'COMPLETED':
                            return 'Đã thanh toán';
                        default:
                            return 'Chưa thanh toán';
                    }
                }
            }
        ]
    });
}
</script>
