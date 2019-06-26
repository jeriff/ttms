/*
 * iframe 内页面通用js
 */



// JavaScript Document
//图片预加载
function imgPreload() { //v3.0
    var d=document;
    if(d.images){
        if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=imgPreload.arguments;
        for(i=0; i<a.length; i++)
            if (a[i].indexOf("#")!=0){
                d.MM_p[j]=new Image;
                d.MM_p[j++].src=a[i];
            }
    }
}

function autoResize(objid)
{
    try
    {
        document.getElementById(objid).style.height = document.frames[objid].document.body.scrollHeight;
    }
    catch(e){

    }
}

//设置父框架的高度
function reInitIframe(objid){
    var iframe = document.getElementById(objid);
    try{
        var bHeight = iframe.contentWindow.document.body.scrollHeight;
        var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
        var height = Math.max(bHeight, dHeight);
        iframe.height =  height;
    }catch (ex){}
}

/**
 * @功能:父亲框架自适应宽高
 * @备注:请在子页面中调用
 * @Param:父亲框架ID
*/
function ifrmResize(objid) 
{
    try
    {
        parent.document.getElementById(objid).style.height=document.documentElement.scrollHeight+'px'; 
        parent.document.getElementById(objid).style.width=document.documentElement.scrollWidth+'px'; 
    //alert(document.documentElement.scrollHeight)
    }catch(ex){}
}

//遍历radio，检测是否选中，return {'chk_flags':chk_flags,'chk_id':chk_id,'chk_value':chk_value}

function chkRadioIFChecked(objname){
    try{
        var obj = document.getElementsByName(objname);
        var chk_flags = 0;
        var chk_id = '';
        var chk_value = '';
        for(var i=0;i<obj.length;i++){
            //alert(obj[i].id);
            if(obj[i].checked == true){
                chk_flags = 1;
                chk_id = obj[i].id;
                chk_value = obj[i].value;
                break;
            }
        }		
        return {
            'chk_flags':chk_flags,
            'chk_id':chk_id,
            'chk_value':chk_value
        };		
    //alert(chk_flags+'============'+chk_id+"==============="+chk_value);
    }catch(e){
		
    }
}


//遍历表格行的样式
function setOnMouseOver(obj,cla1,cla2,cla3)
{
    $(obj).each(function (){						
        $(this).attr("class",cla1);
        $(this).mouseover(function(){
            this.className = cla2
        });
        $(this).mouseout(function(){
            this.className = cla1
        });
    });
}


//遍历，设置input的focus和blur样式
function setHightLight(clsName,clsFocus,clsBlur){
    $(clsName).each(function(){
        $(this).focus(function(){
            $(this).attr("class",clsFocus)
        });
        $(this).blur(function(){
            $(this).attr("class",clsBlur)
        });
				
    });
}




//给某个元素的赋值或者html
function setElementValue(wintarget,objid,setvalue,settype){
    try{
        var tmp_v = setvalue;
	
        switch(wintarget){
            //父级窗口
            case 'parent':
                (settype == 'val')?eval(parent.$('#'+objid).val(tmp_v)) : eval(parent.$('#'+objid).html(tmp_v)); 
				
                break;
            //当前窗口
            case 'self':
                (settype == 'val')?eval($('#'+objid).val(tmp_v)) : eval($('#'+objid).html(tmp_v)); 
                break;
            //当前窗口的某个iframe
            default:
                break;
        }
    }catch(e){
    }
}


//确认框,@msg,提示消息,@url 传入参数
function confirmUrl(msg,url)
{
    if(confirm(msg)){
        switch(typeof(url)){
            case 'undefined' ://未定义
                break;
            case 'boolean' :
                break;
            case 'number' :
                break;
            case 'string' :
                window.location=url;
                break;
            case 'function' ://执行函数
                break;
            case 'object' ://对象,数组和null 
                break;
        }//end switch
    }//end if
}


//检测URL
function is_url(str){
    var patrn= /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/
    return patrn.test(str);
}

//检测域名
function is_domain(str){
    var patrn = /^([a-zA-Z0-9-]+\.)+(com|cn|net|biz|name|info|tv|org|cc)$/;
    return patrn.test(str);   
}

