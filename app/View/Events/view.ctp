<header class="page-header">
    <div class="pull-right btn-toolbar">
        <div class="btn-group">
            <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="icon-download-alt icon-white"></i> Export
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php if($edit) { ?>
                  <li><a href="/events/printableEntries/<?= $event['Event']['id'] ?>">Printable List</a></li>
                <?php } ?>
                <li><a href="/events/view/<?= $event['Event']['id'] ?>.xml">IOF XML</a></li>
            </ul>
        </div>
        <?php if($edit) { ?>
            <div class="btn-group">
              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon-cog icon-white"></i> Edit
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="/events/edit/<?= $event['Event']['id'] ?>">Event</a></li>
                  <li><a href="/events/edit/<?= $event['Event']['id'] ?>">Courses</a></li>
                  <li><a href="/events/editResults/<?= $event['Event']['id'] ?>">Registrations/Results</a></li>
                  <li><a href="/events/uploadMaps/<?= $event['Event']['id'] ?>">Course Maps</a></li>
              </ul>
            </div>
    
            <div class="btn-group">
                <a class="btn btn-danger" href="/events/delete/<?= $event['Event']['id'] ?>" onclick='return confirm("Delete this event (including any defined organizers, courses and results)?");'><i class="icon-trash icon-white"></i></a>
            </div>
        <?php } ?>
    </div>

	<h1 class="series-<?= $event["Series"]["id"]; ?> event-header"><?= $event["Event"]["name"]; ?> <small class="series-<?= $event["Series"]["id"]; ?> event-header"><?= $event["Series"]["name"] ?></small></h1>
	
	<h2 class="event-header"><?php $date = new DateTime($event["Event"]["date"]); echo $date->format("F jS Y g:ia"); ?></h2>
    <? if(!empty($event["Event"]["custom_url"])) {?>
    <h2 class="event-header">External website: <?= $this->Html->link($event["Event"]["custom_url"])?></h2>
    <?}?>
</header>

<div class="row">
<?php if($event["Event"]["results_posted"] === '0' ) { 
// Show event information
?>
	<div class="span8">
		<?php echo $this->element('Events/info', array('event' => $event)); ?>
	</div>
	
	<?php if($event["Event"]["completed"] === true) { ?>
	<div class="results span4">
        <?php echo $this->element('Courses/course_maps', array('courses' => $event["Course"])); ?>
	</div>
	<?php } elseif(count($event["Course"]) === 0) { ?>
		<div class="results span4">
			<header>
				<h2>Course Registration</h2>
			</header>
			<p>No courses have been posted yet.</p>
		</div>
 	<?php } else { ?>
	<div class="results span4">
		<header>
			<h2>Course Registration</h2>
		</header>
		<div class="courses">
			<?php foreach($event["Course"] as $course) { ?>
			<div class="course">
				<div class="course-info">
					<div class="pull-right">
						<?php if($course["registered"] === false) { ?>
                            <div class="btn-group">
                                <a class="btn btn-success" href="/courses/register/<?= $course['id'] ?>"><i class="icon-plus icon-white"></i> Register</a>
                                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/courses/register/<?= $course['id'] ?>/needsRide"><i class="icon-user"></i> Register (Need ride)</a></li>
                                    <li><a href="/courses/register/<?= $course['id'] ?>/offeringRide"><i class="icon-road"></i> Register (Offer ride)</a></li>
                                </ul>
                            </div>
						<? } else { ?>
    						<div class="btn-group">
                                <a class="btn btn-danger" href="/courses/unregister/<?= $course['id'] ?>">
                                    <i class="icon-minus icon-white"></i> Unregister
                                </a>
                            </div>
						<?php } ?>
					</div>
					
					<h3><?= $course["name"] ?></h3>
					<span>
					<?= $course["description"] ?>
					<p>
					<?php
					if(!empty($course["distance"])) {
						echo "<br/><strong>Distance</strong>: ${course['distance']}m";
					}
					if(!empty($course["climb"])) {
						echo "<br/><strong>Climb</strong>: ${course['climb']}m";
					}
					?>
					</p>
					</span>
				</div>
				<div class="results-list">
					<?php echo $this->element('Results/list', array('results' => $course["Result"])); ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	</div>
	<?php } ?>
<?php } else {
// Show results page
?>
<div class="column span6">
	<div class="results padded">
		<header>
			<h2>Results</h2>
		</header>
        <?php echo $this->element('Events/files', array('id' => $event["Event"]["id"])); ?>
		<div class="results-list">
		<?= $this->Html->script('result_viewer'); ?>          		
				<div id="list" class="result-list" data-result-list-url="<?= Configure::read('Rails.domain') ?>/iof/3.0/events/<?= $event['Event']['id'] ?>/result_list.xml">
                    <div data-bind="foreach: courses">
            			<h3 data-bind="text: name"></h3>
            			<div data-bind="if: results().length == 0">
            				<p><b>No results</b></p>
            			</div>
            			<div data-bind="if: results().length > 0">
            				<table class="table table-striped table-bordered table-condensed">
            					<thead>
            						<tr>
            							<th>#</th>
            							<th>Participant</th>
            							<th>Time</th>
            							<th>Points</th>
            						</tr>
            					</thead>
            					<tbody data-bind="foreach: results">
            						<tr>
            							<td data-bind="text: position || friendlyStatus"></td>
            							<td><a data-bind="attr: { href: person.profileUrl }"><span data-bind="text: person.givenName + ' ' + person.familyName"></span></a></td>
            							<td data-bind="text: time != null ? hours + ':' + minutes + ':' + seconds : ''"></td>
            							<td data-bind="text: scores['WhyJustRun']"></td>
            						</tr>
            					</tbody>
            				</table>
            			</div>
            		</div>
                </div>
        <?php echo $this->element('Courses/course_maps', array('courses' => $event["Course"])); ?>
		</div>
	</div>
</div>
<div class="column span6">
	<?php echo $this->element('Events/info', array('event' => $event)); ?>
</div>
<?php } ?>
</div>