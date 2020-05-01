<?php

print "hello"

?>

<script>
var address = "rtsp://192.168.0.124:557/h264Preview_01_sub";

var output = '<object width="640" height="480" id="qt" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab">';
    output += '<param name="src" value="'+address+'">';
    output += '<param name="autoplay" value="true">';
    output += '<param name="controller" value="false">';
    output += "<embed id=\"plejer\" name=\"plejer\" src=\"/poster.mov\" bgcolor=\"000000\" width=\"640\" height=\"480\" scale=\"ASPECT\" qtsrc=\"" +address+ "\"  kioskmode=\"true\" showlogo=\"false\" autoplay=\"true\" controller=\"false\" pluginspage=\"http://www.apple.com/quicktime/download/\">";
    output += '</embed></object>';

    //SET THE DIV'S ID HERE
    //document.getElementById(window).innerHTML = output;
    document.innerHTML = output;
</script>
