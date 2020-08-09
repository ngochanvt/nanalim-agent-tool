<?php
require_once("helper/payment_report.php");
$cur_lang = $lang[$glb_config['lang']];
$ap_status_name = array('NULL'=>'Chưa thanh toán', 'REQUESTED'=>'Chờ thanh toán', 'COMPLETED'=>"Đã thanh toán");
$summary = get_ap_detail($_GET['id']);
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
				<input type="hidden" name="web_id" id="web_id" value="<?=$_GET['id']?>">
				<input type="hidden" name="ap_status" id="ap_status" value="<?=$_GET['ap_status']?>">
			</div>
		</div>
        <div class="row">
            <div class="col-md-12">
                <p> Tổng đơn hàng: <strong><?=number_format($summary['total_order'])?></strong> </p>
                <p> Tổng tiền hoa hồng: <strong><?=number_format($summary['total_money'])?></strong> </p>
            </div>
        </div>
	</div>
	<div class="container-fluid" style="margin-top: 30px;">
		<div class="row tb-w100">
			<table id="datatable_order" class="table table-striped" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th><?=$cur_lang['user']?></th>
						<th><?=$cur_lang['price']?></th>
                        <th><?=$cur_lang['commission']?></th>
						<th><?=$cur_lang['order-date']?></th>
						<!-- <th>View</th> -->
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    InitializeTableOrder();
})
function InitializeTableOrder() {
    var web_id = $("#web_id").val();
    var agency_id = $("#agency_id").val();
    var ap_status = $("#ap_status").val(); 
    var params={
        'id': web_id
    };
    $("#datatable_order").dataTable().fnDestroy();
    $('#datatable_order').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "type": "POST",
            "url": base_url + 'ajax/a_order_list.php',
            "data": params
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": "od_id"
            },
            {
                "targets": 1,
                "data": "od_name"
            },
            {
                "targets": 2,
                "data": "od_receipt_price",
                "render": function ( data, type, row, meta ) {
                    if(data!=undefined && data!=null && data!='')
                        return "<span>"+formatNumber(data)+"</span>";
                    return '0';
                }
            },
            {
                "targets": 3,
                "data": "commission",
                "render": function ( data, type, row, meta ) {
                    if(data!=undefined && data!=null && data!='')
                        return "<span>"+formatNumber(data)+"</span>";
                    return '0';
                }
            },
            {
                "targets": 4,
                "data": "od_receipt_time",
                "render": function ( data, type, row, meta ) {
                	if(data!=null && data!=undefined && data!='') 
                		return '<span>'+(data)+'</span>';
                	return '';
                }
            },
            // {
            //     "targets": 6, 
            //     "data": "od_id",
            //     "render": function ( data, type, row, meta ) {
            //         return '<a href="'+base_url+'"index.php?route=order-detail.php?id='+data+'">View</a>';
            //     }
            // }
        ]
    });
}
</script>