<?php
    // $it_img_dir = G5_DATA_URL.'/sub_web/web_'.$_GET['web-id'].'/';
    // $logo = $web_config['logo']!=''?$it_img_dir.$web_config['logo']:$g5['tmpl_url'].'/images/logo.png?v='.date("U");
?>
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	    <div class="container-fluid">
	        <button type="button" id="sidebarCollapse" class="btn btn-info">
	            <i class="fas fa-align-left"></i>
	            <span>Toggle Sidebar</span>
	        </button>
            <h4>Website</h4>
	    </div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" name="agency_id" id="agency_id" value="<?=$_SESSION['auth']->agency_id?>">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row tb-w100">
			<table id="datatable_web_list" class="table table-striped" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th><?=$lang[$glb_config['lang']]['website-name']?></th>
						<th><?=$lang[$glb_config['lang']]['picture']?></th>
                        <th><?=$lang[$glb_config['lang']]['website-username']?></th>
                        <th><?=$lang[$glb_config['lang']]['name']?></th>
                        <th><?=$lang[$glb_config['lang']]['phone']?></th>
                        <th><?=$lang[$glb_config['lang']]['email']?></th>
						<th></th>
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
            "url": base_url + 'ajax/a_web_list.php',
            "data": params
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": "web_id"
            },{
                "targets": 1,
                "data": "web_name"
            },{
                "targets": 2,
                "data": "logo",
                "render": function(data, type, row, meta){
                    if(data==null || data == undefined || data=='') return '';
                    return "<img width='100px' src = '<?=$glb_config['baseurl']?>data/sub_web/web_"+row['web_id']+"/"+data+"' />";
                }
            },
            {
                "targets": 3,
                "data": "username"
            },
            {
                "targets": 4,
                "data": "name"
            },
            {
                "targets": 5,
                "data": "phone"
            },
            {
                "targets": 6,
                "data": "email"
            },
            {
                "targets": 7,
                "data": "web_id",
                render: function(data, type, row, meta){
                    return "<a href='"+base_url+"index.php?route=web-detail&id="+data+"'><i class='fas fa-eye' style='font-size: 2em'></i></a>";
                }
            },
        ]
    });
}
</script>