//检测Email
function is_email(str){

    //var patrn=/^([a-zA-Z0-9\_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    var patrn=/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
    return patrn.test(str);
}

//检测Email
function is_email_all(mailaddress,delimiter){
    var t = typeof(mailaddress);
    //var v_tmp = '';
    //alert(t)
    var flags = true;	
    if(mailaddress == null){
        flags = false;
    }
	
    //字符串
    if(t == 'string'){
        v_tmp = mailaddress.split(delimiter);
        for(var i=0;i<v_tmp.length;i++){
            if(!is_email(v_tmp[i])){
                flags = false;
                break;
            }
        }
    }
	
    //数组
    if(t == 'object'){
        v_tmp = mailaddress;
        for(var i=0;i<v_tmp.length;i++){
            if(!is_email(v_tmp[i])){
                flags = false;
                break;
            }
        }
    }
	
    return flags;
	
}
//检测合法用户名
function is_user(str){
    var patrn=/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){3,15}$/;
    return patrn.test(str);
}

//检测是否都为中文汉字

function is_chinese(str){
    var patrn =/^[\u4E00-\u9FA5]*$/;
    return patrn.test(str);
}

//判断是否为合法日期格式(例如：2004-01-02)
function is_date(str){
    var patrn =/^(19|20)\d\d\-(0|1)\d\-(0|1|2|3)\d$/;
    return patrn.test(str);
}

//判断是否为数字
function is_numeric(str){
    var patrn =/^\d+(\.\d+)?$/;
    return patrn.test(str);
}

//判断是否为正整数
function is_int(str){
    var patrn =/^\d+?$/;
    return patrn.test(str);
}



//从浏览器计算高度，easyui-datagrid用
function getgridwidht(){
    var wh = {
        height:50,
        width:10
    };
    //以下进行测试
    if($.browser.msie) {
        wh.height = 60;
        wh.width= 10; 
        if(jQuery.browser.version <= 7.0)
            wh.height = 70;
        wh.width= 20;
    }
    if($.browser.mozilla) wh.height= 88;
    wh.width= 10;
    if($.browser.opera) wh.height= 50;
    if($.browser.safari) wh.height= 30;
    wh.width= 10;
    return wh;
}
/*
 * 列表显示，鼠标选中效果，主要是为了支持ie6
 * 不考虑ie6，可以用css替代
*/
$(function(){
    $("#myListTable tbody tr").each(function(){
        $(this).bind('mouseover',function(){
            $(this).find("td").each(function(){			
                $(this).css({
                    background:"#e8f3ff"
                });
            });
        });
        $(this).bind('mouseout',function(){
            $(this).find("td").each(function(){			
                $(this).attr('style','');
            });
               
        });
    });
});

//搜索时的展开高级按钮
function chg_advance_mode()
{
    var t =  document.getElementById('advance_search_mode').style.display;
    if(t == 'none'){
        $('#advance_search_mode').show('slow');
        $('#advance_mode_valve').val(1);
    }
    else{
        $('#advance_search_mode').hide('slow');
        $('#advance_mode_valve').val(0);
		
    }
}

/* 
 * 删除链接 
 * 点击删除按钮后，提示对话框，然后message提示结果。
 * 使用方法：在 设置 link 的class为 delete
 */
$('#myListTable a.delete').live('click',function(){
    var url = $(this).attr('ref');
    if(confirm("删除数据,你确定吗?")) {
        //window.location.href=url;
        $.ajax({
            url: url,
            context: document.body,
            dataType: 'json',
            success: function(data){
                $.colorbox({ 
                    title: data.info, 
                    html: '<div class="msg">'+ data.info + '</div>',
                    onClosed:function(){
                        window.location.reload();
                    }
                });
            }
        });
    }
    else 
        return false;
});


