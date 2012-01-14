<html>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

<table width="100%" bgcolor="#cccccc" cellpadding="10" cellspacing="0">
	<tr valign="top" align="center">
		<td>
			<table width="500" cellpadding="20" cellspacing="0" bgcolor="#ffffff">
				<tr>
					<td>
						<h2><?php echo __('Contact request'); ?></h2>
					</td>
				</tr>
				<tr>
					<td style="padding: 15px">
						<?php echo $content_for_layout; ?>
					</td>
				</tr>
				<tr>
					<td style="padding: 15px; background: #bbbbbb" >
						<p style="margin:0px; padding:0px; font-family:'Lucida Grande',Verdana,Helvetica,Arial,sans-serif; line-height: 15px; font-size: 11px;">
							<?php echo $_SERVER['SERVER_NAME']; ?> | <?php echo strftime('%x %H:%M', mktime()); ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
