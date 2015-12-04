<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Bookstore | @yield('title')</title>
        <meta name="keywords" content="Book Store Template, Free CSS Template, CSS Website Layout, CSS, HTML" />
        <meta name="description" content="Book Store Template, Free CSS Template, Download CSS Website" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="{{ url() }}/css/templatemo_style.css" type="text/css"/>
        <link rel="stylesheet" href="{{ url() }}/css/jquery-ui/jquery-ui.css">
        <script type="text/javascript">
             $(document).ready(function() {
                $('.select').removeClass('visible');
                $('.checkbox').attr("checked",false);
                $('.parent').click(function() {
                    var $ul = $(this).siblings("ul");
                    $ul.toggleClass('visible');
                });
                $(".add_to_cart_button").click(function(event){
                    event.preventDefault();
                    $.post("{{url('cart')}}", $( this ).closest("form").serialize(), function($respone) {
                        if($respone=='notLogin')
                            window.location.href = "{{url('auth/login')}}";
                        else if($respone=='notHave')
                            alert('Hiện tại sản phẩm này đã hết');
                        else
                            $(".cart-price").text($respone);
                    });
                });
                $(".quantity_input").on('change',function(event){
                    event.preventDefault();
                    $total_price=$(this).parent().parent().parent().parent().find(".cart_total_price");
                    $book_id=$(this).closest("input");
                    $.post("{{url('cart_update')}}", $( this ).closest("form").serialize(), function($respone) {
                        if($respone.login=='false'){
                            window.location.href = "{{url('auth/login')}}";
                        }else{
                            $total_price.text($respone.subtotal);
                            $(".cart-price").text($respone.total);
                        }
                    },'json');
                });
                $(".cart_quantity_delete").on('click',function(event){
                    event.preventDefault();
                    $html_will_delete=$(this).parent().parent().parent();
                    $.post("{{url('cart_delete')}}", $( this ).closest("form").serialize(), function($respone ) {
                        if($respone=='notLogin')
                            window.location.href = "{{url('auth/login')}}";
                        else{
                            $(".cart-price").text($respone);
                            $html_will_delete.remove();
                            if($respone == 0){
                                $("table").remove();
                                $("p").remove();
                                $("#templatemo_content_right").append("<p>Hiện tại không có sản phẩm nào trong giỏ hàng.</p>");
                                $("button").closest("div").remove();
                            }
                        }
                    });
                });
                $(".cart_remove").click(function(event){
                    event.preventDefault();
                    $.post("{{url('cart_remove')}}", $( this ).closest("form").serialize(), function() {
                        $("table").remove();
                        $("p").remove();
                        $(".cart-price").text("0");
                        $("#templatemo_content_right").append("<p>Hiện tại không có sản phẩm nào trong giỏ hàng.</p>");
                        $("button").closest("div").remove();
                    });
                });

                $(".checkbox").click(function(){
                    $select = $(this).parent().parent().find(".select");
                    $select.toggleClass('visible');
                });
                $('.buy_now_button').click(function(event) {
                    event.preventDefault();
                    $.post("{{url('order')}}", $( this ).closest("form").serialize(), function($respone){
                        if($respone=='notLogin')
                            window.location.href = "{{url('auth/login')}}";
                        else if($respone=='notHave')
                            alert('Hiện tại sản phẩm này đã hết');
                        else
                           window.location.href = "{{url('order/')}}/"+$respone;
                    });
                });
                $('.request').click(function(event) {
                    event.preventDefault();
                    $.post("{{url('request')}}", $(this).closest("form").serialize(), function($respone){
                        if($respone.email=="true"){
                            alert("Đăng yêu cầu thành công");
                        }else{
                            $('#email-error').text($respone.email[0]);
                            $('#request-error').text($respone.content[0]);
                        }
                    },'json');
                });
                $('.post-comment').click(function(event) {
                    event.preventDefault();
                    $.post("{{url()}}/book/comment", $(this).closest("form").serialize(), function($respone){
                        if($respone.comment=="true"){
                            location.reload();
                            window.location.href="{{url('book_info/')}}/"+$respone.book_id+"#1";
                        }else{
                            $('#comment-error').text($respone.comment[0]);
                        }
                    },'json'); 
                });
            });  
        </script>
    </head>

    <body>
        <div id="templatemo_container">
            
            @include('layout.header')

            <div id="templatemo_content">
                
                @include('layout.sidebar')

                <div id="templatemo_content_right">
                    <h1 class="content-title">@yield('content-title')</h1>
                    @yield('content')

                </div>
            </div>
            
            @include('layout.footer')
            
        </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
            <script type="text/javascript">
              $(function() {
                $( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' }).val();
              });
            </script>

    </body>
</html>
