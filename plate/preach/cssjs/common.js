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
                
                var _a = unescape(a[0].showtext),
                    _b = unescape(a[0].title),
                    _c = unescape(a[0].intro),
                    _d = unescape(a[0].showform);
                showtext.val(_a);
                title.val(_b);
                intro.val(_c);
                $('.nowForm').html(_d);

                showtext.html(_a);
                title.html(_b);
                intro.html(_c);

                
                if (typeof(callback)=='undefined') {
                    console.log('ajaxGetshow : no callback');
                }else{
                    callback();
                };
                //

            }else if(dataList.code == '401'){
                
            }else{
                
            };
                
        },
        error : function(){
            console.log('getshow,网络故障请刷新，或重试!');
        }
    
    });
}