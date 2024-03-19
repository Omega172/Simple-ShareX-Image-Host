<?php
$secret_key = "SuperSecretKey";
$sharexdir = "img_host/";
$domain_url = 'https://example.com/';
$lengthofstring = 16;

function RandomString($length) {
    $keys = array_merge(range(0,9), range('a', 'z'));

    $key = '';
    for($i=0; $i < $length; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}

if(isset($_POST['secret']))
{
    if($_POST['secret'] == $secret_key)
    {
        $filename = RandomString($lengthofstring);
        $target_file = $_FILES["sharex"]["name"];
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        if((!is_dir($sharexdir.$_POST['author'].'/'))) {
            mkdir($sharexdir.$_POST['author'].'/');
        }
        mkdir($sharexdir.$_POST['author'].'/'.$filename.'/');

        $html_file = fopen($sharexdir.$_POST['author'].'/'.$filename."/"."index.html", "wr");
        fwrite($html_file, '<!DOCTYPE html>');
        fwrite($html_file, '<meta content="'.$_POST['title'].'" property="og:title" />');
        fwrite($html_file, '<meta content="Author: '.$_POST['author'].'" property="og:description" />');
        fwrite($html_file, '<meta content="https://example.com/" property="og:url" />');
        fwrite($html_file, '<meta content="https://example.com/img_host/'.$_POST['author'].'/'.$filename.'/'.$filename.'.'.$fileType.'" property="og:image" />');
        fwrite($html_file, '<meta content="'.$_POST['color'].'" data-react-helmet="true" name="theme-color" />');
        fwrite($html_file, '<meta name="twitter:card" content="summary_large_image">');
        $url = 'https://example.com/img_host/'.$_POST['author'].'/'.$filename.'/'.$filename.'.'.$fileType;
        fwrite($html_file, '<meta http-equiv="Refresh" content="0; url='."'".$url."'".'" />');
        fclose($html_file);

        if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir.$_POST['author'].'/'.$filename.'/'.$filename.'.'.$fileType))
        {
            echo $domain_url.$sharexdir.$_POST['author'].'/'.$filename;
        }
            else
        {
           echo 'File upload failed - CHMOD/Folder doesn\'t exist?';
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