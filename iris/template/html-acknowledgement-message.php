<?php
use Iris\Config;
function getHTMLAcknowledgementMessage($lang, $name, $email, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $acknowledgement)
{
    ob_start();
    ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Collaboration Café Contact Form</title>
<style>
.item-body {
	margin: 0;
	font-family: 'HelveticaNeue', Helvetica, Arial, sans-serif;
	box-sizing: border-box;
	font-size: 13px;
	color: #616161;
	-webkit-font-smoothing: antialiased;
	-webkit-text-size-adjust: none;
	width: 100% !important;
	height: 100%;
	line-height: 1.6em;
	background-color: #f0f0f0;
}
</style>
</head>
<body itemscope itemtype='http://schema.org/EmailMessage'
	class="item-body">
	<table
		style='vertical-align: top; background-color: #f0f0f0; width: 100%; border: 1px solid #e4e4e4;'>
		<tr>
			<td width='600'
				style='vertical-align: top; padding: 0 !important; width: 100% !important;'>
				<div
					style='max-width: 600px; margin: 0 auto; display: block; padding: 20px;'>
					<table width='100%' cellpadding='0' cellspacing='0'
						style='background-color: #fff; border-radius: 5px; border: 1px solid #e4e4e4;'>
						<tr>
							<td style='padding: 20px;'>
								<table width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td>Hello <?php echo $name;?>,</td>
									</tr>
									<tr>
										<td style='padding-bottom: 10px;'><?php echo $acknowledgement;?>
                                        </td>
									</tr>

									<tr>
										<td>
											<hr />
										</td>
									</tr>
                                    <?php if(Config::FIELD_NAME[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_name');?>:</strong>
                                        <?php echo $name; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_EMAIL[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_email');?>:</strong>
                                        <?php echo $email; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_TELEPHONE[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_telephone');?>:</strong>
                                        <?php echo $telephone; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_WEBSITE[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_website');?>:</strong>
                                        <?php echo $website; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_ADDRESS[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_address');?>:</strong>
                                        <?php echo $address; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_DEPARTMENT[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_department');?>:</strong>
                                        <?php echo $department; ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <?php if(Config::FIELD_HEAR_ABOUT[0] == true) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_hear_about');?>:<br></strong>
                                        <?php

        if (! empty($hearAbout)) {
            foreach ($hearAbout as $hearAbouts) {

                echo $hearAbouts . "<br>";
            }
        }
        ?>
                                        </td>
									</tr>
                                    <?php }?>
                                             <?php if(Config::FIELD_PRIORITY[0] == true && ! empty($priority)) {?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_priority');?>:</strong>
                                        <?php

        if (! empty($priority)) {
            echo implode(', ', $priority);
        }
        ?>
                                        </td>
									</tr>
                                    <?php }?>
                                    <tr>
										<td><strong><?php echo $lang->value('label_message');?>:</strong>
                                        <?php echo nl2br($message);?>
                                        </td>
									</tr>

								</table>
							</td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>
</body>
</html>
<?php
    return ob_get_clean();
}
?>
