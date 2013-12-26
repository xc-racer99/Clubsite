<?php
echo $this->Html->meta('icon');
echo $this->Html->css('/ccss/bootstrap.min.css,fullcalendar.css,datepicker.css,jquery.fancybox.css,leaflet.css,whyjustrun.css');

echo "<!--[if lte IE 8]>";
echo $this->Html->css('leaflet.ie');
echo "<![endif]-->";

echo $this->element('Series/css', array(), array('cache' => array('key' => 'series_css_club_'.Configure::read('Club.id'), 'config' => 'view_short')));

// Custom club CSS uploaded through the admin interface
if(!empty($clubResources['style'])) {
    echo $this->Html->css($clubResources['style']);
}

echo "<!--[if lt IE 9]>";
// Fix CSS selectors using html5 elements
echo $this->Html->script('html5.ie');
echo "<![endif]-->";
echo $this->Html->script("/cjs/jquery-1.8.2.min.js,jquery.mousewheel-3.0.6.pack.js,jquery.ketchup.all.min.js,ketchup-bootstrap.js,jquery.fancybox.pack.js,jquery.placeholder.min.js,underscore-min.js,knockout.js,jquery.jeditable.mini.js,jquery.timeago.js,jquery.iecors.js,xdate.js,browserdetect.js");
echo $this->Html->script('/cjs/bootstrap.min.js,bootstrap-datepicker.js,bootstrap-typeahead.js');
echo $this->Html->script('wjr');

// Easy editable content blocks
if($this->Session->read('Club.'.Configure::read('Club.id').'.Privilege.ContentBlock.edit')) {
    echo $this->Html->script("/cjs/jquery.jeditable.mini.js,wjr-logged-in.js");
}

echo $this->Html->script('cakebootstrap');

echo $this->fetch('open_graph');
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" href="/apple-touch-icon.png" />

