<?php
header("Content-type:application/vnd.ms-excel"); 
date_default_timezone_set('PRC');
header("Content-Disposition:attachment;filename=$filename"); 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" 
 xmlns:x="urn:schemas-microsoft-com:office:excel" 
 xmlns="http://www.w3.org/TR/REC-html40"> 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 <html> 
     <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
          <style>
		/*
		table{border-right:1px solid #D0D7E5;border-bottom:1px solid #D0D7E5}
		td{border-left:1px solid #D0D7E5;border-top:1px solid #D0D7E5;text-align:center; font-size:16px;}
		*/
		<!--
				table{
				border-collapse:collapse;
				}
				td{
				/*background:#ffc;*/
				border:solid 1px #D0D7E5;
				height:22px;
				text-align:center; font-size:16px;
				}
				-->
		 </style> 
     </head> 
     <body> 
         <div id="Classeur1_16681" align=center x:publishsource="Excel"> 
             <table x:str border=0 cellpadding=0 cellspacing=0 width=50% > 
                 <tr>
				<?php $m=1;?>
				 <?php foreach($rescolumns as $key=>$row):?>
					<?php $aaa=",".$row['Field'].",";?>
					<?php if(strpos($row_user['mubanxuanze1'],$aaa)!==false):?>
					<td><?php echo $row['Comment']?></td>
					<?php $m++;?>
					<?php endif;?>
					
				<?php endforeach;?>
				
				 </tr> 
				 <?php
				 for($i=1;$i<100;$i++){
				 ?>
				 <tr>
				 	 <?php
					 for($j=1;$j<=($m-1);$j++){
					 ?>
						<td>&nbsp;</td> 
					<?php
					 }
					 ?>
				 <?php
				 }
				 ?>
				
             </table> 
         </div> 
     <!-- e.tclinfo.cn Baidu tongji analytics -->
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fc011e3de5770e054c74d2a04c79a9a61' type='text/javascript'%3E%3C/script%3E"));
</script>
</body> 
 </html> 