<div class="events form">
<?php
  echo $this->Form->create('Event', array('type' => 'file'));
?>
	<fieldset>
		<legend><?php echo __('Import analysis file'); ?></legend>
<<<<<<< HEAD
		<?php
			echo $this->Form->input('analysis_file', array(
					'label' => '<b>Analysis file</b>',
					'type' => 'file',
			));
			?>
				<div class="input clear"></div>
			<?php
			// echo $this->Form->input('publish', array(
			// 		'checked' => false,
			// 		'label' => __('Publish imported events'),
			// ));
		?>
=======
<?php
	echo $this->Form->input('analysis_file', array(
			'label' => '<b>Analysis file</b>',
			'type' => 'file',
	));
	?>
		<div class="input clear"></div>
	<?php
	// echo $this->Form->input('publish', array(
	// 		'checked' => false,
	// 		'label' => __('Publish imported events'),
	// ));
?>
>>>>>>> 08b81f6... added first stage of digital forensics - timeline analysis
	</fieldset>
<?php
	echo $this->Form->button(__('Upload'), array('class' => 'btn btn-primary'));
	echo $this->Form->end();
?>
<<<<<<< HEAD
	<div id="afterUpload" style="display:none;">
		<div id="object_templates" style="display:none;">
			<div class="">
				<?php
				echo $this->Form->create('SelectedData', array('enctype' => 'application/Json'));
				?>
				<div style="display:none;">
					<fieldset>
						<?php
							echo $this->Form->input('mactime_data', array(
									'type' => 'text'
							));
							?>
								<div class="input clear"></div>
							<?php
						?>
						<?php
							echo $this->Form->input('mactime_file_content', array(
									'type' => 'text'
							));
							?>
								<div class="input clear"></div>
							<?php
						?>
						<?php
							echo $this->Form->input('mactime_file_name', array(
									'type' => 'text'
							));
							?>
								<div class="input clear"></div>
							<?php
						?>
					</fieldset>
				</div>
				
				<?php
					echo $this->Form->button(__('Create Objects'), array('class' => 'btn btn-primary'));
					echo $this->Form->end();
				?>
			</div>
		</div>
		<div style="clear:both;"></div>
		<input id="file_name" type="hidden" value="<?php if($file_uploaded == "1") { echo h($file_name); } ?>">
		<div id="accordion1" style="">
			<h3>Select text for further analysis</h3>
			<div id="textToSelect" class="raisedbox noselect">
				<div id="fileContent" style="display:none;">
					<p>	
					<?php
						if($file_uploaded == "1")
						{
							echo h(nl2br($file_content));
						}
					?>
				</p>
				</div>
				<table id="individualLines" class="selectedLines">
					<thead>
						<th>Select</th>
						<th>Filepath</th>
						<th>File Size</th>
						<th>Activity Type</th>
						<th>Time Accessed</th>
						<th>Permissions</th>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			
		</div>
		<div style="clear:both;"></div>
	</div>
	
</div>

<?php
	$event['Event']['id'] = $eventId;
	echo $this->element('side_menu', array('menuList' => 'event', 'menuItem' => 'addAttribute', 'event' => $event));
