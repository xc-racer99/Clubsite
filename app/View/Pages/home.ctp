<?php $this->set('title_for_layout', Configure::read("Club.name")); ?>

<div class="three-column row">
	<article class="column span4">
        <?= $this->ContentBlock->render('general_information'); ?>
	</article>
	
	<article class="column span4">
		<header>
		  <h2>Club Events</h2>
		</header>
		<?php echo $this->element('Events/box-list', array('filter' => 'upcoming', 'limit' => '4')); ?>
		

		<h3>Past</h3>
		<?php echo $this->element('Events/box-list', array('filter' => 'past', 'limit' => '2')); ?>

		<h3>Major</h3>
		<?php echo $this->element('Events/box-list', array('filter' => 'major', 'limit' => '20')); ?>
        
        <div style="text-align: center">
            <?= $this->element('Events/add_link'); ?>
        </div>
	</article>
	
	<article class="column span4">
		<header>
		<h2>News</h2>
		</header>
		
		<?= $this->FacebookGraph->feed('news', array('limit' => 5)); ?>
      
	</article>
</div>
