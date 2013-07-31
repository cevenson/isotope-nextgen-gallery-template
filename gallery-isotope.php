<?php 
/**
Template Page for the gallery overview

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>

 <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.isotope.min.js" type="text/javascript"></script>

<style type="text/css">

/**** centre nav and put at bottom ****/
.ngg-navigation{
	position: absolute;
	bottom: 3px;
	left: 20%;
	right: 20%;
}

#isotopegallery{
	padding-bottom: 40px;
}

/**** Isotope Filtering ****/

.isotope-item {
  z-index: 2;
}

.isotope-hidden.isotope-item {
  pointer-events: none;
  z-index: 1;
}

/**** Isotope CSS3 transitions ****/

.isotope,
.isotope .isotope-item {
  -webkit-transition-duration: 0.8s;
     -moz-transition-duration: 0.8s;
      -ms-transition-duration: 0.8s;
       -o-transition-duration: 0.8s;
          transition-duration: 0.8s;
}

.isotope {
  -webkit-transition-property: height, width;
     -moz-transition-property: height, width;
      -ms-transition-property: height, width;
       -o-transition-property: height, width;
          transition-property: height, width;
}

.isotope .isotope-item {
  -webkit-transition-property: -webkit-transform, opacity;
     -moz-transition-property:    -moz-transform, opacity;
      -ms-transition-property:     -ms-transform, opacity;
       -o-transition-property:         top, left, opacity;
          transition-property:         transform, opacity;
}

/**** disabling Isotope CSS3 transitions ****/

.isotope.no-transition,
.isotope.no-transition .isotope-item,
.isotope .isotope-item.no-transition {
  -webkit-transition-duration: 0s;
     -moz-transition-duration: 0s;
      -ms-transition-duration: 0s;
       -o-transition-duration: 0s;
          transition-duration: 0s;
}

.photo{
	float:left;
	margin:10px;
}

#filters{
  margin-left:0;
      -moz-border-radius: 6px;
  -webkit-border-radius: 6px;
  border-radius: 6px; /* future proofing */
  -khtml-border-radius: 6px; /* for old Konqueror browsers */
  border: #666666 1px solid;
 background: #e2e2e2; /* Old browsers */
background: -moz-linear-gradient(top, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(50%,#dbdbdb), color-stop(51%,#d1d1d1), color-stop(100%,#fefefe)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* IE10+ */
background: linear-gradient(top, #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* W3C */
}

#filters li{
  float:left;
  list-style-type: none;
  padding:5px;
  margin:5px 8px;
}

#filters li a{
  color:#444;
  text-transform:uppercase;
  font-weight:bold;
  -webkit-text-shadow: 0px 1px 1px #fff;
  -moz-text-shadow: 0px 1px 1px #fff;
  -o-text-shadow: 0px 1px 1px #fff;
  text-shadow: 0px 1px 1px #fff;
 
}

#filters li a:hover{
  color:#000;
  text-decoration:none;
}

</style>

  <script>
    $(function(){
      
      var $container = $('#isotopegallery');
      
      $container.isotope({
        itemSelector: '.photo'
      });
      
      $('#filters a').click(function(){
  var selector = $(this).attr('data-filter');
  $container.isotope({ filter: selector });
  return false;
});
    });
  </script>

    

<ul id="filters" class="clearfix">
  <li><a href="#" data-filter="*">show all</a></li>
  <li><a href="#" data-filter=".plants">plants</a></li>
  <li><a href="#" data-filter=".flower">flowers</a></li>
  <li><a href="#" data-filter=".beach">beach</a></li>
  <li><a href="#" data-filter=".landscape">landscape</a></li>
  <li><a href="#" data-filter=".building">buildings</a></li>
  <li><a href="#" data-filter=":not(.flower)">not flowers</a></li>
  <li><a href="#" data-filter=":not(.beach, .building)">not beach or buildings</a></li>
</ul>


<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>
 
<div id="isotopegallery" class="photos clearfix" id="<?php echo $gallery->anchor ?>">
 
        <?php
                //Used to break down and extract the width and height of each image
                function get_string_between($string, $start, $end){
                        $string = " ".$string;
                        $ini = strpos($string,$start);
                        if ($ini == 0) return "";
                        $ini += strlen($start);
                        $len = strpos($string,$end,$ini) - $ini;
                        return substr($string,$ini,$len);
                }
        ?>
 
        <!-- Thumbnails -->
        <?php foreach ( $images as $image ) : ?>
               
               
                <?php if ( !$image->hidden ) {
                        //GET the Size parameters for each image. this i used to size the div box that the images goes inside of.
                        $the_size_string = $image->size;
                        $thewidth = get_string_between($the_size_string, "width=\"", "\"");
                        $theheight = get_string_between($the_size_string, "height=\"", "\"");
                        $divstyle = 'width:'.$thewidth.'px; height:'.$theheight.'px;'; 
                }?>
               
 
                        <?php
                                //Get the TAGS for this image  
                                $tags = wp_get_object_terms($image->pid,'ngg_tag');
                                $tag_string = ''; //store the list of strings to be put into the class menu for isotpe filtering       
                                ?>
                                <?php foreach ( $tags as $tag ) : ?>     
                                  <?php $tag_string = $tag_string.$tag->slug.' ';  //alternativley can use $tag->name;, slug with put hyphen between words ?>      
                                <?php endforeach; ?>   
                                               
                <div class="photo <?php echo $tag_string ?>" style="<?php echo $divstyle; ?>">
                        <a href="<?php echo $image->imageURL ?>" title="<?php echo $image->description ?>" <?php echo $image->thumbcode ?> >
                                <?php if ( !$image->hidden ) { ?>
                                <img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->thumbnailURL ?>" />
                                <?php } ?>
                        </a>
                </div> 
       
                <?php if ( $image->hidden ) continue; ?>
                <?php if ( $gallery->columns > 0 && ++$i % $gallery->columns == 0 ) { ?>
                        <br style="clear: both" />
                <?php } ?>
 
        <?php endforeach; ?>
       
        <!-- Pagination -->
        <?php echo $pagination ?>
       
</div>
 
<?php endif; ?>