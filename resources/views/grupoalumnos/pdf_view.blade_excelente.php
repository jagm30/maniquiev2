<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
    <style>
            /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
            @page {
                margin: 0cm 0cm;
            }

            /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
            body {
                margin-top:    3.5cm;
                margin-bottom: 1cm;
                margin-left:   1cm;
                margin-right:  1cm;
                font-family: "Tahoma", serif;
            }

            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                bottom:   0px;
                left:     0px;
                top:     0px;
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    21.8cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
        </style>
</head>
<body>
     <div id="watermark">
             <img src="{{ public_path().'/images/formato1.jpg' }}" width="100%" height="100%">
        </div>

        <main> 
            

            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 8mm; top:93mm; right: 0px; height: 150px;  color:#2F4F4F;">34 - 34 - 34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 32mm; top: 95mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 78mm; top: 95mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 32mm; top: 101mm; right: 0px; height: 150px;  color:#2F4F4F;">-56</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 32mm; top: 106mm; right: 0px; height: 150px;  color:#2F4F4F;">..09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 26mm; top: 112mm; right: 0px; height: 150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 26mm; top: 118mm; right: 0px; height:150px;  color:#2F4F4F;">09 </p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 26mm; top: 124mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 78mm; top: 124mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 26mm; top: 130mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 78mm; top: 130mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 26mm; top: 136mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 42mm; top: 141mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 52mm; top: 147mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 52mm; top: 153mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 52mm; top: 159mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 52mm; top: 165mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>

            <!-- SEGUNDA COLUMNA -->
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 115mm; top:89mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 140mm; top: 95mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 133mm; top: 101mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 157mm; top: 106mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 124mm; top: 112mm; right: 0px; height: 150px;  color:#2F4F4F;">34</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 158mm; top: 118mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 115mm; top: 124mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 134mm; top: 130mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 138mm; top: 136mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 144mm; top: 141mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 132mm; top: 147mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 155mm; top: 159mm; right: 0px; height:150px;  color:#2F4F4F;">09</p>

            <!-- SEGUNDA COLUMNA -->

            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 18mm; top: 253mm; right: 0px; height:150px;  color:#2F4F4F;">56</p>
           
        </main> 

        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>