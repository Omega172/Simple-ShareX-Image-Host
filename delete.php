<?php
$secret_key = "SuperSecretKey";
$sharexdir = "img_host/";

if(isset($_REQUEST['secret']))
{
    if($_REQUEST['secret'] == $secret_key)
    {
        if((!isset($_REQUEST['user'])))
        {
            echo '"user" was not set.';
            exit(0);
        }

        if((!isset($_REQUEST['file'])))
        {
            echo '"file" was not set.';
            exit(0);
        }

        $dir = $sharexdir.$_REQUEST['user'].'/'.$_REQUEST['file'];
        if(is_dir($dir))
        {
            unlink($dir.'/index.html');
            unlink($dir.'/'.$_REQUEST['file'].'.png');

            if (!rmdir($dir))
            {
                echo 'File: '.$dir.' could not be deleted.';
            }
            else
            {
                echo 'File: '.$dir.' deleted.';
            }
        }
        else
        {
            echo 'File: '.$dir.' not found.';
        }
    }
    else
    {
        echo 'Invalid Secret Key';
    }
}
else
{
    echo 'No post data recieved';
}
?>