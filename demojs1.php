<html>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
     <script language="JavaScript" type="text/javascript"> var $jQuery = jQuery.noConflict(); </script>

     <script type="text/javascript">
 jQuery(document).ready(function()
 {
     jQuery("#example_link").on("click", function (event) 
     {      
       event.preventDefault(); // Recommended to stop the link from doing anything else
       document.dispatchEvent(new CustomEvent('funcIntraLaunch',
       {
          'detail': { task: 'run',
                   program: 'calc.exe:',
             workingfolder: '',
                  switches: '',
               windowstate: 'max',
                 recallapp: '',
                   options: '',
                       log: '',
                 playsound: '',
                showerrors: 'true'
                    } })); 
                      });
            });
       </script>

         <body>
           <a href="#" id="example_link">Click me</a>
        </body>
          </html>