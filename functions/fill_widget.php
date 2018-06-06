  <?php
	include "conf.php";
	
	if(isset($_GET['select_interactive_part']))
	{
		if($_GET['select_interactive_part']==1)
		{
			$query_select_mywidget = "SELECT id, title_widget FROM tbl_install_widget WHERE user_id=".$_GET['USERID'];
			
			$result_select_mywidget = $connection->query($query_select_mywidget);
			$option_Select_items = "<option value=\"0\">Select Widget item</option>";
			
			while($row = $result_select_mywidget->fetch_row())
			{
				if(isset($_GET['interactive_items']))
				{ 
					if($_GET['interactive_items']==$row[0])
					{ 
						$option_Select_items .= "<option selected value=\"".$row[0]."\">".$row[1]."</option>";
					}
					else
					{
						$option_Select_items .= "<option value=\"".$row[0]."\">".$row[1]."</option>";
					}
				}
				else
				{
					$option_Select_items .= "<option value=\"".$row[0]."\">".$row[1]."</option>";
				}
				
			}
		}
		else if($_GET['select_interactive_part']==2)
		{
			$option_Select_items = "<option value=\"0\">Select Interactive item</option>";
		}
		else
		{
			$option_Select_items = "<option value=\"0\">No Select items</option>";
		}
	}
	else
	{
		$option_Select_items = "<option value=\"0\">No Select items</option>";
	}
	
	echo $option_Select_items;
	
?>