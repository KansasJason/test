function myCheck()
      {
         for(var i=0;i<document.form6.elements.length-1;i++)
         {
          if(document.form6.elements[i].value=="")
          {
           alert("当前选项不能有空项");
           document.form6.elements[i].focus();
           return false;
          }
         }
         return true;
      }


$(function(){
    $(".taamenu li").on("click",function(){
        var index=$(this).index();
        //$(this).addClass("active").siblings().removeClass("active");
        $(this).parents("dt.taamenu").siblings("dd.taaitem").eq(index).show().siblings("dd.taaitem").hide();
        $(this).addClass("btn-active2");
        $(this).siblings(".taamenu li").removeClass("btn-active2");
    });

});