?>
<style>
	.selectedLines td, 
	.selectedLines th {
		border:solid 2px #0044cc;
	}
	.selectedLines
	{
		width: 100%;
	}
	.noselect {
    cursor: default;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
<script>
var afterUpload = "<?php echo $file_uploaded; ?>";
var selText = clearText =fileContent = '';
var linesArray = [];
var rowSelected;
$("#accordion1").accordion({
	heightStyle: "content" 
    })
$("#accordion2").accordion({
	  heightStyle: "content" 
    })
if(afterUpload == 1)
{
	$('#afterUpload').show();
	fileContent = $("#fileContent").text()
	$('#SelectedDataMactimeFileContent').val(fileContent);
	$('#SelectedDataMactimeFileName').val($("#file_name").val());
	linesArray = $("#fileContent").text().trim().split("<br />");
	$("#fileContent").empty();
	for(var i=0; i<linesArray.length;i++)
	{
		processString(linesArray[i]);
		
	}
}
$("input[type='checkbox']").change(function (e) {

	var SelectedData = new Array();
	var i = 0;
	$('#individualLines').find('tr').each(function () {
        var row = $(this);
		if (row.find('input[type="checkbox"]').is(':checked')) {

			SelectedData[i]={
				"filepath" : $(row).find('td:eq(1)').text(),
				"file_size" :$(row).find('td:eq(2)').text(),
				"activity_type" : $(row).find('td:eq(3)').text(),
				"time_accessed" : $(row).find('td:eq(4)').text(),
				"permissions" : $(row).find('td:eq(5)').text(),
				"file_name" : $("#file_name").val()
			}
			i++;
		}
		
    });
	if(i > 0)
	{
		$('#object_templates').show();
		SelectedData =JSON.stringify(SelectedData);
		$('#SelectedDataMactimeData').val(SelectedData);
	}
	else
		$('#object_templates').hide();
	

	
});


function processString(text)
{
	var time_accessed = "";
	var size =activity_type = permissions = file_path = activity = time_accessed = "";
	//full date and time expression
	var Regx1 = /(Mon|Tue|Wed|Thu|Fri|Sat|Sun)\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d\d?).+?(\d\d\d\d)\s([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]/;
	//time expressions
	var Regx2 = new RegExp("([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]");
	var arr = Regx1.exec(text);
	
	if(Regx2.exec(text) != null)
	{
		if(arr != null)
		{
			time_accessed = arr[0];
			text = text.replace(arr[0],'').trim();
		}
		
		text = text.replace(/[\n\r]/g, '').trim();
		seperate_analysis = text.split(/[  ]+/);
		size = seperate_analysis[0];
		activity_type = seperate_analysis[1];
		if(activity_type.includes('a'))
		{
			activity = "Accessed";
		}
		if(activity_type.includes('b'))
		{
			activity += (activity != '')?',':'';
			activity += "Created";
		}
		if(activity_type.includes('c'))
		{
			activity += (activity != '')?',':'';
			activity += "Changed";
		}
		if(activity_type.includes('m'))
		{
			activity += (activity != '')?',':'';
			activity += "Modified";
		}
		
		permissions = seperate_analysis[2];
		filepath = seperate_analysis[6]
		if(seperate_analysis[7])
		{
			filepath += seperate_analysis[7];
		}
		$("#individualLines").find('tbody')
			.append($('<tr>')
				.append($('<td>').html('<input type="checkbox" class="select"></input>'))
				.append($('<td>').text(filepath))
				.append($('<td>').text(size))
				.append($('<td>').text(activity))
				.append($('<td>').text(time_accessed))
				.append($('<td>').text(permissions))
				
				
		);
	}
	
		
}
function unhighlight(){
 var fileTable = document.getElementById('individualLines');
 for (var i=0;i < fileTable.rows.length;i++){
   var row = fileTable.rows[i];
   row.style.backgroundColor='transparent';
   row.hilite = false;
 }
}


</script>
=======
<div id="afterUpload" style="display:none;">
	<button id="graspSelectedText" class="actions" style="display:none;">Add Selected Text</button>
	<button id="clearSelectedText" class="actions" style="display:none;">Clear Selected Text</button>
	<div style="clear:both;"></div>
	<div id="textToSelect" class="raisedbox" onmouseup="GetSelectedText ()" style="width:40%; height:100%;float:left;">	
			<?php
				if($file_uploaded == "1")
				{
					echo nl2br($file_content);
				}
			?>
	</div>
	<div id="selectedText" class="raisedbox" style="width:45%; height:100%;float:right;">
		
	</div>
	<div style="clear:both;"></div>
	</div>
</div>


<?php
	echo $this->element('side_menu', array('menuList' => 'event-collection', 'menuItem' => 'addSTIX'));
?>
<script>
var afterUpload = "<?php echo $file_uploaded; ?>";
var selText = '';
if(afterUpload == 1)
{
	$('#afterUpload').show();
}
function GetSelectedText () {
	selText = '';
	if (window.getSelection) {
		if (document.activeElement && 
				(document.activeElement.tagName.toLowerCase () == "textarea" || 
				 document.activeElement.tagName.toLowerCase () == "input")) 
		{
			var text = document.activeElement.value;
			selText = text.substring (document.activeElement.selectionStart, 
									  document.activeElement.selectionEnd);
		}
		else {
			var selRange = window.getSelection ();
			selText = selRange.toString ();
		}
	}
	else {
		if (document.selection.createRange) {
			var range = document.selection.createRange ();
			selText = range.text;
		}
	}
	if (selText !== "") {
		$('#graspSelectedText').show();
		$('#clearSelectedText').show();
	}
	else
	{
		$('#graspSelectedText').hide();
		$('#clearSelectedText').hide();
	}
}
$('#graspSelectedText').on('click',function(){
	$('#selectedText').append(selText.replace(/(?:\r\n|\r|\n)/g, '<br>'));
	$('#selectedText').append('<br>')
})
$('#clearSelectedText').on('click',function(){
	$('#selectedText').empty();
})
</script>
<style>
	.raisedbox { 
	padding: 10px;
    border: 1px solid #77aaff;
	box-shadow:  -1px 1px #77aaff,
		 -2px 2px #77aaff,
		 -3px 3px #77aaff,
		 -4px 4px #77aaff,
		 -5px 5px #77aaff;
	}

</style>
>>>>>>> 08b81f6... added first stage of digital forensics - timeline analysis