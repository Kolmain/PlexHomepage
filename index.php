<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="plexlanding.ico" />`
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        body.offline #link-bar {
            display:none;
        }

        body.online  #link-bar{
            display:block;
        }
    </style>
    <script src="assets/js/ping.js"></script>
    <script type='text/javascript'>
        HTMLElement.prototype.hasClass = function (className) {
            if (this.classList) {
                return this.classList.contains(className);
            } else {
                return (-1 < this.className.indexOf(className));
            }
        };

        HTMLElement.prototype.addClass = function (className) {
            if (this.classList) {
                this.classList.add(className);
            } else if (!this.hasClass(className)) {
                var classes = this.className.split(" ");
                classes.push(className);
                this.className = classes.join(" ");
            }
            return this;
        };

        HTMLElement.prototype.removeClass = function (className) {
            if (this.classList) {
                this.classList.remove(className);
            } else {
                var classes = this.className.split(" ");
                classes.splice(classes.indexOf(className), 1);
                this.className = classes.join(" ");
            }
            return this;
        };

        function checkServer() {
            var p = new Ping();
            var server = "mydomain.tld"; //Try to get it automagically, but you can manually specify this
            var timeout = 2000; //Milliseconds
            var body = document.getElementsByTagName("body")[0];
            p.ping(server+":32400", function(data) {
                var serverMsg = document.getElementById( "server-status-msg" );
                var serverImg = document.getElementById( "server-status-img" );
                if (data < 1000){
                    serverMsg.innerHTML ='Up and Reachable!';
                    serverImg.src = "assets/img/ipad-hand-on.png";
                    body.addClass('online').removeClass("offline");
                }else{
                    serverMsg.innerHTML = 'Down and Unreachable.';
                    serverImg.src = "assets/img/ipad-hand-off.png";
                }
            }, timeout);
        }
        $(function() {
            $('.error').hide();
            $(".subbutton").click(function() {
            
              // validate and process form here
             
              $('.error').hide();
              var name = $("#name").val();
                if (name == "") {
                toastr.warning('Please enter your name.');
                $("#name").focus();
                return false;
              }
                var email = $("#email").val();
                if (email == "") {
                toastr.warning('Please enter a valid e-mail address.');
                $("#email").focus();
                return false;
              }
              var email = $("#email").val();
                if ( !isValidEmailAddress( email ) ) {
                toastr.warning('Please enter a valid e-mail address.');
                $("#email").focus();
                return false;
              }
                var message = $("#message").val();
                if (message == "") {
                toastr.warning('Please enter the details of your report.');
                $("#message").focus();
                return false;
              }
              
              
          var dataString = '<p><strong>Name: </strong> '+ name + '</p><p><strong>Email: </strong> ' + email + '</p><p><strong>Report: </strong> ' + message + '</p>';
          $.ajax({
            type: "POST",
            url: "send.php",
            data: { data: dataString, senderAddress: email },
            success: function() {
            
                toastr.success('Report submitted.' , 'Thank you!')
                $('#myModal').modal('toggle');
            }
          });
          return false;
            
            });
        });
          


        // Validate the email address
        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        };
    </script>
    
    <title>mydomain.tld</title>
        

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Fonts from Google Fonts -->
    <link href='//fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
    
  
  </head>

  <body onload="checkServer()" class="offline"><!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Submit A Report</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal contact" name="contact" id="contact" action="">
                <div class="form-group">
                    <label class="control-label col-md-4" for="name">Name:</label>
                    <div class="col-md-6">
                        <input type="name" rows="6" class="form-control" id="name" name="name" placeholder="Jack Black"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="email">E-Mail:</label>
                    <div class="col-md-6">
                        <input type="name" class="form-control" id="email" name="email" placeholder="jack@black.com"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="message">Report:</label>
                    <div class="col-md-6">
                        <textarea rows="6" class="form-control" id="message" name="message" placeholder="Robert Downey Jr. isn't white in Tropic Thunder (1080p), something's wrong!"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-success subbutton" type="submit" value="Submit" id="submit">
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </form>
        </div><!-- End of Modal body -->
        </div><!-- End of Modal content -->
        </div><!-- End of Modal dialog -->
    </div>
<!-- End of Modal -->
  
    
        
        <div class="row mt centered">
            <div class="col-lg-4">
                <a href="https://mydomain.tld/plex">
                <img src="assets/img/s01.png" width="180" alt="">
                <h4>Watch</h4>
                <p>Access the Plex library with over 471 Movies & 142 TV Shows available instantly.<p>
                </a>
            </div><!--/col-lg-4 -->

            <div class="col-lg-4">
                <a href="https://mydomain.tld/requests">
                <img src="assets/img/s02.png" width="180" alt="">
                <h4>Request</h4>
                <p>Want to watch a Movie or TV Show but it's not currently on Plex? Request it!</p>
                </a>
            </div><!--/col-lg-4 -->

            <div class="col-lg-4">
                <a href="#myModal" data-toggle="modal">
                <img src="assets/img/s03.png" width="180" alt="">
                <h4>Report</h4>
                <p>Something not working? Report playback issues and network outages so we can get it working.</p>
                </a>
            </div><!--/col-lg-4 -->

            
        </div><!-- /row -->
    </div><!-- /container -->
    <p>

    <div id="headerwrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1><br/>
                    <center>Plex Status:</h1></center>
                    <center><h4 id="server-status-msg">Checking...</h4></center><br/>
                    <br/>
                    <br/>
                    <form class="form-inline" role="form">
                      <div class="form-group">
                        
                      </div>
                                    
                </div><!-- /col-lg-6 -->
                <div class="col-lg-6">
                    <img id="server-status-img" class="img-responsive" src="assets/img/ipad-hand.png" alt="">
                </div><!-- /col-lg-6 -->
            
        </div><!-- /row -->
    </div><!-- /container -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-74175710-2', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>