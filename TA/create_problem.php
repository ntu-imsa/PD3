<?php
	session_start() ;
	require_once('../includes/lib.inc.php');

	$acc = mysql_real_escape_string($_SESSION['account']);

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
	<form method="POST" action = "TA/create.php" id="fileUploadForm" enctype="multipart/form-data">
	<div class="hero-unit upload_section">
		<p class="hw-id"> 作業序號放這裡 </p>
		<p class="hw"> Problem: <input name="p-id" id="p-id" /></p>
		<p class="hw"> File format: .pdf </p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>
					<input type="file" class="pdfupload" name="pdfupload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>

			</div>
		</div>
		<p class="hw">Type:
			<select name="type">
				<option value="0">Normal</option>
				<option value="1">Special Judge</option>
				<option value="2">Interactive</option>
				<option value="3">Debug Challenge</option>
			</select>
		</p>
		<p class="hw">Deadline: <input type="datetime-local" name="deadline" placeholder="yyyy-mm-dd hh:mm:ss" step="1" style="width: 250px" /></p>
		<div class="checkbox">
      		<label>
        	<input type="checkbox" name="submitcode" value="1"> Submit code
      		</label>
      		<label>
        	<input type="checkbox"  name="submitpdf" value="1"> Submit pdf
      		</label>
    	</div>
		<br>
    	<br>
    	<p class="hw"> Total Testdata：
    	<input class="form-control" id="datanum" type="number" min="1" value="1" name="datanum"></p>
    	<br>
		<div id="data-block" style="display:none;">
			<div class="data-id hw">Testing Data <span class="data-id"></span></div>
			<div class="checkbox">
				<label><input type="checkbox" name="tdhid[]" value="1"> Hidden</label>
			</div>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<span class="hw">Input:</span>
				<div class="input-append">
					<div class="uneditable-input span3">
						<i class="icon-file fileupload-exists"></i>
						<span class="fileupload-preview"></span>
	  				</div>
					<span class="btn btn-file">
						<span class="fileupload-new">Select file</span>
						<span class="fileupload-exists">Change File</span>
						<input type="file" class="upload" name="tdinput[]"/>
					</span>
					<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<span class="hw">Output:</span>
				<div class="input-append">
					<div class="uneditable-input span3">
						<i class="icon-file fileupload-exists"></i>
						<span class="fileupload-preview"></span>
	  				</div>
					<span class="btn btn-file">
						<span class="fileupload-new">Select file</span>
						<span class="fileupload-exists">Change File</span>
						<input type="file" class="upload" name="tdoutput[]"/>
					</span>
					<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
			<div><span class="hw">Score:</span>
    			<input class="form-control" id="focusedInput" type="text" value="0" name="score[]"></p>
			</div>
		</div>
		<div id="datas">
		</div>
		<a class="btn fileupload-exists upload-button" >Create</a>
		<script src="js/upload.js"></script>
		<script src="js/create.js"></script>
	</form>
<?php
	}
?>
