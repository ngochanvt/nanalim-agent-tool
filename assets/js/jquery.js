
$(document).keyup(function(e) {
     if (e.keyCode == 27) { // escape key maps to keycode `27`
        $('.hidden-slider').css('display','none');
    }
});
$(document).ready(function(){
	
	$('.img-resize').css('left','0');
            $('.img-resize').css('right','0');
            
            $('.img-resize').css('margin','auto');
            $('.img-resize').css('width','auto');
            $('.img-resize').css('height','100%');
	$('.close-slider').click(function(){
		
		$('.hidden-slider').css('display','none');
		$(this).css('display','none');
	})
	
	 $('.cocoen').cocoen();
	  $('.tmp').mouseenter(function(){
	  	$('.before').css('display','block');
	  	$('.after').css('display','block');
	  })
	  $('.tmp').mouseout(function(){
	  	$('.before').css('display','none');
	  	$('.after').css('display','none');
	  })
	  $('.cocoen-drag').html('<span class="fa fa-caret-right fa-rgt"></span><span class="fa fa-caret-left fa-lft"></span>')
	if($(window).width()<=960){
		$('.carousel-item').owlCarousel('destroy'); 
	}
	
	$('.ba-slider').slick({
		autoplay:false,
        dots: true,
        infinite: true,
        speed: 200,
        slidesToShow: 1,
        swipe:false,
        /*adaptiveHeight: true,*/
        draggable: false
	});
	$('.mini-slider').slick({
	    autoplay:true,
        dots: true,
        infinite: true,
        speed: 200,
        slidesToShow: 1,
        adaptiveHeight: true
	  });
	$("#myForm").submit(function(event){
		var formData=$(this).serialize();
		$.ajax({
            type: "POST",
            url: "./ajax/sendMail.php",
            data: formData,
            success: function(data)
	           {
	           	//alert(data);
	            if(data==1){
	            	$(".error").html('Cảm ơn quý khách đã liên lạc, chúng tôi sẽ phản hồi trong thời gian sớm nhất');
	            }
	            else{
	            	$(".error").html('Vui lòng thử lại, hệ thống đang gặp trục trặc nhỏ, chúng tôi xin lỗi vì sự bất tiện này');
	            }
	           },
	        error: function(data){
	        	//alert(data);
	        	console.log(data);
	        }
         });
		event.preventDefault();
	})
	$('#lstImg').slick({
	    dots: true,
        autoplay:1,
	    slidesPerRow: 2,
	    rows: 2,
	    responsive: [
	    {
	      breakpoint: 478,
	      settings: {
	        slidesPerRow: 1,
	        rows: 1,
	      }
	    }
	  ]
	});
	$(".img-detail:even").css("margin-left","0");
	$(".comp-home-item").mouseout(function(){
		$.ajax({
			type: 'POST',
			url: './ajax/ajax_returnBannerHome.php',
			success: function(data){
				$('.carousel-background').owlCarousel('destroy'); 
				$("#lst-item-banner-home").html(data);
				$(".carousel-background").owlCarousel({
				        loop: true,
				        dots: false,
				        autoplay:true,
				        animateOut: 'slideOutDown',
    					animateIn: 'flipInX',
				        autoplayTimeout:2000,
				        responsive:{
				            0:{
				                items:1
				            },
				            600:{
				                items:1
				            },
				            1000:{
				                items:1
				            }
				        }
				    });
			},
			error: function(data){
				console.log(data);
			}
		});
	})
	$(".comp-home-item").mouseenter(function(){
		var id=$(this).attr('id');
		$.ajax({
			type: 'POST',
			url: './ajax/ajax_changeBannerHome.php',
			data: {id:id, status:status},
			success: function(data){
				$('.carousel-background').owlCarousel('destroy'); 
				$("#lst-item-banner-home").html(data);
				$(".carousel-background").owlCarousel({
				        loop: true,
				        dots: false,
				        autoplay:true,
				        animateOut: 'slideOutDown',
    					animateIn: 'flipInX',
				        autoplayTimeout:2000,
				        responsive:{
				            0:{
				                items:1
				            },
				            600:{
				                items:1
				            },
				            1000:{
				                items:1
				            }
				        }
				    });
			},
			error: function(data){
				console.log(data);
			}
		});
	})
});
function goBack(){
	window.history.back();
}
function lightbox(idx) {
    //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
    var ninjaSldr = document.getElementById("ninja-slider");
    ninjaSldr.parentNode.style.display = "block";

    nslider.init(idx);

    var fsBtn = document.getElementById("fsBtn");
    fsBtn.click();
}

function fsIconClick(isFullscreen) { //fsIconClick is the default event handler of the fullscreen button
    if (isFullscreen) {
        var ninjaSldr = document.getElementById("ninja-slider");
        ninjaSldr.parentNode.style.display = "none";
    }
}
