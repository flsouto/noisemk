<?php

if(!empty($_REQUEST['get_data'])){
    $contents = file_get_contents($_REQUEST['get_data']);
    $ext = pathinfo($_REQUEST['get_data'], PATHINFO_EXTENSION);
    die('data:audio/'.$ext.';base64,'.base64_encode($contents));
}

$params = file_get_contents(__DIR__.'/params.json');
$params = json_decode($params,true);

$target_dir = $params['target_dir'];

$files = glob($target_dir."/*.{mp3,wav}",GLOB_BRACE);
shuffle($files);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Noisemk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

    <div>
        <div>
            <span id="file_name"></span> &nbsp;&nbsp;
            <span id="counter">0</span> of <?php echo count($files); ?>
        </div>

        <hr/>

        <button id="btn_play" onClick="playCurrent()">Play</button> &nbsp;&nbsp;&nbsp;
        <button id="btn_next" onclick="setNextAndPlay()">Next</button> &nbsp;&nbsp;&nbsp;
        <button id="btn_move" onClick="moveCurrent()">Move</button> &nbsp;&nbsp;&nbsp;
        <button id="btn_rm" onclick="removeCurrent()">Delete</button>
    </div>

    <script>

        var files = <?php echo json_encode($files); ?>;

        var current = null;
        var currentAudio = null;

        function setNext(){
            if(files.length === 0){
                $('body').html('Done!');
                return false;
            }

            if(currentAudio){
                currentAudio.done(function(a){
                    a.pause();
                });
            }

            current = files.pop();
            currentAudio = $.get('?get_data='+current).pipe(function(data){
                return new Audio(data);
            });
            $('#file_name').text(current);
            $('#counter').text(parseInt($('#counter').text())+1);
            return true;
        }

        function setNextAndPlay(){
            if(setNext()){
                playCurrent();
            }
        }

        setNext();

        function playCurrent(){
            currentAudio.done(function(a){
                a.currentTime = 0;
                a.play();
            })
        }

        function removeCurrent(){
            $.get('?rm='+current);
            setNextAndPlay();
        }

        function moveCurrent(){
            $.get('?mv='+current);
            setNextAndPlay();
        }

    </script>

</body>
</html>