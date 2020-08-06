var prod_image  = [];
var len         = 0;
var max_image   = 4;
var base_url    = $('base').attr('href');
var url         = window.location.href;
var deletedOI   = [];
var deletedNI   = [];
var include_shopids  = [];
var exclude_shopids  = [];
var check_all_shopid = false;
$(document).ajaxStart(function(){
    $("#wait").css("display", "block");
});
$(document).ajaxComplete(function(){
    $("#wait").css("display", "none");
});

$(document).on('click', '#trigger-upload-images', function(){
    $('#upload-images').click();
})
$(document).on('change', '#upload-images', function(event){
    var flat=false;
    var str="";
    var st="";
    max_image = 4;
    if(url.indexOf('product-edit')!=-1){
        max_image = 4 - parseInt($(".lst-current").attr('id')) - prod_image.length + deletedNI.length;
    }
    for(var i=0;i<event.target.files.length && i<max_image; i++){
        if(event.target.files[0].size>=1000000){
            st+=event.target.files[0].name+'\n';
            flat=true;
        }
        else {
            prod_image.push(event.target.files[i]);
            str+="<li  id='box-"+(len+i)+"' class='mutual-image-box col-md-3'><img src='"+URL.createObjectURL(event.target.files[i])+"' height='100px'  class='style-img-ad' /> <i class='fa fa-trash-o size-margin deleImg image-delete' onclick=deleImg("+(len+i)+") id='"+(len+i)+"'></i></li>";
        }
    }
    
    if(flat) alert('Ảnh '+ st +' vượt quá kích thước cho phép (Vui lòng chọn ảnh nhỏ hơn 1MB)');
    len=prod_image.length;
    $(".image-lst").append(str);
});

function deleImg(id){
    deletedNI.push(id);
    $("#box-"+id).remove();
}

function deleteImageMul(i){
    deletedOI.push(i);
    $("#deleted_old_image").attr('value', deletedOI);
    var tmp=parseInt($(".lst-current").attr('id'))-1;
    $(".lst-current").attr('id', tmp);
    $('#mul-'+i).addClass('imgODeleted');
    $('#hide-box-'+i).css('display', 'flex');
}
function resume(id){
    deletedOI.splice(deletedOI.indexOf(id),1);
    $("#deleted_old_image").attr('value', deletedOI);
    var tmp=parseInt($(".lst-current").attr('id'))+1;
    $(".lst-current").attr('id', tmp);
    $("#hide-box-"+id).css('display', 'none');
    $('#mul-'+id).removeClass('imgODeleted');
}
$(document).on('click', '#trigger-upload-shoppic', function(){
    $('#upload-shoppic').click();
})
$(document).on('change', '#upload-shoppic', function(event){
    var flat=false;
    //var tmppath = URL.createObjectURL(event.target.files[0]);
    var str="";
    var st="";

    if(event.target.files[0].size>=1000000){
        st+=event.target.files[0].name+'\n';
        flat=true;
    }
    else {
        if(url.indexOf('product-edit')!=-1){
            $("#deleted_shoppic").attr('value', 1);
        }
        str+="<div class='col-md-4 images-box mutual-image-box'><img src='"+URL.createObjectURL(event.target.files[0])+"' /></div>";
    }
    if(flat) alert('Ảnh '+ st +' vượt quá kích thước cho phép (Vui lòng chọn ảnh nhỏ hơn 1MB)');
    $(".shoppic").html(str);
});

function delete_shoppic(){
    $('#hide-box-shoppic').css('display', 'flex');
    $("#deleted_shoppic").attr('value', 1);
}

function resume_shoppic(){
    $('#hide-box-shoppic').css('display', 'none');
    $("#deleted_shoppic").attr('value', 0);
}

$(document).on('click', '#trigger-upload-zhuang', function(){
    $('#upload-zhuang').click();
})
$(document).on('change', '#upload-zhuang', function(event){
    var flat=false;
    //var tmppath = URL.createObjectURL(event.target.files[0]);
    var str="";
    var st="";

    if(event.target.files[0].size>=1000000){
        st+=event.target.files[0].name+'\n';
        flat=true;
    }
    else {
        if(url.indexOf('product-edit')!=-1){
            $("#deleted_zhuang").attr('value', 1);
        }
        str+="<div class='col-md-4 images-box mutual-image-box'><img src='"+URL.createObjectURL(event.target.files[0])+"' /></div>";
    }
    if(flat) alert('Ảnh '+ st +' vượt quá kích thước cho phép (Vui lòng chọn ảnh nhỏ hơn 1MB)');
    $(".zhuang").html(str);
});

