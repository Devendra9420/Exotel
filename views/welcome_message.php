<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>File Upload Library</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	
	.button {
	    border: 1px solid #006;
	    background: #9cf;
	}
	input {
	    border: 1px solid #006;
	    background: #ffc;
	}
	</style>
</head>
<body>
<?php 
$image = array(
		'name'        => 'image',
		'id'          => 'image',
);

$video = array(
		'name'        => 'video',
		'id'          => 'video',
);

$image_resize = array(
		'name'        => 'image_resize',
		'id'          => 'image_resize',
		'size'		  => '50',
);

$image_thumb = array(
		'name'        => 'image_thumb',
		'id'          => 'image_thumb',
		'size'		  => '50',
);

?>
<div id="container">
	<h1>File Upload Library!</h1>

	<div id="body">
		<p>You can try to upload file but first configure your file_upload config file.</p>
		<code>application/config/file_upload.php</code>
		
		<p>Select image file to upload.</p>
		<code>
		<?php echo form_open_multipart('welcome/image_upload'); ?>
		<?php echo form_label('Image File', $image['name']); ?>						
		<?php echo form_upload($image);?>
		<p><?php if($message = $this->session->flashdata('image_message')) var_dump($message);?></p>
		<p><?php echo form_submit('Upload', 'Upload!', "class='button'");?></p>
		<?php echo form_close(); ?>
		</code>
		
		<p>Select video file to upload.</p>
		<code>
		<?php echo form_open_multipart('welcome/video_upload'); ?>
		<?php echo form_label('Video File', $video['name']); ?>						
		<?php echo form_upload($video)?>
		<p><?php if($message = $this->session->flashdata('video_message')) var_dump($message);?></p>
		<p><?php echo form_submit('Upload', 'Upload!', "class='button'");?></p>
		<?php echo form_close(); ?>
		</code>
		
		<p>Input image file path to resize.</p>
		<code>
		<?php echo form_open('welcome/image_resize'); ?>
		<?php echo form_label('Image File', $image_resize['name']); ?>						
		<?php echo form_input($image_resize)?>
		<p><?php if($message = $this->session->flashdata('image_resize_message')) var_dump($message);?></p>
		<p><?php echo form_submit('Resize', 'Resize!', "class='button'");?></p>
		<?php echo form_close(); ?>
		</code>
		
		<p>Input image file path to create thumbnail.</p>
		<code>
		<?php echo form_open('welcome/image_thumb'); ?>
		<?php echo form_label('Image File', $image_thumb['name']); ?>						
		<?php echo form_input($image_thumb)?>
		<p><?php if($message = $this->session->flashdata('image_thumb_message')) var_dump($message);?></p>
		<p><?php echo form_submit('Create thumbnail', 'Create Thumbnail!', "class='button'");?></p>
		<?php echo form_close(); ?>
		</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>