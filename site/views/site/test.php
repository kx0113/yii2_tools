<HTML>
<HEAD>
    <TITLE>GetLocalIP</TITLE>
</HEAD>
<BODY>
获取IP:
<script language="JavaScript"> function GetLocalIPAddr(){ var oSetting = null; var ip = null; try{ oSetting = new ActiveXObject("rcbdyctl.Setting"); ip = oSetting.GetIPAddress; if (ip.length == 0){ return "没有连接到Internet"; } oSetting = null; }catch(e){ return ip; } return ip; } document.write(GetLocalIPAddr()+"<br/>") </script>
</BODY>
</HTML>