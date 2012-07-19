<?php

if ( ! empty($_POST['is_submitted']) && $_POST['is_submitted'] == 1) {
	if ( ! empty($_FILES['uploadedfile']) && is_array($_FILES['uploadedfile'])
		&& ! empty($_FILES['uploadedfile']['name']) && trim($_FILES['uploadedfile']['name']) != ''
		&& ! empty( $_FILES['uploadedfile']['tmp_name']) && trim( $_FILES['uploadedfile']['tmp_name']) != '') {
	
		$s3 = new AmazonS3(array(
			'key' => KEY,
			'secret' => SECRET,
		));
		$response = $s3->create_object(MAIN_BUCKET, $_FILES['uploadedfile']['name'],
				array('fileUpload' => $_FILES['uploadedfile']['tmp_name']));

		if ($response->isOK())
		{
			echo "First upload successful!";
		}
	} else {
		echo 'Select a file!';
	}
}
?>
<form name="upload-s3" id="upload-s3" method="POST" action="<?php echo BASE_URL ; ?>index.php?page=upload"  enctype="multipart/form-data">
	<input type="hidden" name="is_submitted" value="1" />
	<input name="uploadedfile" type="file" /><br />
	<input type="submit" value="Upload File" />
</form>
