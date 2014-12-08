function ajaxGetshow(callback){
    jQuery.ajax({
        type  : "get",
        async : true,
        url : 'http://idacker.com/weixinsdk/plate/preach/api.php',
        dataType : "jsonp",
        jsonp : "callback",
        data : {
            verify:"getshow"
        },
        jsonpCallback : "dataList",
        success : function(dataList){
            if (dataList.code=='200') {
                var a = dataList.data;
                //console.log(a[0]);
                $('.nowForm').html('《'+decodeURIComponent(a[0].showform)+'》');
                var _a = decodeURIComponent(a[0].showtext),
                    _b = decodeURIComponent(a[0].title),
                    _c = decodeURIComponent(a[0].intro);
                showtext.val(_a);
                title.val(_b);
                intro.val(_c);

                showtext.html(_a);
                title.html(_b);
                intro.html(_c);

                callback();

            }else if(dataList.code == '401'){
                
            }else{
                
            };
                
        },
        error : function(){
            console.log('getshow,网络故障请刷新，或重试!');
        }
    
    });
}