<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Upload Folder
|--------------------------------------------------------------------------
|
| Upload folder name. Folder where file will be uploaded.
|
*/
$config['upload_folder']	= 'uploads';
$config['media_url'] = base_url().$config['upload_folder'].'/';
/*
|--------------------------------------------------------------------------
| Set Max Width and Height
|--------------------------------------------------------------------------
|
| Sets the max width and height of image on or off i.e TRUE/FALSE
*/
$config['set_max'] = FALSE;

/*
|--------------------------------------------------------------------------
| Max Width and Height of image
|--------------------------------------------------------------------------
|
| Max width and height of image supported. This will be applied only if 
| set_max is TRUE. 
*/
$config['width']  = 1920;
$config['height'] = 1080;

/*
|--------------------------------------------------------------------------
| Width and Height of other size image
|--------------------------------------------------------------------------
|
| Sets the width and height of image.
 */
$config['other_width']  = 640;
$config['other_height'] = 480;

/*
|--------------------------------------------------------------------------
| Width and Height of thumbnail
|--------------------------------------------------------------------------
*/
$config['thumbnail_image_width']  = 125;
$config['thumbnail_image_height'] = 125;

/*
|--------------------------------------------------------------------------
| Upload format support
|--------------------------------------------------------------------------
| 
| File format to be used while uploading.
| 
*/
$config['image_upload_support'] = 'jpg|jpeg|png';
$config['video_upload_support'] = 'wmv|mpeg';

/*
|--------------------------------------------------------------------------
| Upload size support
|--------------------------------------------------------------------------
|
| File upload maximum size(in MB) supported
|
*/
$config['image_upload_size'] = 2048;
$config['video_upload_size'] = 5120;

/*
|--------------------------------------------------------------------------
| Maintain Ratio
|--------------------------------------------------------------------------
|
| Specifies whether to maintain the original aspect ratio when resizing or
| use hard values.
|
*/
$config['maintain_ratio'] = TRUE;

/*
|--------------------------------------------------------------------------
| Quality of the image
|--------------------------------------------------------------------------
|
| Sets the quality of the image. The higher the quality the larger the file size.
|
*/
$config['quality'] = '100%';

/*
|--------------------------------------------------------------------------
| Thumb Marker
|--------------------------------------------------------------------------
|
| Specifies the thumbnail indicator. It will be inserted just before the
| file extension, so mypic.jpg would become mypic_thumb.jpg.
|
*/
$config['thumb_marker'] = '_thumb';


/* End of file file_upload.php */
/* Location: ./application/config/file_upload.php */