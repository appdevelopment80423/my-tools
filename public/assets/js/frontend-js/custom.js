
//How To Use Application
$('.steps-btn').slick({
  slidesToShow: 8,
  slidesToScroll: 1,
  asNavFor: '.steps-img',
  dots: false,
  // autoplay:true,
  focusOnSelect: true,
  variableWidth: true,
  // adaptiveHeight: true
});

$('.steps-img').slick({
   slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  // autoplay:true,
  draggable:false,
  asNavFor: '.steps-btn'
});

// $('.steps-img').on('beforeChange', function(event,slick,slide,nextSlide) {
//     $('.steps-btn').find('.slick-slide').removeClass('slick-current').not('.slick-cloned').eq(nextSlide).addClass('slick-current');
// });

var $status1 = $('.pagingInfo-1');
var $slickElement1 = $('.step-dtl-slide-1');

$slickElement1.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status1.text(i + '/' + slick.slideCount);
});

var $status2 = $('.pagingInfo-2');
var $slickElement2 = $('.step-dtl-slide-2');

$slickElement2.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status2.text(i + '/' + slick.slideCount);
});

var $status3 = $('.pagingInfo-3');
var $slickElement3 = $('.step-dtl-slide-3');

$slickElement3.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status3.text(i + '/' + slick.slideCount);
});

var $status4 = $('.pagingInfo-4');
var $slickElement4 = $('.step-dtl-slide-4');

$slickElement4.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status4.text(i + '/' + slick.slideCount);
});

var $status5 = $('.pagingInfo-5');
var $slickElement5 = $('.step-dtl-slide-5');

$slickElement5.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status5.text(i + '/' + slick.slideCount);
});

var $status6 = $('.pagingInfo-6');
var $slickElement6 = $('.step-dtl-slide-6');

$slickElement6.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status6.text(i + '/' + slick.slideCount);
});

var $status7 = $('.pagingInfo-7');
var $slickElement7 = $('.step-dtl-slide-7');

$slickElement7.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status7.text(i + '/' + slick.slideCount);
});

var $status8 = $('.pagingInfo-8');
var $slickElement8 = $('.step-dtl-slide-8');

$slickElement8.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $status8.text(i + '/' + slick.slideCount);
});

$('.step-dtl-slide').slick({
  infinite: false,
  speed: 500,
  fade: true,
  cssEase: 'linear',
  asNavFor: '.steps-dtl-img',
});

$('.steps-dtl-img').slick({
   slidesToShow: 1,
   infinite: false,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  draggable:false,
  asNavFor: '.step-dtl-slide'
});