function addDashboardTab(){
    $('#tt').tabs('add',{
        title:'我的桌面',
        content:'<iframe scrolling="yes"  crossframe="false" frameborder="0"  src="?m=index&a=main" style="width:100%;height:100%;"></iframe>',
        iconCls:'icon-tci_house_go',
        closable:false
    });
}
//添加tab
$('a.table_open').live('click',function(){
    var $tabs = parent.$('#tabs');
   if(typeof($tabs.tabs) == 'function'){
        var tab_id = $(this).attr('rel');
        var title = $(this).attr('title');
        var div = parent.$('#tabs '+tab_id);
        if(div.length == 0){
            $tabs.tabs("add", tab_id, title);
            loadTabFrame($(this).attr("rel"),$(this).attr("href"));
        } else {
            $tabs.tabs("select", tab_id);
        }
        return false;
    }
    
});

function loadTabFrame(tab, url) {
    if (parent.$(tab).find("iframe").length == 0) {
        var html = [];
        html.push('<div class="tabIframeWrapper">');
        html.push('<iframe class="iframetab" scrolling="auto" frameborder="0" src="' + url + '">Load Failed?</iframe>');
        html.push('</div>');
        parent.$(tab).append(html.join(""));
        var height_fix = 170;
        if($.browser.msie) {
            if(jQuery.browser.version <= 7.0){
                height_fix = 170;
            }
        }
        parent.$(tab).find("iframe").height($(parent).height()-height_fix);
    }
    return false;
}

//关闭tab
$('a.tab_close').live('click',function(){
    var $tabs =parent.$('#tabs');
    if(typeof($tabs.tabs) == 'function'){
        var index = $(this).attr('rel');
         //console.log(index);
        $tabs.tabs("remove", index );
        return false;
   }
});

/**     
 * 刷新tab 
 * @cfg  
 *example: {tabTitle:'tabTitle',url:'refreshUrl'} 
 *如果tabTitle为空，则默认刷新当前选中的tab 
 *如果url为空，则默认以原来的url进行reload 
 */  
function refreshTab(cfg){  
    var refresh_tab = cfg.tabTitle?$('#tt').tabs('getTab',cfg.tabTitle):$('#tabs').tabs('getSelected');  
    if(refresh_tab && refresh_tab.find('iframe').length > 0){  
        var _refresh_ifram = refresh_tab.find('iframe')[0];  
        var refresh_url = cfg.url?cfg.url:_refresh_ifram.src;  
        //_refresh_ifram.src = refresh_url;  
        _refresh_ifram.contentWindow.location.href=refresh_url;  
    }  
} 
//按百分比获计算宽度，easyui-datagrid用
function fixWidth(percent)  
{  
    return $(document).width() * percent ; //这里你可以自己做调整  
}         

//复制
function setText(id){
    if(copy2Clipboard(id)!=false){
        alert("生成的代码已经复制到粘贴板，你可以使用Ctrl+V 贴到需要的地方去了哦！  ");
    }
}
copy2Clipboard=function(txt){
    if(window.clipboardData){
        window.clipboardData.clearData();
        window.clipboardData.setData("Text",txt);
    }
    else if(navigator.userAgent.indexOf("Opera")!=-1){
        window.location=txt;
    }
    else if(window.netscape){
        try{
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        }
        catch(e){
            alert("您的firefox安全限制限制您进行剪贴板操作，请打开’about:config’将signed.applets.codebase_principal_support’设置为true’之后重试，相对路径为firefox根目录/greprefs/all.js");
            return false;
        }
        var clip=Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
        if(!clip)return;
        var trans=Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
        if(!trans)return;
        trans.addDataFlavor('text/unicode');
        var str=new Object();
        var len=new Object();
        var str=Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext=txt;
        str.data=copytext;
        trans.setTransferData("text/unicode",str,copytext.length*2);
        var clipid=Components.interfaces.nsIClipboard;
        if(!clip)return false;
        clip.setData(trans,null,clipid.kGlobalClipboard);
    }
}

//panel 的　缩放效果
$('.box-tool-collapse').live('click',function(){
    $(this).parents('.box').eq(0).children(".box-body").slideToggle();
    $(this).attr('class','box-tool-expand');
});
$('.box-tool-expand').live('click',function(){
    $(this).parents('.box').eq(0).children(".box-body").slideToggle();
    $(this).attr('class','box-tool-collapse');
});
 