function delete_zhuang(){
    $('#hide-box-zhuang').css('display', 'flex');
    $("#deleted_zhuang").attr('value', 1);
}

function resume_zhuang(){
    $('#hide-box-zhuang').css('display', 'none');
    $("#deleted_zhuang").attr('value', 0);
}

$(document).on('change', '#anclassid', function(){
    $.ajax({
        type: "POST",
        url: "ajax_load_category.php",
        data: {'load_nclassid':1, 'anclassid':this.value},
        success: function(data)
           {
                if(data.notification.code==200){
                    if(data.shop_nclass.length>0){
                        var str = '<option value="">Select category</option>';
                        for(var i=0; i<data.shop_nclass.length; i++){
                            str+="<option value='"+data.shop_nclass[i].nclassid+"'> "+ data.shop_nclass[i].nclass +"</option>";
                        }
                        $("#nclassid").html(str);
                    }
               }
                if(url.indexOf('product-list')!=-1){
                    InitializeTableProduct();
                }
                if(url.indexOf('order-list')!=-1){
                    InitializeTableOrder();
                }
           }
     });
})
$(document).on('change', '#nclassid', function(){
    $.ajax({
        type: "POST",
        url: "ajax_load_category.php",
        data: {'load_xclassid':1, 'nclassid':this.value},
        success: function(data)
           {
                if(data.notification.code==200){
                    if(data.shop_xclass.length>0){
                        var str = '<option value="">Select category</option>';
                        for(var i=0; i<data.shop_xclass.length; i++){
                            str+="<option value='"+data.shop_xclass[i].id+"'> "+ data.shop_xclass[i].xclass +"</option>";
                        }
                        $("#xclassid").html(str);
                    }
               }
               if(url.indexOf('product-list')){
                    InitializeTableProduct();
                }
           }
     });
})

$(document).on('change', "#hyj", function(){
    var original_price = $('#shichangjia').val();
    var percent = this.value;
    $("#huiyuanjia").val(parseInt(original_price)*parseFloat(percent));
})

$(document).on('change', "#vj", function(){
    var original_price = $('#shichangjia').val();
    var percent = this.value;
    $("#vipjia").val(parseInt(original_price)*parseFloat(percent));
})

$(document).on('change', "#pj", function(){
    var original_price = $('#shichangjia').val();
    var percent = this.value;
    $("#pifajia").val(parseInt(original_price)*parseFloat(percent));
})

$(document).on('click', "#sidebarCollapse", function(){
    $('#sidebar').toggleClass('active');
})

$(document).on('change', "#language", function(){
    setCookie('current-url', $(location).attr('href'), 1);
    $("#form-language").submit();
})

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
          setCookie("username", user, 365);
        }
    }
}

function toggle_all_shopid(option){
    check_all_shopid = option;
    if(option){
        $(".check_shopid").attr('checked', true);
    }else{
        $(".check_shopid").attr('checked', false);
    }
    include_shopids = [];
    exclude_shopids = [];
}
function toggle_one_shopid(shopid){
    shopid = parseInt(shopid);
    var index_include = include_shopids.indexOf(shopid);
    var index_exclude = exclude_shopids.indexOf(shopid);
    if(check_all_shopid){
        if(index_exclude==-1) exclude_shopids.push(shopid);
        else exclude_shopids.splice(index_exclude, 1);
    }else{
        if(index_include==-1) include_shopids.push(shopid);
        else include_shopids.splice(index_include, 1);
    }
    // console.log(include_shopids, 'include_shopids');
    // console.log(exclude_shopids, 'exclude_shopids');
}
function delete_shopid(shopid){
    var re;
    re = confirm("Do you want to delete this product? This action cannot be reverted");
    if(re){
         var params={
            'check_all_shopid': 0,
            'include_shopids': JSON.stringify([shopid]),
            'detele-shopid' : 1
        };
        $.ajax({
            type: 'POST',
            url: base_url + 'ajax/a_product.php',
            data: params,
            success: function(data){
                console.log(data);
                location.reload();
            },
            error: function(data){
                console.log(data);
            }
        });
    }
}

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
