$(document).ready(function(){
  $(".owl-carousel").owlCarousel( {
    center: true,
    items:5,
    loop:true,
    nav: true,
    margin:10,
    autoplay:true,
    autoplayTimeout:3500,
      responsive : {
    // breakpoint from 0 up
    0 : {
        nav : true,
        items : 3,
        margin: 10
    },
    // breakpoint from 480 up
    480 : {
        items : 3,
        nav : true
    },
    // breakpoint from 768 up
    768 : {
        items : 5,
        nav : true
    }
}
  });
});