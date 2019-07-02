<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
					  
	global $currentInfo ;
	
	$out = '                 
        
                <div class="bootContainer">

            <div class="starter-template">

                <div class="bootContainer">


                    <!-- thumb navigation carousel -->



                    <!-- main slider carousel -->
                    <div class="row">
                        <div class="col-md-12" id="slider">

                            <div class="col-md-12" id="carousel-bounding-box">
                                <div id="myCarousel" class="carousel slide">
                                    <!-- main slider carousel items -->
                                    <div class="carousel-inner">
                                        <div class="active item" data-slide-number="0">
                                            <img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDamsLabs/labs/xDamsLabsxDamsPhoto/0?imageName=/high//IT/XDAMSXD/AMSLAB/SFT000/IT.XDAMSXD.AMSLAB.SFT000.0013.jpg" class="img-responsive" />
                                            <div class="carousel-caption">
                                                <h3>Titolo della prima slide</h3>
                                                <p>se vuoi  anche il sottotitolo</p>
                                            </div>
                                        </div>
                                        <div class="item" data-slide-number="1">
                                            <img src="http://battipaglia.thearchivescloud.org/wp-content/uploads/2016/04/roma.jpg" class="img-responsive"/>
                                            <div class="carousel-caption">
                                                <h3>Titolo della prima slide</h3>
                                                <p>se vuoi anche il sottotitolo</p>
                                            </div>
                                        </div>
                                        <div class="item" data-slide-number="2">
                                            <img src="http://battipaglia.thearchivescloud.org/wp-content/uploads/2016/04/milano-protesta.jpg" class="img-responsive"/>
                                            <div class="carousel-caption">
                                                <h3>Titolo della prima slide</h3>
                                                <p>se vuoi  anche il sottotitolo</p>
                                            </div>
                                        </div>
                                        <div class="item" data-slide-number="3">
                                            <img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDamsLabs/labs/xDamsLabsxDamsPhoto/0?imageName=/high//IT/XDAMSXD/AMSLAB/SFT000/IT.XDAMSXD.AMSLAB.SFT000.0013.jpg" class="img-responsive"/>
                                            <div class="carousel-caption">
                                                <h3>Titolo della terza slide</h3>
                                                <p>se vuoi  anche il sottotitolo</p>
                                            </div>
                                        </div>
                                        <div class="item" data-slide-number="4">
                                            <img src="http://battipaglia.thearchivescloud.org/wp-content/uploads/2016/04/trofeo-e1459525107930.jpg" class="img-responsive"/>
                                            <div class="carousel-caption">
                                                <h3>Titolo della prima slide</h3>
                                                <p>se vuoi  anche il sottotitolo</p>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- main slider carousel nav controls --> 
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>

                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/main slider carousel-->
                    <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">

                        <!-- thumb navigation carousel items -->
                        <ul class="list-inline">
                            <li><a id="carousel-selector-0" class="selected"><img src="http://placehold.it/80x60&amp;text=one" class="img-responsive"></a></li>
                            <li><a id="carousel-selector-1"><img src="http://placehold.it/80x60&amp;text=two" class="img-responsive"></a></li>
                            <li><a id="carousel-selector-2"><img src="http://placehold.it/80x60&amp;text=three" class="img-responsive"></a></li>
                            <li><a id="carousel-selector-3"><img src="http://placehold.it/80x60&amp;text=four" class="img-responsive"></a></li>
                            <li><a id="carousel-selector-4"><img src="http://placehold.it/80x60&amp;text=five" class="img-responsive"></a></li>

                        </ul>

                    </div>
                </div>






            </div>

        </div>



        <script>
            $("#myCarousel").carousel({
                interval: 4000
            });

            // handles the carousel thumbnails
            $("[id^=carousel-selector-]").click( function(){
                var id_selector = $(this).attr("id");
                var id = id_selector.substr(id_selector.length -1);
                id = parseInt(id);
                $("#myCarousel").carousel(id);
                $("[id^=carousel-selector-]").removeClass("selected");
                $(this).addClass("selected");
            });

            // when the carousel slides, auto update
            $("#myCarousel").on("slid", function (e) {
                var id = $(".item.active").data("slide-number");
                id = parseInt(id);
                $("[id^=carousel-selector-]").removeClass("selected");
                $("[id=carousel-selector-"+id+"]").addClass("selected");
            });
        </script> ';

		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		