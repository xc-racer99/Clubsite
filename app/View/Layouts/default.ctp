<!DOCTYPE html>
<html lang=en>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# event: http://ogp.me/ns/event#">
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>

        <?= $this->element('layout_dependencies') ?>
        <?= $scripts_for_layout ?>
    </head>
    <body>
        <header class="header hidden-xs">
            <?php if(!empty($clubResources['headerImage'])) { ?>
            <a href="/">
                <img class="fitting-image center-block" width="1300px" src="<?= $clubResources['headerImage_1300']; ?>" data-2x-src="<?= $clubResources['headerImage_2600']; ?>" />
            </a>
            <? } else { ?>
            <h1><?= Configure::read('Club.name') ?></h1>
            <? } ?>
        </header>
        <div id="content">
            <?php
            // When the page doesn't exist, CakePHP can't find the controller and doesn't load the Menu helper.
            if(!empty($this->Menu)) { ?>
            <nav class="navbar navbar-colored navbar-squared-top navbar-constrained-width" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand visible-xs"><?= Configure::read('Club.acronym'); ?></a>
                    </div>

                    <div class="collapse navbar-collapse" id="main-navbar-collapse">
                        <ul class="nav navbar-nav navbar-nav-main-text">
                            <?php 
                            echo $this->Menu->item('Home', '/', '', true);
                            echo $this->Menu->item('Calendar', '/events/index'); 
                            echo $this->Menu->item('Maps', '/maps/');
                            echo $this->Menu->item('Resources', '/pages/resources');
                            echo $this->Menu->item('Contact', '/pages/contact');
                            ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-nav-main-text navbar-right">
                            <?php
                            if($this->Session->check('Auth.User.id')) {
                                echo $this->Menu->item('My Profile', Configure::read('Rails.profileURL').$this->Session->read('Auth.User.id'), 'menu_login');
                                echo $this->Menu->item('Sign out', '/users/logout/', 'menu_login');
                            } else {
                                echo $this->Menu->item('Sign in/Sign up', '/users/login/', 'menu_login');
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php } ?>
            <div class="container">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Session->flash('auth'); ?>
                <?php echo $content_for_layout; ?>
            </div>
        </div>
        <footer class="main-footer">
            <div class="container">
                <a href="<?= Configure::read("Rails.domain") ?>">whyjustrun.ca</a>
                <span class="pull-right">
                    <?= $this->element('privileged_link', array('name' => 'Event Planner', 'url' => '/events/planner', 'privilege' => 'Privilege.Event.planning', 'suffix' => ' |')) ?>
                    <?= $this->element('privileged_link', array('name' => 'Admin', 'url' => '/pages/admin', 'privilege' => 'Privilege.Admin.page', 'suffix' => ' |')) ?> 

                    <?= $this->Html->link('API', 'https://github.com/OrienteerApp/OrienteerApp/wiki/API') ?> | 
                    <?= $this->Html->link('Get this website for your club', 'https://github.com/OrienteerApp/OrienteerApp/wiki/Get-OrienteerApp-for-your-club!') ?>
                </span>
            </div>
            <div class="container">
                <span id="copyright">
                    &copy; <?= date('Y').' '.Configure::read('Club.name') ?>
                </span>
                <span id="credits" class="pull-right">
                    By <a href="">Thomas Nipen</a> and <a href="http://www.russellporter.com">Russell Porter</a> | <a href="mailto:support@whyjustrun.ca">support@whyjustrun.ca</a>
                </span>
            </div>
        </footer>
        <?= $this->element('sql_dump') ?>
        <?= $this->element('google_analytics') ?>
    </body>
</html>

