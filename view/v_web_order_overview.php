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
				<h4>Website</h4>
				<div class="row">
					<div class="col-md-6 form-group">
						<select class="form-control" name="lst_web" id="lst_web">
							<option value="all">All</option>
							<?php foreach($glb_config['lst_web'] as $id => $value){?>
								<option value="<?=$id?>"><?=$value?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row tb-w100">
			<table id="datatable_web_list" class="table table-striped" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th><?=$lang[$glb_config['lang']]['website']?></th>
						<th><?=$lang[$glb_config['lang']]['total-order']?></th>
						<th><?=$lang[$glb_config['lang']]['complete-payment-order']?></th>
						<th><?=$lang[$glb_config['lang']]['non-payment-order']?></th>
						<th><?=$lang[$glb_config['lang']]['request-payment-order']?></th>

                        <!-- <th><?=$lang[$glb_config['lang']]['complete-payment-money']?></th>
                        <th><?=$lang[$glb_config['lang']]['non-payment-money']?></th>
                        <th><?=$lang[$glb_config['lang']]['request-payment-money']?></th> -->
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
            "url": base_url + 'ajax/a_web_order_overview.php',
            "data": params
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": "web_id"
            },{
                "targets": 1,
                "data": "web_name",
                // "render": function ( data, type, row, meta ) {
                //     return "<a href='"+base_url+"index.php?route=payment-list&id="+row.web_id+"&ap_status=all'>"+data+"</a>";
                // }
            },{
                "targets": 2,
                "data": "total_order",
                "render": function(data, type, row, meta){
                    if(data==null || data == undefined || data=='') data = 0;
                    return "<a href='"+base_url+"index.php?route=web-order&id="+row.web_id+"&ap_status=all'>"+data+"</a>";
                }
            },
            {
                "targets": 3,
                "data": "total_complete_payment",
                "render": function(data, type, row, meta){
                    if(data==null || data == undefined || data=='') data = 0;
                    return "<a href='"+base_url+"index.php?route=web-order&id="+row.web_id+"&ap_status=completed'>"+data+"</a>";
                }
            },{
                "targets": 4,
                "data": "total_non_payemnt",
                "render": function(data, type, row, meta){
                    if(data==null || data == undefined || data=='') data = 0;
                    return "<a href='"+base_url+"index.php?route=web-order&id="+row.web_id+"&ap_status=non'>"+data+"</a>";
                }
            },{
                "targets": 5,
                "data": "total_request_payment",
                "render": function(data, type, row, meta){
                    if(data==null || data == undefined || data=='') data = 0;
                    return "<a href='"+base_url+"index.php?route=web-order&id="+row.web_id+"&ap_status=requested'>"+data+"</a>";
                }
            }
        ]
    });
}
</script>
