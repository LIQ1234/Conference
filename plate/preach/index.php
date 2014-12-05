<!DOCTYPE html>
<html>
<head>
<title>宣讲会报名</title>
</head>
<body>

<h1>报名信息</h1>
<form id="form1" name="form1" method="post" action="api.php" onSubmit="return checkform()">
  <input name="action" type="hidden" value="sendaction" />
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

    <tr>
      <td>公司：<input name="company" type="text" id="company" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td>姓名：<input name="username" type="text" id="username" />
       <span class="red"> *</span></td>
    </tr>
    <tr>
      <td>邮件：<input name="email" type="text" id="email" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td>电话：<input name="tel" type="text" id="tel" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td >交流会：
        <input style="width:8%" type="radio" name="sex" value="参加" checked>
        参加
        <input style="width:8%" width="8%" type="radio" name="sex"   value="不参加">
        不参加</td>
    </tr>

    <tr>
      <td align="center"><input type="submit" name="button" id="button" value="提交信息" /></td>
    </tr> 

    <tr>
        <td>若您无法填写以上报名信息，请发邮件到：reg@idacker.com，参阅邮件的指导，完成会议注册。</td>
    </tr>
  </table>
</form>

<script type="text/javascript">

function checkform(){
    if ($('#company').val()=='') {
        alert('请填写公司名称');
         return false;
    };
    if($('#username').val()==''){
        alert('请填写姓名');
        return false;
    }
    if($('#email').val()==''){
        alert('请填写邮件地址');
        return false;
    }
    if($('#tel').val()==''){
        alert('请填写手机号码');
        return false;
    }
}
</script>
</body>
</html>

